<?php

require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php"; 
require_once __DIR__. "/lib/user.php";

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'employe') {
    header('Location: index.php');
    exit();
}

$stmtFoods = $pdo->query('SELECT * FROM foods');
$foods = $stmtFoods->fetchAll();

$stmtServices = $pdo->query('SELECT * FROM services');
$services = $stmtServices->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données du formulaire de nourrissage
    $food = $_POST['food'];
    $food_weight = $_POST['food_weight'];
    $date = $_POST['date'];
    $animal_id = $_POST['animal_id'];

    if(isset($_POST['add_food'])) {

        $stmt = $pdo->prepare("INSERT INTO foods (food, food_weight, date, animal_id) VALUES (?, ?, ?, ?)");
        if($stmt->execute([$food, $food_weight, $date, $animal_id])) {
            $_SESSION['message'] = "L'animal a bien été nourri.";
        } else {
            $_SESSION['error'] = "Erreur lors du nourrissage.";
        }
        header('Location: employe.php#foodSection');
        exit();
    }
    
}