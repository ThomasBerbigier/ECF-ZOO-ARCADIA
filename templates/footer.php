<?php
require_once __DIR__. "/../lib/pdo.php";

$stmtSchedules = $pdo->query('SELECT * FROM schedule');
$schedules = $stmtSchedules->fetchAll();
?>
<!--Début Footer-->
<footer class="pt-1 text-white ">
        <div class="container-fluid">
            <div class="row p-4">
                <div class="col-12 col-lg-3 d-flex justify-content-center text-center">
                    <div>
                        <img src="assets/Logo/Capture_d_écran_2024-06-07_205635-removebg-preview.png" alt="Logo du zoo" width="120" height="70">
                        <div class="d-flex">
                            <div class="d-flex flex-column pt-1 mx-4">
                                <a href="index.php" class="text-light">Accueil</a>
                                <a href="habitats.php" class="text-light">Habitats</a>
                                <a href="services.php" class="text-light">Services</a>
                            </div>
                            <div class="d-flex flex-column pt-1 mx-4 mb-4">
                                <a href="contact.php" class="text-light">Contact</a>
                                <a href="index.php#review" class="text-light">Laisser un avis</a>
                                <?php if (isset($_SESSION['user'])) {?> 
                                    <?php if ($_SESSION['role'] == 'administrateur') {?> 
                                        <a class="text-light" href="administrateur.php">Espace administrateur</a>
                                    <?php } else if ($_SESSION['role'] == 'employe') { ?>
                                        <a class="text-light" href="employe.php">Espace employé</a>
                                    <?php } else if ($_SESSION['role'] == 'veterinaire') { ?> 
                                        <a class="text-light" href="veterinaire.php">Espace vétérinaire</a>  
                                    <?php } ?>
                                    <?php } else { ?> 
                                        <a href="#" class="text-light" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Espace pro</a>
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3 text-center pt-5" id="horaires">
                    <h6 class="text-uppercase fw-bold mb-4">horaires d'ouverture </h6>
                    <p>La saison d'été a commencé ! <br>
                    <?php foreach($schedules as $schedule) { ?>
                        <?php echo htmlspecialchars($schedule['day']).' '.htmlspecialchars($schedule['hour']) ?> 
                    <?php }  ?> 
                    </p> 
                </div>
                <div class="col-12 col-lg-3 text-center pt-5">
                    <h6 class="text-uppercase fw-bold mb-3 ">Adresse</h6>
                    <p> 1 chemin du roi Saint-Judicaël <br> 35380 Paimpont <br> Bretagne, France</p>
                </div>
                <div class="col-12 col-lg-3 pt-5 text-center" id="social">
                    <h6 class="text-uppercase fw-bold mb-4">réseaux sociaux</h6>
                    <div id="tags-social">
                        <a class="p-1" href="#"><i class="fa-brands fa-facebook-f fa-2xl" style="color: #3783f4;"></i></a>
                        <a class="p-1" href="#"><i class="fa-brands fa-square-instagram fa-2xl" style="color: #bb00bb;"></i></a>
                        <a class="p-1" href="#"><i class="fa-brands fa-twitter fa-2xl" style="color: #3783f4;"></i></a>
                        <a class="p-1" href="#"><i class="fa-brands fa-snapchat fa-2xl" style="color: #FFD43B;"></i></a>
                        <a class="p-1" href="#"><i class="fa-brands fa-linkedin-in fa-2xl" style="color: #3783f4;"></i></a>
                        <a class="p-1" href="#"><i class="fa-brands fa-youtube fa-2xl" style="color: #ff5b5b;"></i></a>
                    </div>
                </div>
            </div> 
        </div>
    <!-- Copyright -->
    <div class="p-4 text-center copyright">
        <p class="mb-0">&copy; 2024 Zoo Arcadia - Tous droits réservés. Mentions légales | Politique de confidentialité | Conditions d'utilisation</p>
    </div>        
    </footer>
    <!-- Fin Footer -->
    <script src="js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/ef78b716d2.js" crossorigin="anonymous"></script>
</body>
</html>