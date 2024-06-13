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
        header('location: login.php');
    } else {
        // affiche une erreur
        $errors[] = 'Email ou mot de passe incorrect.';
    }

}

foreach ($errors as $error) { ?>
    <div class="alert alert-danger" role="alert">
    <?=$error; ?>
    </div>
    <?php }


require_once __DIR__. "/templates/footer.php";
?>
