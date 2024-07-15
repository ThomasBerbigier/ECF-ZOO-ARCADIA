<?php

require 'vendor/autoload.php';
require_once __DIR__. "/lib/session.php";
require_once __DIR__. "/lib/pdo.php"; 
require_once __DIR__. "/lib/user.php";
require_once __DIR__. "/lib/send_email.php";

use MongoDB\Client;

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'administrateur') {
    header('Location: index.php');
    exit();
}

// Récupère tous les services
$sql = 'SELECT * FROM services';
try {
    $stmtServices = $pdo->query($sql);
}catch (Exception $e) {
    $_SESSION['error'] = " Erreur ! " . $e->getMessage();
}
$services = $stmtServices->fetchAll();

// Récupère tous les horaires
$sql = 'SELECT * FROM schedule';
try {
    $stmtSchedules = $pdo->query($sql);
}catch (Exception $e) {
    $_SESSION['error'] = " Erreur ! " . $e->getMessage();
}
$schedules = $stmtSchedules->fetchAll();

// Récupère tous les habitats
$sql = 'SELECT * FROM habitats';
try {
    $stmtHabitats = $pdo->query($sql);
}catch (Exception $e) {
    $_SESSION['error'] = " Erreur ! " . $e->getMessage();
}
$habitats = $stmtHabitats->fetchAll();

// Récupère tous les animaux
$sql = 'SELECT * FROM animals';
try {
    $stmtAnimaux = $pdo->query($sql);
}catch (Exception $e) {
    $_SESSION['error'] = " Erreur ! " . $e->getMessage();
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
    $_SESSION['error'] = " Erreur ! " . $e->getMessage();
}
$reports = $stmtReports->fetchAll(PDO::FETCH_ASSOC);


// Récupération de la liste des animaux (pour le filtre animal)
$sql = "SELECT id, name FROM animals ORDER BY name";
try {
    $stmtFilter = $pdo->query($sql);
}catch (Exception $e) {
    $_SESSION['error'] = " Erreur ! " . $e->getMessage();
}
$animals_filter = $stmtFilter->fetchAll(PDO::FETCH_ASSOC);

