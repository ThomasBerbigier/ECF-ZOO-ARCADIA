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
            
            if ((!empty($name)) && (!empty($description)) && (!empty($file_bdd))) {
                $sql = 'INSERT INTO services (name, description, picture) VALUES (?, ?, ?)';
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$name, $description, $file_bdd]);
                }catch (Exception $e) {
                    $_SESSION['error'] = "Erreur lors de l'ajout du service.". $e->getMessage();;
                }
                $_SESSION['message'] = "Service ajouté avec succès.";
            }
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
        
    // Mise à jour d'un service
    } else if (isset($_POST['update_service'])) {
        // stockage données du formulaire
        $id = filter_input(INPUT_POST,'id', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'add_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST, 'add_description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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
                
                if ((!empty($name)) && (!empty($description)) && (!empty($file_bdd)) && (!empty($id))) {
                    $sql = 'UPDATE services SET name = ?, description = ?, picture = ? WHERE id = ?';
                    try {
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$name, $description, $file_bdd, $id]);
                    }catch (Exception $e) {
                        $_SESSION['error'] = "Erreur lors de la mise à jour du service.". $e->getMessage();;
                    }
                    $_SESSION['message'] = "Service mis à jour avec succès.";
                }
            }
        } else {
            if ((!empty($name)) && (!empty($description)) && (!empty($id))) {
                $sql = 'UPDATE services SET name = ?, description = ? WHERE id = ?';
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$name, $description, $id]);
                }catch (Exception $e) {
                    $_SESSION['error'] = "Erreur lors de la mise à jour du service.". $e->getMessage();;
                }
                $_SESSION['message'] = "Service mis à jour avec succès.";
            }
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
        
    // Suppression d'un service
    } else if (isset($_POST['delete_service'])) {
        // stockage données du formulaire
        $id = filter_input(INPUT_POST,'id', FILTER_VALIDATE_INT);
        
        if ((!empty($id))) {
            $sql = 'DELETE FROM services WHERE id = ?';
            try {
                $stmt = $pdo->prepare($sql);
                if($stmt->execute([$id])) {
                    $_SESSION['message'] = "Service supprimé avec succès.";
                }
            }catch (Exception $e) {
                $_SESSION['error'] = "Erreur lors de la suppression du service.". $e->getMessage();;
            }
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}