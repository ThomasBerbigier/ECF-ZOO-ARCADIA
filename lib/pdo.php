<?php

try 
{
    $pdo = new PDO('mysql:host=localhost;dbname=zoo_arcadia', 'root', '');
    // Activation des erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // mode de fetch par défaut : FETCH_ASSOC / FETCH_OBJ / FETCH_BOTH
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} 
catch (Exception $e) 
{
    die('Erreur : ' . $e->getMessage());
}