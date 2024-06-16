<?php

require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php"; 
require_once __DIR__. "/lib/user.php";
require_once __DIR__. "/lib/send_email.php";

if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'administrateur') {
    header('Location: index.php');
    exit();
}

$stmtServices = $pdo->query('SELECT * FROM services');
$services = $stmtServices->fetchAll();

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
            $res = $stmt->execute([$email, $password, $role]);
        // Envoyer mail de confirmation
            $_SESSION['message'] = "Compte utilisateur crée avec succès.";
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
            $picture = 'assets/main/services/' . basename($_FILES['add_picture']['name']);
            
            // Déplacer l'image uploadée dans le répertoire souhaité
            if(move_uploaded_file($_FILES['add_picture']['tmp_name'], $picture)) {
            
                $stmt = $pdo->prepare('INSERT INTO services (name, description, picture) VALUES (?, ?, ?)');
                $stmt->execute([$name, $description, $picture]);
                $_SESSION['message'] = "Service ajouté avec succès.";
                
            } else {
                $_SESSION['error'] = "Erreur lors de la création du service.";
            }

            header('Location: administrateur.php');
            exit();

        // Mise à jour d'un service
        } elseif (isset($_POST['update_service'])) {
            // stockage données du formulaire
            $id = $_POST['id'];
            $name = $_POST['ud_name'];
            $description = $_POST['ud_description'];
            $picture = 'assets/main/services/' . basename($_FILES['ud_picture']['name']);

            if ($_FILES['ud_picture']['error'] == 0) {
                if(move_uploaded_file($_FILES['ud_picture']['tmp_name'], $picture)) {
                $stmt = $pdo->prepare('UPDATE services SET name = ?, description = ?, picture = ? WHERE id = ?');
                $res = $stmt->execute([$name, $description, $picture, $id]);
                $_SESSION['message'] = "Service mis à jour avec succès.";
                
                } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour du service.";
                }
            } else {
                $stmt = $pdo->prepare('UPDATE services SET name = ?, description = ? WHERE id = ?');
                $res = $stmt->execute([$name, $description, $id]);
                $_SESSION['message'] = "Service mis à jour avec succès.";
            }

            header('Location: administrateur.php');
            exit();

        // Suppression d'un service
        } elseif (isset($_POST['delete_service'])) {
            // stockage données du formulaire
            $id = $_POST['id'];
            $stmt = $pdo->prepare('DELETE FROM services WHERE id = ?');
            $res = $stmt->execute([$id]);
            $_SESSION['message'] = "Service supprimé avec succès.";

            header('Location: administrateur.php');
            exit();
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}
