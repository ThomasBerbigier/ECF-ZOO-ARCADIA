<?php

require_once __DIR__. "/lib/session.php";
require_once __DIR__. "/lib/pdo.php"; 
require_once __DIR__. "/lib/user.php";

// Initialisation tableau d'erreurs
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST['loginUser'])) {
    // Vérification du token CSRF
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $user = verifyUserLoginPassword($pdo, $_POST['email'], $_POST['password']);
        
        if($user) {
            // connexion => session
            $_SESSION['user'] = $user;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role_id'] = $user['role_id'];
            
            // récupérer le type de rôle
            $sql = 'SELECT type FROM roles WHERE id = ?';
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$user['role_id']]);
                $role = $stmt->fetch(PDO::FETCH_ASSOC);
            
                if($role) {
                    $_SESSION['role'] = $role['type'];
                    
                    // Rediriger l'utilisateur en fonction de son rôle
                    if ($role['type'] == 'administrateur') {
                        header('Location: administrateur.php');
                        exit();
                    } else if ($role['type'] == 'employe') {
                        header('Location: employe.php');
                        exit();
                    } else if ($role['type'] == 'veterinaire') {
                        header('Location: veterinaire.php');
                        exit();
                    } else {
                        // Rôle non reconnu
                        $errors[] = "Rôle utilisateur non reconnu.";
                    }
                }
            } catch (Exception $e) {
                $errors[] = " Erreur ! " . $e->getMessage();
            }
        } else {
            // affiche une erreur
            $errors[] = 'Email ou mot de passe incorrect.';
        }
    }else {
            // Token CSRF invalide
            die("Token CSRF invalide.");
    }       
}

require_once __DIR__. "/templates/header.php";

foreach ($errors as $error) { ?>
    <div class="pt-5">
        <div class="container pt-5">
            <div class="alert alert-danger" role="alert">
            <?=$error; ?>
            </div>
            </div>
        </div>
    <?php }

require_once __DIR__. "/templates/footer.php";
