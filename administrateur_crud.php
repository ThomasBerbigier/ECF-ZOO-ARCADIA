<?php

require 'vendor/autoload.php';
require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php"; 
require_once __DIR__. "/lib/user.php";
require_once __DIR__. "/lib/send_email.php";

use MongoDB\Client;

$stmtServices = $pdo->query('SELECT * FROM services');
$services = $stmtServices->fetchAll();

$stmtSchedules = $pdo->query('SELECT * FROM schedule');
$schedules = $stmtSchedules->fetchAll();

$stmtHabitats = $pdo->query('SELECT * FROM habitats');
$habitats = $stmtHabitats->fetchAll();

$stmtAnimaux = $pdo->query('SELECT * FROM animals');
$animals = $stmtAnimaux->fetchAll();

$animalFilter =  '';
$dateFilter =  '';

// Ajoute une clause SQL en fonction de l'animal sélectionné
if(isset($_GET['animal_id']) && is_numeric($_GET['animal_id'])) {
    $animalFilter = 'AND reports.animal_id = :animal_id';
}

// Ajoute une clause SQL en fonction de la date de passage
if(isset($_GET['report_date']) && !empty($_GET['report_date'])) {
    $dateFilter = 'AND DATE(reports.passage) = :report_date';
} 

$stmtReports = $pdo->prepare(
    "SELECT reports.id AS report_id, reports.state, reports.food, reports.food_weight, reports.passage, reports.detail, 
            animals.name AS animal_name
    FROM reports
    JOIN animals ON reports.animal_id = animals.id
    WHERE 1=1 
    $animalFilter 
    $dateFilter
    ORDER BY reports.passage DESC"
    );

// Liaison des paramètres nommés
if (!empty($animalFilter)) {
    $stmtReports->bindParam(':animal_id', $_GET['animal_id'], PDO::PARAM_INT);
}
if (!empty($dateFilter)) {
    // Si $_GET['report_date'] est une chaîne au format 'YYYY-MM-DD'
    $stmtReports->bindParam(':report_date', $_GET['report_date'], PDO::PARAM_STR);
}

$stmtReports->execute();
$reports = $stmtReports->fetchAll(PDO::FETCH_ASSOC);

// Récupération de la liste des animaux (pour le filtre animal)
$stmtFilter = $pdo->query("SELECT id, name FROM animals ORDER BY name");
$animals_filter = $stmtFilter->fetchAll(PDO::FETCH_ASSOC);

