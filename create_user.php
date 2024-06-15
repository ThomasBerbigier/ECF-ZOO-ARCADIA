<?php

require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php"; 
require_once __DIR__. "/lib/user.php";
require_once __DIR__. "/lib/send_email.php";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    try {
        // Récupérer les données du formulaire
        $email = $_POST['createEmail'];
        $password = password_hash($_POST['createPassword'], PASSWORD_BCRYPT);
        $role = $_POST['selectRole'];
        
        // Vérifier que le rôle sélectionné est valide (employé ou vétérinaire)
        if ($role == 2 || $role == 3) {
            // Insérer le nouvel utilisateur
            $stmt = $pdo->prepare('INSERT INTO users (email, password, role_id) VALUES (?, ?, ?)');
            $stmt->execute([$email, $password, $role]);
        
            sendEmail($email);
            echo "L'utilisateur a été créé avec succès et un email lui a été envoyé.";
        } else {
            echo "Rôle invalide.";
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}
