<?php 

require_once __DIR__. "/templates/header.php"; 
require_once __DIR__. "/administrateur_crud.php";
?>
    <main>
        <!-- Bandeau page-->
        <section>
            <div class="presentation-habitats">
                <h1 class="text-center">Découvrez tous les services proposés</h1>
            </div>
        </section>
        <!-- Début cards services-->
        <div class="container">
            <div class="container-card text-center mt-5">
                <div class="row">
                    <?php foreach ($services as $service) { ?>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="card h-100 card-services" style="width: 100%;">
                                <img src="<?= htmlspecialchars($service['picture']) ?>" class="card-img-top h-100" alt="Image du service">
                                <div class="card-body">
                                    <h3 class="text-center"><?= htmlspecialchars($service['name']) ?></h3>
                                    <p><?= htmlspecialchars($service['description']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>
                </div> 
            </div>
        </div>
        <!-- Fin cards services -->
    </main>
    <?php require_once __DIR__. "/templates/footer.php" ?>