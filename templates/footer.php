<?php
require_once __DIR__. "/../lib/pdo.php";

$sql = 'SELECT * FROM schedule';
try {
    $stmtSchedules = $pdo->query($sql);
}catch (Exception $e) {
    echo " Erreur ! " . $e->getMessage();
}
$schedules = $stmtSchedules->fetchAll();
?>
<!--Début Footer-->
<footer class="pt-1 text-white ">
        <div class="container-fluid">
            <div class="row p-4">
                <div class="col-12 col-lg-4 d-flex justify-content-center text-center">
                    <div>
                        <img src="assets/Logo/Capture_d_écran_2024-06-07_205635-removebg-preview_optimized_.webp" alt="Logo du zoo" width="120" height="70">
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
                                    <?php } 
                                        } else { ?> 
                                        <a href="#" class="text-light" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Espace pro</a>
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 text-center pt-5" id="horaires">
                    <h3 class="text-uppercase fw-bold mb-4 h6">horaires d'ouverture </h3>
                    <p> <?php foreach($schedules as $schedule) { ?>
                        <?= htmlspecialchars_decode($schedule['day'], ENT_QUOTES).' '.htmlspecialchars_decode($schedule['hour'], ENT_QUOTES) ?> 
                    <?php }  ?> 
                    </p> 
                </div>
                <div class="col-12 col-lg-4 text-center pt-5">
                    <h3 class="text-uppercase fw-bold mb-3 h6">Adresse</h3>
                    <p> 1 chemin du roi Saint-Judicaël <br> 35380 Paimpont <br> Bretagne, France</p>
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
</body>
</html>