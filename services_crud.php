<?php

require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php";

if (!isset($_SESSION['user']) || ($_SESSION['role'] !== 'employe' && $_SESSION['role'] !== 'administrateur')) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// CRUD SERVICE
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
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
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
        header('Location: ' . $_SERVER['HTTP_REFERER']);
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
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}