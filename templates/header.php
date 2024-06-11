<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parc animalier au coeur de la Bretagne - Zoo Arcadia</title>
    <link rel="stylesheet" type="texte/css" media="screen" href="assets/css/reset.css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Image de fond -->
    <div class="background">
        <img class="blob-image" src="assets/background-blob/background-blob.png" alt="Background Blobs">
    </div>
    <!-- Début Header -->
    <!-- Menu de navigation -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid ">
                <a class="navbar-brand me-5" href="index.html"></a>
                <img src="assets/Logo/Capture_d_écran_2024-06-07_205635-removebg-preview.png" alt="Logo du zoo" width="130" height="80">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav mx-auto">
                        <a class="nav-link me-5 fs-4" aria-current="page" href="index.php">Accueil</a>
                        <a class="nav-link me-5 fs-4" href="habitats.php">Habitats</a>
                        <a class="nav-link me-5 fs-4" href="services.php">Services</a> 
                        <a class="nav-link me-5 fs-4" href="contact.php">Contact</a>                   
                    </div>
                    <a href="#" class="btn btn-outline-light me-5 fs-4" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Espace professionnel</a>
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
                                <label for="username">Email :</label>
                                <input type="text" id="username" name="username" placeholder="Ex : arcadia@zoo.fr" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Mot de passe :</label>
                                <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Se connecter">
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