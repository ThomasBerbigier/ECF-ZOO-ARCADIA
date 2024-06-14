<?php

require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php"; 
require_once __DIR__. "/lib/user.php";

$errors = [];

if(isset($_POST['loginUser'])) {
    $user = verifyUserLoginPassword($pdo, $_POST['email'], $_POST['password']);

    if($user) {
        // connexion => session
        $_SESSION['user'] = $user;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role_id'] = $user['role_id'];

        // récupérer le type de rôle
        $stmt = $pdo->prepare('SELECT type FROM roles WHERE id = ?');
        $stmt->execute([$user['role_id']]);
        $role = $stmt->fetch(PDO::FETCH_ASSOC);

        if($role) {
            $_SESSION['role'] = $role['type'];

             // Rediriger l'utilisateur en fonction de son rôle
            if ($role['type'] == 'administrateur') {
                header('Location: administrateur.php');
            } else if ($role['type'] == 'employe') {
                header('Location: employe.php');
            } else if ($role['type'] == 'veterinaire') {
                header('Location: veterinaire.php');
            } else {
                // Rôle non reconnu
                echo "Rôle utilisateur non reconnu.";
            }
            exit();
        }
    } else {
        // affiche une erreur
        $errors[] = 'Email ou mot de passe incorrect.';
    }

}

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
?>