// Accès BDDNR
$client = new Client("mongodb://localhost:27017");
$collection = $client->zoo_arcadia->animals_clicks;
// Récupère tous les documents de la collection, trie en ordre décroissant
$cursor = $collection->find([], [
    'sort' => ['click_count' => -1]
]);

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'administrateur') {
    header('Location: index.php');
    exit();
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    try {
        // Création compte utilisateur
        if(isset($_POST['add_user'])) {
            // Récupérer les données du formulaire
            $email = $_POST['createEmail'];
            $password = password_hash($_POST['createPassword'], PASSWORD_BCRYPT);
            $role = $_POST['selectRole'];
        
        // Vérifier que le rôle sélectionné est valide (employé ou vétérinaire)
        if ($role == 2 || $role == 3) {
            // Insérer le nouvel utilisateur
            $stmt = $pdo->prepare('INSERT INTO users (email, password, role_id) VALUES (?, ?, ?)');
            $stmt->execute([$email, $password, $role]);
            // Envoyer mail de confirmation
            $_SESSION['message'] = "Compte utilisateur crée avec succès. Mail de confirmation envoyé.";
            sendEmail($email);
        } else {
            $_SESSION['error'] = "Erreur lors de la création du compte.";
        }
            header('Location: administrateur.php');
            exit();
        }
        
        // CRUD HORAIRE
        // Ajout d'un horaire
        if(isset($_POST['add_schedule'])) {
            // stockage données formulaire
            $day = $_POST['add_days'];
            $hour = $_POST['add_hours'];
            $stmt = $pdo->prepare('INSERT INTO schedule (day, hour) VALUES (?, ?)');
            if($stmt->execute([$day, $hour])){
            $_SESSION['message'] = "Horaire ajouté avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout de l'horaire.";
            }
            header('Location: administrateur.php');
            exit();
        // Mise à jour d'un horaire
        } else if (isset($_POST['update_schedule'])) {
            // stockage données formulaire
            $id = $_POST['id'];
            $day = $_POST['ud_days'];
            $hour = $_POST['ud_hours'];
            $stmt = $pdo->prepare('UPDATE schedule SET day = ?, hour = ? WHERE id = ?');
            if($stmt->execute([$day, $hour, $id])) {
            $_SESSION['message'] = "Horaire modifié avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la modification de l'horaire.";
            }
            header('Location: administrateur.php');
            exit();
        // Supression d'un horaire
        } else if (isset($_POST['delete_schedule'])) {
            // stockage données formulaire
            $id = $_POST['id'];
            $stmt = $pdo->prepare('DELETE FROM schedule WHERE id = ?');
            if($stmt->execute([$id])) {
            $_SESSION['message'] = "Horaire supprimé avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la suppression de l'horaire.";
            }
            header('Location: administrateur.php');
            exit();
        }
        // CRUD HABITAT
        // Création d'un Habitat
        if (isset($_POST['add_habitat'])) {
            // stockage données du formulaire
            $name = $_POST['add_name'];
            $description = $_POST['add_description'];
            // Sécurité attaques XSS
            $file_name = strip_tags($_FILES['add_picture']['name']);
            $file_size = $_FILES['add_picture']['size'];
            $file_tmp = $_FILES ['add_picture']['tmp_name'];
            $file_type = $_FILES['add_picture']['type'];

            $file_ext = explode('.', $file_name);
            $file_end = end($file_ext);
            $file_end = strtolower($file_end);
            $extensions  = [ 'jpeg', 'jpg', 'png', 'svg'];
            
            if(in_array($file_end, $extensions) === false) {
                $_SESSION['error'] = "Veuillez utiliser les extensions suivantes : JPEG, JPG , PNG , SVG";
            } elseif($file_size > 10000000) { 
                
                $_SESSION['error'] = "Le fichier est trop volumineux";
            } else {
                // Supprime les caractères spéciaux
                $file_name = preg_replace('/[^A-Za-z0-9.\-]/', '' ,$file_name);
                $file_bdd = "assets/main/habitats/habitats/".$file_name;
                // Déplacer l'image uploadée dans le répertoire souhaité
                move_uploaded_file($file_tmp, $file_bdd); 
            
                $stmt = $pdo->prepare('INSERT INTO habitats (name, description, picture) VALUES (?, ?, ?)');
                $stmt->execute([$name, $description, $file_bdd]);
                $_SESSION['message'] = "Habitat ajouté avec succès.";
            }
            
            header('Location: administrateur.php');
            exit();
            // Mis à jour d'un habitat
        } else if (isset($_POST['update_habitat'])) {
             // stockage données du formulaire
            $id = $_POST['id'];
            $name = $_POST['ud_name'];
            $description = $_POST['ud_description'];
             // Sécurité attaques XSS
            $file_name = strip_tags($_FILES['ud_picture']['name']);
            $file_size = $_FILES['ud_picture']['size'];
            $file_tmp = $_FILES ['ud_picture']['tmp_name'];
            $file_type = $_FILES['ud_picture']['type'];

            $file_ext = explode('.', $file_name);
            $file_end = end($file_ext);
            $file_end = strtolower($file_end);
            $extensions  = [ 'jpeg', 'jpg', 'png', 'svg'];

            if ($_FILES['ud_picture']['error'] == 0) {
                if(in_array($file_end, $extensions) === false) {
                    $_SESSION['error'] = "Veuillez utiliser les extensions suivantes : JPEG, JPG , PNG , SVG";
                } elseif($file_size > 10000000) { 
                    
                    $_SESSION['error'] = "Le fichier est trop volumineux";
                } else {
                     // Supprime les caractères spéciaux
                    $file_name = preg_replace('/[^A-Za-z0-9.\-]/', '' ,$file_name);
                    $file_bdd = "assets/main/habitats/habitats/".$file_name;
                     // Déplacer l'image uploadée dans le répertoire souhaité
                    move_uploaded_file($file_tmp, $file_bdd); 
                
                    $stmt = $pdo->prepare('UPDATE habitats SET name = ?, description = ?, picture = ? WHERE id = ?');
                    $stmt->execute([$name, $description, $file_bdd, $id]);
                    $_SESSION['message'] = "Habitat mis à jour avec succès.";
                }
            } else {
                $stmt = $pdo->prepare('UPDATE habitats SET name = ?, description = ? WHERE id = ?');
                $stmt->execute([$name, $description, $id]);
                $_SESSION['message'] = "Habitat mis à jour avec succès.";
            }
            header('Location: administrateur.php');
            exit();

         // Suppression d'un habitat
        } else if (isset($_POST['delete_habitat'])) {
             // stockage données du formulaire
            $id = $_POST['id'];
            $stmt = $pdo->prepare('DELETE FROM habitats WHERE id = ?');
            if($stmt->execute([$id])) {
            $_SESSION['message'] = "Habitat supprimé avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la suppression de l'habitat.";
            }
            header('Location: administrateur.php');
            exit();
        }
        // CRUD ANIMAUX
        // Création d'un Animal
        if (isset($_POST['add_animal'])) {
            // stockage données du formulaire
            $name = $_POST['add_name'];
            $race = $_POST['add_race'];
            $habitat = $_POST['add_animal_habitat'];
            // Sécurité attaques XSS
            $file_name = strip_tags($_FILES['add_picture']['name']);
            $file_size = $_FILES['add_picture']['size'];
            $file_tmp = $_FILES ['add_picture']['tmp_name'];
            $file_type = $_FILES['add_picture']['type'];

            $file_ext = explode('.', $file_name);
            $file_end = end($file_ext);
            $file_end = strtolower($file_end);
            $extensions  = [ 'jpeg', 'jpg', 'png', 'svg'];
            
            if(in_array($file_end, $extensions) === false) {
                $_SESSION['error'] = "Veuillez utiliser les extensions suivantes : JPEG, JPG , PNG , SVG";
            } elseif($file_size > 10000000) { 
                
                $_SESSION['error'] = "Le fichier est trop volumineux";
            } else {
                // Supprime les caractères spéciaux
                $file_name = preg_replace('/[^A-Za-z0-9.\-]/', '' ,$file_name);
                $file_bdd = "assets/main/habitats/animaux/".$file_name;
                // Déplacer l'image uploadée dans le répertoire souhaité
                move_uploaded_file($file_tmp, $file_bdd); 
            
                $stmt = $pdo->prepare('INSERT INTO animals (name, race, picture, habitat) VALUES (?, ?, ?, ?)');
                $stmt->execute([$name, $race, $file_bdd, $habitat]);
                $_SESSION['message'] = "Animal ajouté avec succès.";
            }
            
            header('Location: administrateur.php');
            exit();
            // Mis à jour d'un animal
        } else if (isset($_POST['update_animal'])) {
             // stockage données du formulaire
            $id = $_POST['id'];
            $name = $_POST['ud_name'];
            $race = $_POST['ud_race'];
            $habitat = $_POST['ud_animal_habitat'];
             // Sécurité attaques XSS
            $file_name = strip_tags($_FILES['ud_picture']['name']);
            $file_size = $_FILES['ud_picture']['size'];
            $file_tmp = $_FILES ['ud_picture']['tmp_name'];
            $file_type = $_FILES['ud_picture']['type'];

            $file_ext = explode('.', $file_name);
            $file_end = end($file_ext);
            $file_end = strtolower($file_end);
            $extensions  = [ 'jpeg', 'jpg', 'png', 'svg'];

            if ($_FILES['ud_picture']['error'] == 0) {
                if(in_array($file_end, $extensions) === false) {
                    $_SESSION['error'] = "Veuillez utiliser les extensions suivantes : JPEG, JPG , PNG , SVG";
                } elseif($file_size > 10000000) { 
                    
                    $_SESSION['error'] = "Le fichier est trop volumineux";
                } else {
                     // Supprime les caractères spéciaux
                    $file_name = preg_replace('/[^A-Za-z0-9.\-]/', '' ,$file_name);
                    $file_bdd = "assets/main/habitats/animaux/".$file_name;
                     // Déplacer l'image uploadée dans le répertoire souhaité
                    move_uploaded_file($file_tmp, $file_bdd); 
                
                    $stmt = $pdo->prepare('UPDATE animals SET name = ?, description = ?, picture = ?, habitat = ? WHERE id = ?');
                    $stmt->execute([$name, $race, $file_bdd, $habitat, $id]);
                    $_SESSION['message'] = "Animal mis à jour avec succès.";
                }
            } else {
                $stmt = $pdo->prepare('UPDATE animals SET name = ?, description = ?, habitat = ? WHERE id = ?');
                $stmt->execute([$name, $race, $habitat, $id]);
                $_SESSION['message'] = "Animal mis à jour avec succès.";
            }
            header('Location: administrateur.php');
            exit();

         // Suppression d'un animal
        } else if (isset($_POST['delete_animal'])) {
             // stockage données du formulaire
            $id = $_POST['id'];
            $stmt = $pdo->prepare('DELETE FROM animals WHERE id = ?');
            if($stmt->execute([$id])) {
            $_SESSION['message'] = "Animal supprimé avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la suppression de l'animal.";
            }
            header('Location: administrateur.php');
            exit();
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}



