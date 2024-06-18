<?php
require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try{
        if(isset($_POST['submit_review'])) {

            $name = $_POST['name'];
            $comment = $_POST['comment'];
    
            $stmt = $pdo->prepare("INSERT INTO reviews (name, comment, validate) VALUES (?, ?, 0)");
            if($stmt->execute([$name, $comment])) {
                $_SESSION['message'] = "Votre avis a bien été envoyé. Merci de votre contribution !";
            } else {
                $_SESSION['error'] = "Nous avons rencontré un problème. Merci de recommencer ultérieurement.";
            }
    
            header('Location: index.php#review');
            exit();
        }
        // Validation / Invalidation par l'employé
        if(isset($_POST['action'])) {
            $id = $_POST['id'];
            $action = $_POST['action'];
            
            if ($action === 'validate') {
                $status = 1;
            } elseif ($action === 'invalidate') {
                $status = 2;
            }

            $stmt = $pdo->prepare("UPDATE reviews SET validate = ? WHERE id = ?");
            if($stmt->execute([$status, $id])) {
                $_SESSION['message'] = "L'avis a bien été traité";
            } else {
                $_SESSION['error'] = "Erreur lors du traitement de l'avis.";
            }

        header('Location: employe.php');
        exit();
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}