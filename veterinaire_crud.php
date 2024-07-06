<?php

require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php"; 
require_once __DIR__. "/lib/user.php";

// Vérification du role
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'veterinaire') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST['add_report'])) {
        
        $state = $_POST['selectState'];
        $food = htmlspecialchars($_POST['food'], ENT_QUOTES, 'UTF-8');
        $food_weight = filter_input(INPUT_POST, 'food_weight', FILTER_VALIDATE_INT);
        $passage = $_POST['passage'];
        $detail = htmlspecialchars($_POST['detail'], ENT_QUOTES, 'UTF-8');
        $animal_id = $_POST['animal_id'];
        
        $sql = 'INSERT INTO reports (state, food, food_weight, passage, detail, animal_id)  VALUES(?, ?, ?, ?, ?, ?)';
        try {
            $stmt = $pdo->prepare($sql);
            if($stmt->execute([$state, $food, $food_weight, $passage, $detail, $animal_id])) {
                $_SESSION['message'] = "Le compte rendu a bien été envoyé.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la soumission du compte rendu." . $e->getMessage();
        }
        header('Location: veterinaire.php');
        exit();
        
    }
    if(isset($_POST['add_comment'])) {
        
        $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');
        $habitat = $_POST['selectHabitat'];
        
        $sql = 'UPDATE habitats SET comment = ? WHERE id = ?';
        try {
            $stmt = $pdo->prepare($sql);
            if($stmt->execute([$comment, $habitat])) {
                $_SESSION['message'] = "Le commentaire a bien été envoyé.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la soumission du commentaire." . $e->getMessage();
        }
        header('Location: veterinaire.php');
        exit();
        
    }
}
