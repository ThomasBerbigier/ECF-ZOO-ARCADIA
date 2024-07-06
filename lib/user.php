<?php

function verifyUserLoginPassword(PDO $pdo, string $email, string $password):bool|array
{ 
    // Requête préparée = requête sécurisée
    $sql = "SELECT * FROM users WHERE email = :email";
    try {
        $query = $pdo->prepare($sql);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
    }catch (Exception $e) {
        echo " Erreur ! " . $e->getMessage();
    }
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