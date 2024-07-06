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
        $food = htmlspecialchars($_POST['food'], ENT_QUOTES, 'UTF-8');
        $food_weight = htmlspecialchars($_POST['food_weight'], ENT_QUOTES, 'UTF-8');
        $date = $_POST['date'];
        $animal_id = $_POST['animal_id'];
        
        if ($food && $food_weight && $date && $animal_id) {
            $sql = "INSERT INTO foods (food, food_weight, date, animal_id) VALUES (?, ?, ?, ?)";
            try {
                $stmt = $pdo->prepare($sql);
                if($stmt->execute([$food, $food_weight, $date, $animal_id])) {
                    $_SESSION['message'] = "L'animal a bien été nourri.";
                }
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