// Accès BDDNR
//Heroku
if(getenv('ORMONGO_URL') !== false) {
    $connect = "mongodb://administrateur_arcadia:Mr7aF?nsozX4@iad2-c18-0.mongo.objectrocket.com:52011,iad2-c18-1.mongo.objectrocket.com:52011,iad2-c18-2.mongo.objectrocket.com:52011/zoo_arcadia?replicaSet=3ca8fb33ce9646b19289adf77e800551";
} else {
    // Local
    $connect = "mongodb://localhost:27017";
}
try {
    $client = new Client($connect);
    $collection = $client->zoo_arcadia->animals_clicks;
    // Récupère tous les documents de la collection, trie en ordre décroissant
    
    $cursor = $collection->find([], [
        'sort' => ['click_count' => -1]
    ]);    
}catch (Exception $e) {
    $_SESSION['error'] = " Erreur ! " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        // Création compte utilisateur
        if(isset($_POST['add_user'])) {
            // Récupérer les données du formulaire
            $email = filter_input(INPUT_POST, 'createEmail', FILTER_SANITIZE_EMAIL);
            $password = password_hash($_POST['createPassword'], PASSWORD_BCRYPT);
            $role = $_POST['selectRole'];
            
            // Vérifier que le rôle sélectionné est valide (employé ou vétérinaire)
            if (($role == 2 || $role == 3) && (!empty($email)) && (!empty($password))) {
                // Insérer le nouvel utilisateur
                $sql = 'INSERT INTO users (email, password, role_id) VALUES (?, ?, ?)';
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$email, $password, $role]);
                    $_SESSION['message'] = "Compte utilisateur crée avec succès. Mail de confirmation envoyé.";
                    // Envoyer mail de confirmation
                    sendEmail($email);
                } catch (Exception $e) {
                    $_SESSION['error'] = "Erreur lors de la création du compte.". $e->getMessage();
                }
            } else {
                $_SESSION['error'] = "Tous les champs doivent être remplis.";
            }
            header('Location: administrateur.php');
            exit();
        }
        
        // CRUD HORAIRE
        // Ajout d'un horaire
        if(isset($_POST['add_schedule'])) {
            // stockage données formulaire
            $day = filter_input(INPUT_POST, 'add_days', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $hour = filter_input(INPUT_POST,'add_hours', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if ((!empty($day)) && (!empty($hour))) {
                $sql = 'INSERT INTO schedule (day, hour) VALUES (?, ?)';
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$day, $hour]);
                    $_SESSION['message'] = "Horaire ajouté avec succès.";
                } catch (Exception $e) {
                    $_SESSION['error'] = "Erreur lors de l'ajout de l'horaire.". $e->getMessage();
                }
            } else {
                $_SESSION['error'] = "Tous les champs doivent être remplis.";
            }
            header('Location: administrateur.php');
            exit(); 
        }     
        // Mise à jour d'un horaire
        if (isset($_POST['update_schedule'])) {
            // stockage données formulaire
            $id = filter_input(INPUT_POST,'id', FILTER_VALIDATE_INT);
            $day = filter_input(INPUT_POST, 'ud_days', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $hour = filter_input(INPUT_POST, 'ud_hours', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if ((!empty($id)) && (!empty($day) || !empty($hour))) {
                $sql = 'UPDATE schedule SET day = ?, hour = ? WHERE id = ?';
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$day, $hour, $id]);
                    $_SESSION['message'] = "Horaire modifié avec succès.";
                    header('Location: administrateur.php');
                    exit();
                } catch (Exception $e) {
                    $_SESSION['error'] = "Erreur lors de la modification de l'horaire.". $e->getMessage();
                }
            }  else {
                $_SESSION['error'] = "Au moins un champ doit être rempli.";
            }
            header('Location: administrateur.php');
            exit(); 
        }
        // Supression d'un horaire
        if (isset($_POST['delete_schedule'])) {
            // stockage données formulaire
            $id = filter_input(INPUT_POST,'id', FILTER_VALIDATE_INT);
            
            if ((!empty($id))) {
                $sql = 'DELETE FROM schedule WHERE id = ?';
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$id]);
                    $_SESSION['message'] = "Horaire supprimé avec succès.";
                } catch (Exception $e) {
                    $_SESSION['error'] = "Erreur lors de la suppression de l'horaire.". $e->getMessage();
                } 
            }  else {
                $_SESSION['error'] = "Erreur lors de la suppression de l'horaire.";
            }
            header('Location: administrateur.php');
            exit();
        }
        // CRUD HABITAT
        // Création d'un Habitat
        if (isset($_POST['add_habitat'])) {
            // stockage données du formulaire
            $name = filter_input(INPUT_POST, 'add_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'add_description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // Sécurité attaques XSS
            $file_name = strip_tags($_FILES['add_picture']['name']);
            $file_size = $_FILES['add_picture']['size'];
            $file_tmp = $_FILES ['add_picture']['tmp_name'];
            $file_type = $_FILES['add_picture']['type'];
            
            $file_ext = explode('.', $file_name);
            $file_end = end($file_ext);
            $file_end = strtolower($file_end);
            $extensions  = [ 'jpeg', 'jpg', 'png', 'svg', "webp"];
            
            if(in_array($file_end, $extensions) === false) {
                $_SESSION['error'] = "Veuillez utiliser les extensions suivantes : JPEG, JPG , PNG , SVG, WEBP";
            } else if($file_size > 10000000) { 
                
                $_SESSION['error'] = "Le fichier est trop volumineux";
            } else {
                // Supprime les caractères spéciaux
                $file_name = preg_replace('/[^A-Za-z0-9.\-]/', '' ,$file_name);
                $file_bdd = "assets/main/habitats/habitats/".$file_name;
                // Déplacer l'image uploadée dans le répertoire souhaité
                move_uploaded_file($file_tmp, $file_bdd); 
                
                if ((!empty($name)) && (!empty($description)) && (!empty($file_bdd))) {
                    $sql = 'INSERT INTO habitats (name, description, picture) VALUES (?, ?, ?)';
                    try {
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$name, $description, $file_bdd]);
                        $_SESSION['message'] = "Habitat ajouté avec succès.";
                    } catch (Exception $e) {
                        $_SESSION['error'] = "Erreur lors de l'ajout de l'habitat'.". $e->getMessage();
                    } 
                } else {
                    $_SESSION['error'] = "Tous les champs doivent être remplis.";
                }
            }
            header('Location: administrateur.php');
            exit();
        }
            // Mise à jour d'un habitat
        if (isset($_POST['update_habitat'])) {
                // stockage données du formulaire
            $id = filter_input(INPUT_POST,'id', FILTER_VALIDATE_INT);
            $name = filter_input(INPUT_POST, 'ud_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'ud_description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                // Sécurité attaques XSS
            $file_name = strip_tags($_FILES['ud_picture']['name']);
            $file_size = $_FILES['ud_picture']['size'];
            $file_tmp = $_FILES ['ud_picture']['tmp_name'];
            $file_type = $_FILES['ud_picture']['type'];
            
            $file_ext = explode('.', $file_name);
            $file_end = end($file_ext);
            $file_end = strtolower($file_end);
            $extensions  = [ 'jpeg', 'jpg', 'png', 'svg', "webp"];
            
            if ($_FILES['ud_picture']['error'] == 0) {
                if(in_array($file_end, $extensions) === false) {
                    $_SESSION['error'] = "Veuillez utiliser les extensions suivantes : JPEG, JPG , PNG , SVG, WEBP";
                } elseif($file_size > 10000000) { 
                    
                    $_SESSION['error'] = "Le fichier est trop volumineux";
                } else {
                        // Supprime les caractères spéciaux
                    $file_name = preg_replace('/[^A-Za-z0-9.\-]/', '' ,$file_name);
                    $file_bdd = "assets/main/habitats/habitats/".$file_name;
                        // Déplacer l'image uploadée dans le répertoire souhaité
                    move_uploaded_file($file_tmp, $file_bdd); 
                    
                    if ((!empty($name)) && (!empty($description)) && (!empty($file_bdd)) && (!empty($id))) {
                        $sql = 'UPDATE habitats SET name = ?, description = ?, picture = ? WHERE id = ?';
                        try {
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([$name, $description, $file_bdd, $id]);
                            $_SESSION['message'] = "Habitat mis à jour avec succès.";
                        }catch (Exception $e) {
                            $_SESSION['error'] = "Erreur lors de la mise à jour de l'habitat'.". $e->getMessage();
                        }
                    }
                }
            } else {
                if ((!empty($name)) && (!empty($description)) && (!empty($id))) {
                    $sql = 'UPDATE habitats SET name = ?, description = ? WHERE id = ?';
                    try {
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$name, $description, $id]);
                        $_SESSION['message'] = "Habitat mis à jour avec succès.";
                    }catch (Exception $e) {
                            $_SESSION['error'] = "Erreur lors de la mise à jour de l'habitat'.". $e->getMessage();
                    }
                }
            }
            header('Location: administrateur.php');
            exit();
        }
            // Suppression d'un habitat
        if (isset($_POST['delete_habitat'])) {
                // stockage données du formulaire
            $id = filter_input(INPUT_POST,'id', FILTER_VALIDATE_INT);
            if ((!empty($id))) {
                $sql = 'DELETE FROM habitats WHERE id = ?';
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$id]);
                    $_SESSION['message'] = "Habitat supprimé avec succès.";
                } catch (Exception $e) {
                    $_SESSION['error'] = "Erreur lors de la suppression de l'habitat.". $e->getMessage();
                } 
            }
            header('Location: administrateur.php');
            exit();
        }
        
        // CRUD ANIMAUX
        // Création d'un Animal
        if (isset($_POST['add_animal'])) {
            // stockage données du formulaire
            $name = filter_input(INPUT_POST,'add_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $race = filter_input(INPUT_POST,'add_race', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $habitat = filter_input(INPUT_POST,'add_animal_habitat', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // Sécurité attaques XSS
            $file_name = strip_tags($_FILES['add_picture']['name']);
            $file_size = $_FILES['add_picture']['size'];
            $file_tmp = $_FILES ['add_picture']['tmp_name'];
            $file_type = $_FILES['add_picture']['type'];
            
            $file_ext = explode('.', $file_name);
            $file_end = end($file_ext);
            $file_end = strtolower($file_end);
            $extensions  = [ 'jpeg', 'jpg', 'png', 'svg', 'webp'];
            
            if(in_array($file_end, $extensions) === false) {
                $_SESSION['error'] = "Veuillez utiliser les extensions suivantes : JPEG, JPG , PNG , SVG, WEBP";
            } elseif($file_size > 10000000) { 
                $_SESSION['error'] = "Le fichier est trop volumineux";
            } else {
                // Supprime les caractères spéciaux
                $file_name = preg_replace('/[^A-Za-z0-9.\-]/', '' ,$file_name);
                $file_bdd = "assets/main/habitats/animaux/".$file_name;
                // Déplacer l'image uploadée dans le répertoire souhaité
                move_uploaded_file($file_tmp, $file_bdd); 
                
                if ((!empty($name)) && (!empty($race)) && (!empty($habitat)) && (!empty($file_bdd))) {
                    $sql = 'INSERT INTO animals (name, race, picture, habitat) VALUES (?, ?, ?, ?)';
                    try {
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$name, $race, $file_bdd, $habitat]);
                        $_SESSION['message'] = "Animal ajouté avec succès.";
                    }catch (Exception $e) {
                        $_SESSION['error'] = "Erreur lors de l'ajout de l'animal'.". $e->getMessage();
                    } 
                }
            }
            header('Location: administrateur.php');
            exit(); 
        }      
            // Mis à jour d'un animal
        if (isset($_POST['update_animal'])) {
                // stockage données du formulaire
            $id = filter_input(INPUT_POST,'id', FILTER_VALIDATE_INT);
            $name = filter_input(INPUT_POST,'ud_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $race = filter_input(INPUT_POST,'ud_race', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $habitat = filter_input(INPUT_POST,'ud_animal_habitat', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                // Sécurité attaques XSS
            $file_name = strip_tags($_FILES['ud_picture']['name']);
            $file_size = $_FILES['ud_picture']['size'];
            $file_tmp = $_FILES ['ud_picture']['tmp_name'];
            $file_type = $_FILES['ud_picture']['type'];
            
            $file_ext = explode('.', $file_name);
            $file_end = end($file_ext);
            $file_end = strtolower($file_end);
            $extensions  = [ 'jpeg', 'jpg', 'png', 'svg', 'webp'];
            
            if ($_FILES['ud_picture']['error'] == 0) {
                if(in_array($file_end, $extensions) === false) {
                    $_SESSION['error'] = "Veuillez utiliser les extensions suivantes : JPEG, JPG , PNG , SVG, WEBP";
                } elseif($file_size > 10000000) { 
                    
                    $_SESSION['error'] = "Le fichier est trop volumineux";
                } else {
                        // Supprime les caractères spéciaux
                    $file_name = preg_replace('/[^A-Za-z0-9.\-]/', '' ,$file_name);
                    $file_bdd = "assets/main/habitats/animaux/".$file_name;
                        // Déplacer l'image uploadée dans le répertoire souhaité
                    move_uploaded_file($file_tmp, $file_bdd); 
                    
                    if ((!empty($name) || !empty($race) || !empty($habitat) || !empty($file_bdd)) && (!empty($id))) {
                        $sql = 'UPDATE animals SET name = ?, race = ?, picture = ?, habitat = ? WHERE id = ?';
                        try {
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([$name, $race, $file_bdd, $habitat, $id]);
                            $_SESSION['message'] = "Animal mis à jour avec succès.";
                        } catch (Exception $e) {
                            $_SESSION['error'] = "Erreur lors de la mise à jour de l'animal'.". $e->getMessage();
                        } 
                    }
                }
            } else {
                if ((!empty($name) || !empty($race) || !empty($habitat)) && (!empty($id))) {
                    $sql = 'UPDATE animals SET name = ?, race = ?, habitat = ? WHERE id = ?';
                    try {
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$name, $race, $habitat, $id]);
                        $_SESSION['message'] = "Animal mis à jour avec succès.";
                    } catch (Exception $e) {
                        $_SESSION['error'] = "Erreur lors de la mise à jour de l'animal'.". $e->getMessage();
                    } 
                }
            }
            header('Location: administrateur.php');
            exit();
        }
            // Suppression d'un animal
        if (isset($_POST['delete_animal'])) {
            $id = filter_input(INPUT_POST,'id', FILTER_VALIDATE_INT);
            
            if (!empty($id)) {
                $sql = 'DELETE FROM animals WHERE id = ?';
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$id]);
                    $_SESSION['message'] = "Animal supprimé avec succès.";
                } catch (Exception $e) {
                    $_SESSION['error'] = "Erreur lors de la mise à jour de l'animal'.". $e->getMessage();
                }
            }
            header('Location: administrateur.php');
            exit();
        }
    }else {
        // Token CSRF invalide
        die("Token CSRF invalide.");
    }
}

require_once __DIR__. "/templates/header.php";
