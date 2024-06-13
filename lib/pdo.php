<?php

try 
{
    $pdo = new PDO('mysql:host=localhost;dbname=zoo_arcadia', 'root', '');
} 
catch (Exception $e) 
{
    die('Erreur : ' . $e->getMessage());
}