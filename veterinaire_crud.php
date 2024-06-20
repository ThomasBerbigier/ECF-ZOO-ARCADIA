<?php

require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php"; 
require_once __DIR__. "/lib/user.php";

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'veterinaire') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST['add_report'])) {

        $state = $_POST['selectState'];
        $food = $_POST['food'];
        $food_weight = $_POST['food_weight'];
        $passage = $_POST['passage'];
        $detail = $_POST['detail'];
        $animal_id = $_POST['animal_id'];

        $stmt = $pdo->prepare('INSERT INTO reports (state, food, food_weight, passage, detail, animal_id)  VALUES(?, ?, ?, ?, ?, ?)');
        if($stmt->execute([$state, $food, $food_weight, $passage, $detail, $animal_id])) {
            $_SESSION['message'] = "Le compte rendu a bien été envoyé.";
        } else {
            $_SESSION['error'] = "Erreur lors de la soumission du compte rendu.";
        }
        header('Location: veterinaire.php');
        exit();
        
    }
    if(isset($_POST['add_comment'])) {

        $comment = $_POST['comment'];
        $habitat = $_POST['selectHabitat'];

        $stmt = $pdo->prepare('UPDATE habitats SET comment = ? WHERE id = ?');
        if($stmt->execute([$comment, $habitat])) {
            $_SESSION['message'] = "Le commentaire a bien été envoyé.";
        } else {
            $_SESSION['error'] = "Erreur lors de la soumission du commentaire.";
        }
        header('Location: veterinaire.php');
        exit();
        
    }
}
