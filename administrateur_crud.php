<?php

require 'vendor/autoload.php';
require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php"; 
require_once __DIR__. "/lib/user.php";
require_once __DIR__. "/lib/send_email.php";

use MongoDB\Client;

// Récupère tous les services
$sql = 'SELECT * FROM services';
try {
    $stmtServices = $pdo->query($sql);
}catch (Exception $e) {
    echo " Erreur ! " . $e->getMessage();
}
$services = $stmtServices->fetchAll();

// Récupère tous les horaires
$sql = 'SELECT * FROM schedule';
try {
    $stmtSchedules = $pdo->query($sql);
}catch (Exception $e) {
    echo " Erreur ! " . $e->getMessage();
}
$schedules = $stmtSchedules->fetchAll();

// Récupère tous les habitats
$sql = 'SELECT * FROM habitats';
try {
    $stmtHabitats = $pdo->query($sql);
}catch (Exception $e) {
    echo " Erreur ! " . $e->getMessage();
}
$habitats = $stmtHabitats->fetchAll();

// Récupère tous les animaux
$sql = 'SELECT * FROM animals';
try {
    $stmtAnimaux = $pdo->query($sql);
}catch (Exception $e) {
    echo " Erreur ! " . $e->getMessage();
}
$animals = $stmtAnimaux->fetchAll();

// Initialisation variables pour filtres
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

$sql = "SELECT reports.id AS report_id, reports.state, reports.food, reports.food_weight, reports.passage, reports.detail, 
            animals.name AS animal_name
    FROM reports
    JOIN animals ON reports.animal_id = animals.id
    WHERE 1=1 
    $animalFilter 
    $dateFilter
    ORDER BY reports.passage DESC";
try {
    $stmtReports = $pdo->prepare($sql);
    // Liaison des paramètres nommés
    if (!empty($animalFilter)) {
        $stmtReports->bindParam(':animal_id', $_GET['animal_id'], PDO::PARAM_INT);
    }
    if (!empty($dateFilter)) {
        // Si $_GET['report_date'] est une chaîne au format 'YYYY-MM-DD'
        $stmtReports->bindParam(':report_date', $_GET['report_date'], PDO::PARAM_STR);
    }
    $stmtReports->execute();
}catch (Exception $e) {
    echo " Erreur ! " . $e->getMessage();
}
$reports = $stmtReports->fetchAll(PDO::FETCH_ASSOC);


// Récupération de la liste des animaux (pour le filtre animal)
$sql = "SELECT id, name FROM animals ORDER BY name";
try {
    $stmtFilter = $pdo->query($sql);
}catch (Exception $e) {
    echo " Erreur ! " . $e->getMessage();
}
$animals_filter = $stmtFilter->fetchAll(PDO::FETCH_ASSOC);

