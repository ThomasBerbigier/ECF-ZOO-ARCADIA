<?php
require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        // Insère l'avis en bdd pour que l'employé le récupère sur sa page
        if(isset($_POST['submit_review'])) {

            $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
            $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');

            $sql = "INSERT INTO reviews (name, comment, validate) VALUES (?, ?, 0)";

            try{
                $stmt = $pdo->prepare($sql);
                if($stmt->execute([$name, $comment])) {
                    $_SESSION['message'] = "Votre avis a bien été envoyé. Merci de votre contribution !";
                }
            } catch(Exception $e){
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

            $sql = "UPDATE reviews SET validate = ? WHERE id = ?";

            try {
                $stmt = $pdo->prepare($sql);
                
                if($stmt->execute([$status, $id])) {
                    $_SESSION['message'] = "L'avis a bien été traité";
                } 
            } catch(Exception $e){
                $_SESSION['error'] = "Erreur lors du traitement de l'avis.";
            }
        header('Location: employe.php');
        exit();
        }
}