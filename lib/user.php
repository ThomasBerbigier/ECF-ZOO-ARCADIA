<?php

function verifyUserLoginPassword(PDO $pdo, string $email, string $password):bool|array
{ 
    // Requête préparée = requête sécurisée
    $query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    // fetch() récupère une seule ligne
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Authentification
    if($user && password_verify($password, $user['password'])) {
        // vérif ok
        return $user;
    } else {
        // email ou mdp incorrects : retourne false
        return false;
    }
}