// Accès BDDNR
$client = new Client("mongodb://localhost:27017");
$collection = $client->zoo_arcadia->animals_clicks;
// Récupère tous les documents de la collection, trie en ordre décroissant
try {
    $cursor = $collection->find([], [
        'sort' => ['click_count' => -1]
    ]);    
}catch (Exception $e) {
    echo " Erreur ! " . $e->getMessage();
}

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'administrateur') {
    header('Location: index.php');
    exit();
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Création compte utilisateur
    if(isset($_POST['add_user'])) {
        // Récupérer les données du formulaire
        $email = htmlspecialchars($_POST['createEmail'], ENT_QUOTES, 'UTF-8');
        $password = password_hash($_POST['createPassword'], PASSWORD_BCRYPT);
        $role = $_POST['selectRole'];
    
    // Vérifier que le rôle sélectionné est valide (employé ou vétérinaire)
    if ($role == 2 || $role == 3) {
        // Insérer le nouvel utilisateur
        $sql = 'INSERT INTO users (email, password, role_id) VALUES (?, ?, ?)';
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email, $password, $role]);
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la création du compte.". $e->getMessage();;
        }
        // Envoyer mail de confirmation
        $_SESSION['message'] = "Compte utilisateur crée avec succès. Mail de confirmation envoyé.";
        sendEmail($email);
    }
        header('Location: administrateur.php');
        exit();
    }
    
    // CRUD HORAIRE
    // Ajout d'un horaire
    if(isset($_POST['add_schedule'])) {
        // stockage données formulaire
        $day = htmlspecialchars($_POST['add_days'], ENT_QUOTES, 'UTF-8');
        $hour = htmlspecialchars($_POST['add_hours'], ENT_QUOTES, 'UTF-8');
        
        $sql = 'INSERT INTO schedule (day, hour) VALUES (?, ?)';
        try {
            $stmt = $pdo->prepare($sql);
            if($stmt->execute([$day, $hour])){
                $_SESSION['message'] = "Horaire ajouté avec succès.";
            }
        }catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de l'ajout de l'horaire.". $e->getMessage();;
        }
        header('Location: administrateur.php');
        exit();
        
    // Mise à jour d'un horaire
    } else if (isset($_POST['update_schedule'])) {
        // stockage données formulaire
        $id = $_POST['id'];
        $day = htmlspecialchars($_POST['ud_days'], ENT_QUOTES, 'UTF-8');
        $hour = htmlspecialchars($_POST['ud_hours'], ENT_QUOTES, 'UTF-8');
        
        $sql = 'UPDATE schedule SET day = ?, hour = ? WHERE id = ?';
        try {
            $stmt = $pdo->prepare($sql);
            if($stmt->execute([$day, $hour, $id])) {
                $_SESSION['message'] = "Horaire modifié avec succès.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la modification de l'horaire.". $e->getMessage();;
        }
        header('Location: administrateur.php');
        exit();
    
    // Supression d'un horaire
    } else if (isset($_POST['delete_schedule'])) {
        // stockage données formulaire
        $id = $_POST['id'];
        
        $sql = 'DELETE FROM schedule WHERE id = ?';
        try {
            $stmt = $pdo->prepare($sql);
            if($stmt->execute([$id])) {
                $_SESSION['message'] = "Horaire supprimé avec succès.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la suppression de l'horaire.". $e->getMessage();;
        } 
        header('Location: administrateur.php');
        exit();
    }
    
    // CRUD HABITAT
    // Création d'un Habitat
    if (isset($_POST['add_habitat'])) {
        // stockage données du formulaire
        $name = htmlspecialchars($_POST['add_name'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($_POST['add_description'], ENT_QUOTES, 'UTF-8');
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
        
            $sql = 'INSERT INTO habitats (name, description, picture) VALUES (?, ?, ?)';
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$name, $description, $file_bdd]);
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur lors de l'ajout de l'habitat'.". $e->getMessage();;
            } 
            $_SESSION['message'] = "Habitat ajouté avec succès.";
        }
        header('Location: administrateur.php');
        exit();
        
        // Mise à jour d'un habitat
    } else if (isset($_POST['update_habitat'])) {
            // stockage données du formulaire
        $id = $_POST['id'];
        $name = htmlspecialchars($_POST['ud_name'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($_POST['ud_description'], ENT_QUOTES, 'UTF-8');
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
                
                $sql = 'UPDATE habitats SET name = ?, description = ?, picture = ? WHERE id = ?';
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$name, $description, $file_bdd, $id]);
                }catch (Exception $e) {
                    $_SESSION['error'] = "Erreur lors de la mise à jour de l'habitat'.". $e->getMessage();;
                }
                $_SESSION['message'] = "Habitat mis à jour avec succès.";
            }
        } else {
            $sql = 'UPDATE habitats SET name = ?, description = ? WHERE id = ?';
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$name, $description, $id]);
            }catch (Exception $e) {
                    $_SESSION['error'] = "Erreur lors de la mise à jour de l'habitat'.". $e->getMessage();;
                }
            $_SESSION['message'] = "Habitat mis à jour avec succès.";
        }
        header('Location: administrateur.php');
        exit();
        
        // Suppression d'un habitat
    } else if (isset($_POST['delete_habitat'])) {
            // stockage données du formulaire
        $id = $_POST['id'];
        
        $sql = 'DELETE FROM habitats WHERE id = ?';
        try {
            $stmt = $pdo->prepare($sql);
            if($stmt->execute([$id])) {
                $_SESSION['message'] = "Habitat supprimé avec succès.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la suppression de l'habitat.". $e->getMessage();;
        } 
        header('Location: administrateur.php');
        exit();
    }
    
    // CRUD ANIMAUX
    // Création d'un Animal
    if (isset($_POST['add_animal'])) {
        // stockage données du formulaire
        $name = htmlspecialchars($_POST['add_name'], ENT_QUOTES, 'UTF-8');
        $race = htmlspecialchars($_POST['add_race'], ENT_QUOTES, 'UTF-8');
        $habitat = htmlspecialchars($_POST['add_animal_habitat'], ENT_QUOTES, 'UTF-8');
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
            
            $sql = 'INSERT INTO animals (name, race, picture, habitat) VALUES (?, ?, ?, ?)';
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$name, $race, $file_bdd, $habitat]);
            }catch (Exception $e) {
                $_SESSION['error'] = "Erreur lors de l'ajout de l'animal'.". $e->getMessage();;
            } 
            $_SESSION['message'] = "Animal ajouté avec succès.";
        }
        header('Location: administrateur.php');
        exit();
        
        // Mis à jour d'un animal
    } else if (isset($_POST['update_animal'])) {
            // stockage données du formulaire
        $id = $_POST['id'];
        $name = htmlspecialchars($_POST['ud_name'], ENT_QUOTES, 'UTF-8');
        $race = htmlspecialchars($_POST['ud_race'], ENT_QUOTES, 'UTF-8');
        $habitat = htmlspecialchars($_POST['ud_animal_habitat'], ENT_QUOTES, 'UTF-8');
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
                
                $sql = 'UPDATE animals SET name = ?, description = ?, picture = ?, habitat = ? WHERE id = ?';
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$name, $race, $file_bdd, $habitat, $id]);
                }catch (Exception $e) {
                    $_SESSION['error'] = "Erreur lors de la mise à jour de l'animal'.". $e->getMessage();;
                } 
                $_SESSION['message'] = "Animal mis à jour avec succès.";
            }
        } else {
            $sql = 'UPDATE animals SET name = ?, description = ?, habitat = ? WHERE id = ?';
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$name, $race, $habitat, $id]);
            }catch (Exception $e) {
                $_SESSION['error'] = "Erreur lors de la mise à jour de l'animal'.". $e->getMessage();;
            } 
            $_SESSION['message'] = "Animal mis à jour avec succès.";
        }
        header('Location: administrateur.php');
        exit();
        
        // Suppression d'un animal
    } else if (isset($_POST['delete_animal'])) {
            // stockage données du formulaire
        $id = $_POST['id'];
        
        $sql = 'DELETE FROM animals WHERE id = ?';
        try {
            $stmt = $pdo->prepare($sql);
            if($stmt->execute([$id])) {
                $_SESSION['message'] = "Animal supprimé avec succès.";
            }
        }catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la mise à jour de l'animal'.". $e->getMessage();;
        }
        header('Location: administrateur.php');
        exit();
    }

}



