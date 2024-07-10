<?php

require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php"; 
require_once __DIR__. "/lib/user.php";

// Vérification du role
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'employe') {
    header('Location: index.php');
    exit();
}

$sql = 'SELECT * FROM foods';
try {
    $stmtFoods = $pdo->query($sql);
}catch (Exception $e) {
    echo " Erreur ! " . $e->getMessage();
}
$foods = $stmtFoods->fetchAll();

$sql = 'SELECT * FROM services';
try {
    $stmtServices = $pdo->query($sql);
}catch (Exception $e) {
    echo " Erreur ! " . $e->getMessage();
}
$services = $stmtServices->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if(isset($_POST['add_food'])) {
        
        // Récupère les données du formulaire de nourrissage
        $food = filter_input(INPUT_POST, 'food', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $food_weight = filter_input(INPUT_POST, 'food_weight', FILTER_VALIDATE_INT, ['options' => ['max_range' => 1000]]);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $animal_id = filter_input(INPUT_POST, 'animal_id', FILTER_VALIDATE_INT);
        
        if ((!empty($food)) && (!empty($food_weight)) && (!empty($date)) && (!empty($animal_id))) {
            $sql = "INSERT INTO foods (food, food_weight, date, animal_id) VALUES (?, ?, ?, ?)";
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$food, $food_weight, $date, $animal_id]);
                $_SESSION['message'] = "L'animal a bien été nourri.";
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur lors du nourrissage.". $e->getMessage();;
            }
        } else {
            $_SESSION['error'] = "Données invalides fournies.";
        }
        header('Location: employe.php#foodSection');
        exit();
    }
    
}