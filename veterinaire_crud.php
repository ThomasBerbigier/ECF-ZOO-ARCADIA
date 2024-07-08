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
        $food = filter_input(INPUT_POST, 'food', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $food_weight = filter_input(INPUT_POST, 'food_weight', FILTER_VALIDATE_INT, ['options' => ['max_range' => 1000]]);
        $passage = $_POST['passage'];
        $detail = filter_input(INPUT_POST, 'detail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $animal_id = filter_input(INPUT_POST, 'animal_id', FILTER_VALIDATE_INT);
        
        if ((!empty($state)) && (!empty($food)) && (!empty($food_weight)) && (!empty($passage)) && (!empty($animal_id))) {
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
    }
    if(isset($_POST['add_comment'])) {
        
        $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $habitat = $_POST['selectHabitat'];
        
        if((!empty($comment)) && (!empty($habitat))) {
            $sql = 'UPDATE habitats SET comment = ? WHERE id = ?';
            try {
                $stmt = $pdo->prepare($sql);
                if($stmt->execute([$comment, $habitat])) {
                    $_SESSION['message'] = "Le commentaire a bien été envoyé.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur lors de la soumission du commentaire." . $e->getMessage();
            }
        }
        header('Location: veterinaire.php');
        exit();
        
    }
}
