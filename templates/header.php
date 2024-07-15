<?php
    require_once __DIR__. "/../lib/session.php";
    // Protéger contre les attaques ClickJacking
    header('X-Frame-Options: DENY');
    // Ajouter l'en-tête CSP
    $nonce = base64_encode(random_bytes(16));
    header("Content-Security-Policy: default-src 'self'; script-src 'self' https://apis.google.com; style-src 'self' 'nonce-$nonce' 'unsafe-inline' https://fonts.googleapis.com; img-src 'self' data:; font-src 'self' https://fonts.gstatic.com; frame-ancestors 'self';");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parc animalier au coeur de la Bretagne - Zoo Arcadia</title>
    <link rel="stylesheet" type="texte/css" media="screen" href="css/reset.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Image de fond -->
    <div class="background">
        <img class="blob-image" src="assets/background-blob/background-blob_optimized_.webp" alt="Background Blobs">
    </div>
    <!-- Début Header -->
    <!-- Menu de navigation -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid ">
                <a class="navbar-brand me-5" href="index.php"></a>
                <img src="assets/Logo/Capture_d_écran_2024-06-07_205635-removebg-preview_optimized_.webp" alt="Logo du zoo" width="130" height="80">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav mx-auto">
                        <a class="nav-link me-5 fs-4" aria-current="page" href="index.php">Accueil</a>
                        <a class="nav-link me-5 fs-4" href="habitats.php">Habitats</a>
                        <a class="nav-link me-5 fs-4" href="services.php">Services</a> 
                        <a class="nav-link me-5 fs-4" href="contact.php">Contact</a>  
                        <?php if (isset($_SESSION['user'])) { 
                                if ($_SESSION['role'] == 'administrateur') {?> 
                            <a class="nav-link me-5 fs-4" href="administrateur.php">Espace administrateur</a>
                        <?php } else if ($_SESSION['role'] == 'employe') { ?>
                            <a class="nav-link me-5 fs-4" href="employe.php">Espace employé</a>
                        <?php } else if ($_SESSION['role'] == 'veterinaire') { ?> 
                        <a class="nav-link me-5 fs-4" href="veterinaire.php">Espace vétérinaire</a>
                        <?php } } ?>
                    </div>
                    <?php if (isset($_SESSION['user'])) { ?>
                        <a href="logout.php" class="btn btn-outline-light me-5 fs-4">Déconnexion</a>
                        <?php } else { ?>
                            <a href="#" class="btn btn-outline-light me-5 fs-4" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Espace professionnel</a>
                    <?php } ?>
                    
                </div>
            </div>
        </nav>
            <!-- Fin menu de navigation -->
            <!-- Début Offcanvas pour espace professionnel -->
        <section>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h2 class="offcanvas-title" id="offcanvasRightLabel">Espace professionnel</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="container">
                        <div class=" container-form">
                            <h2 class="mb-5">Connexion</h2>
                            <form action="login.php" method="POST">
                                <div class="form-group">
                                    <label for="email">Email :</label>
                                    <input type="email" id="email" name="email" placeholder="Ex : arcadia@zoo.fr" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Mot de passe :</label>
                                    <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                                </div>
                                <!-- Champ caché pour le token CSRF -->
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                                <div class="form-group">
                                    <input type="submit" name="loginUser" value="Se connecter">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
            <!-- Fin Offcanvas -->            
            <!-- Fin Header -->
    </header>