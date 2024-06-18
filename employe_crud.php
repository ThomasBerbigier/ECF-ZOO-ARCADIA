<?php

require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php"; 
require_once __DIR__. "/lib/user.php";

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'employe') {
    header('Location: index.php');
    exit();
}

$stmtServices = $pdo->query('SELECT * FROM services');
$services = $stmtServices->fetchAll();

$stmtFoods = $pdo->query('SELECT * FROM foods');
$foods = $stmtFoods->fetchAll();





