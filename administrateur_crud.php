<?php

require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php"; 
require_once __DIR__. "/lib/user.php";
require_once __DIR__. "/lib/send_email.php";

$stmtServices = $pdo->query('SELECT * FROM services');
$services = $stmtServices->fetchAll();

$stmtSchedules = $pdo->query('SELECT * FROM schedule');
$schedules = $stmtSchedules->fetchAll();

$stmtHabitats = $pdo->query('SELECT * FROM habitats');
$habitats = $stmtHabitats->fetchAll();

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

        // Création d'un service
        if (isset($_POST['add_service'])) {
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
            } elseif($file_size > 3000000) { 
                
                $_SESSION['error'] = "Le fichier est trop volumineux";
            } else {
                // Supprime les caractères spéciaux
                $file_name = preg_replace('/[^A-Za-z0-9.\-]/', '' ,$file_name);
                $file_bdd = "assets/main/services/".$file_name;
                // Déplacer l'image uploadée dans le répertoire souhaité
                move_uploaded_file($file_tmp, $file_bdd); 
            
                $stmt = $pdo->prepare('INSERT INTO services (name, description, picture) VALUES (?, ?, ?)');
                $stmt->execute([$name, $description, $file_bdd]);
                $_SESSION['message'] = "Service ajouté avec succès.";
            }
            
            header('Location: administrateur.php');
            exit();

        // Mise à jour d'un service
        } else if (isset($_POST['update_service'])) {
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
                } elseif($file_size > 3000000) { 
                    
                    $_SESSION['error'] = "Le fichier est trop volumineux";
                } else {
                    // Supprime les caractères spéciaux
                    $file_name = preg_replace('/[^A-Za-z0-9.\-]/', '' ,$file_name);
                    $file_bdd = "assets/main/services/".$file_name;
                    // Déplacer l'image uploadée dans le répertoire souhaité
                    move_uploaded_file($file_tmp, $file_bdd); 
                
                    $stmt = $pdo->prepare('UPDATE services SET name = ?, description = ?, picture = ? WHERE id = ?');
                    $stmt->execute([$name, $description, $file_bdd, $id]);
                    $_SESSION['message'] = "Service mis à jour avec succès.";
                }
            } else {
                $stmt = $pdo->prepare('UPDATE services SET name = ?, description = ? WHERE id = ?');
                $stmt->execute([$name, $description, $id]);
                $_SESSION['message'] = "Service mis à jour avec succès.";
            }
            header('Location: administrateur.php');
            exit();

        // Suppression d'un service
        } else if (isset($_POST['delete_service'])) {
            // stockage données du formulaire
            $id = $_POST['id'];
            $stmt = $pdo->prepare('DELETE FROM services WHERE id = ?');
            if($stmt->execute([$id])) {
            $_SESSION['message'] = "Service supprimé avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la suppression du service.";
            }
            header('Location: administrateur.php');
            exit();
        }

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
        
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}



