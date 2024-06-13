<?php
require_once __DIR__ . "/lib/session.php";

// Prévient les attaques de fixation de session
session_regenerate_id(true);

// Supprime les données du serveur
session_destroy();

// Supprime les données du tableau $_SESSION
unset($_SESSION);

// Redirige vers la pages d'accueil
header('location:index.php');
