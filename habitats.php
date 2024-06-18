<?php 

require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php";

// Récupérer tous les habitats
$stmtHabitats = $pdo->query('SELECT * FROM habitats');
$habitats = $stmtHabitats->fetchAll();

// Récupérer tous les animaux
$stmtAnimaux = $pdo->query('SELECT * FROM animals');
$animals = $stmtAnimaux->fetchAll();

// Trier animaux par habitats
$animals_by_habitat = [];
foreach($animals as $animal) {
    $animals_by_habitat[$animal['habitat']][] = $animal;
}

// Variables pour appliquer classes CSS
$habitatClass = '';
$accordionClass = '';
$bodyClass = '';
$animalClass = '';

?>
<main>
    <!-- Bandeau page-->
    <section>
        <div class="presentation-habitats">
            <h1 class="text-center">Découvrez les habitats et leurs habitants</h1>
        </div>
    </section>
    <!--Cards habitats-->
    <section>
        <div class="container habitats">
            <div class="container-card text-center mt-5">
                <div class="row">
                    <?php foreach ($habitats as $habitat) { ?>
                        <?php
                        // Stocke le nom de l'habitat
                        $habitat_name = $habitat['name'];
                        // Associe nom d'habitat et tableau animaux / Retourne un tableau vide si null
                        $habitat_animals = $animals_by_habitat[$habitat_name] ?? [];
                        // Récupérer les animaux de chaque habitat
                        $stmt = $pdo->prepare('SELECT * FROM animals WHERE habitat = ?');
                        $stmt->execute([$habitat['name']]);
                        $animals = $stmt->fetchAll();
                        ?>

                        <?php if ($habitat['name'] == 'savane') { ?>
                            <?php $habitatClass = 'habitat-savane'; ?>
                        <?php } else if ($habitat['name'] == 'marais') { ?>
                            <?php $habitatClass = 'habitat-marais'; ?>
                        <?php } else if ($habitat['name'] == 'jungle') { ?>
                            <?php $habitatClass = 'habitat-jungle'; ?>
                        <?php } else { ?>
                            <?php $habitatClass = 'habitat-marais'; ?>
                        <?php } ?>
                        <div class="col-12 my-4 d-flex justify-content-center" id="<?=htmlspecialchars($habitat_name) ?>">
                            <!-- Début cards -->
                            <div class="card <?= $habitatClass ?>">
                                <img src="<?= htmlspecialchars($habitat['picture']) ?>" class="card-img-top image" alt="<?= htmlspecialchars($habitat_name) ?>"  data-bs-toggle="collapse" data-bs-target="<?= '#collapse'.htmlspecialchars($habitat_name) ?>" role="button" tabindex="0">
                                <div class="card-body ">
                                    <h2 class="card-title text-center"><?= htmlspecialchars($habitat_name) ?></h2>
                                    <div class="collapse" id="<?= 'collapse'.htmlspecialchars($habitat_name) ?>">
                                        <div class="collapse-habitats">
                                            <div class="container">
                                                <div class="fs-5">
                                                    <p class="habitats-text"><?= htmlspecialchars($habitat['description']) ?></p>
                                                </div>
                                                <div class="row">
                                                    <?php foreach ($habitat_animals as $animal) { ?>
                                                        <?php if ($animal['habitat'] == 'savane') { ?>
                                                            <?php $accordionClass = 'accordion-button-savane'; ?>
                                                            <?php $bodyClass = 'savane-body'; ?>
                                                            <?php $animalClass = 'animal-savane'; ?>
                                                        <?php } else if ($animal['habitat'] == 'marais') { ?>
                                                            <?php $accordionClass = 'accordion-button-marais'; ?>
                                                            <?php $bodyClass = 'marais-body'; ?>
                                                            <?php $animalClass = 'animal-marais'; ?>
                                                        <?php } else if ($animal['habitat'] == 'jungle') { ?>
                                                            <?php $accordionClass = 'accordion-button-jungle'; ?>
                                                            <?php $bodyClass = 'jungle-body'; ?>
                                                            <?php $animalClass = 'animal-jungle'; ?>
                                                        <?php } else { ?>
                                                            <?php $accordionClass = 'accordion-button-marais'; ?>
                                                            <?php $bodyClass = 'marais-body'; ?>
                                                            <?php $animalClass = 'animal-marais'; ?>
                                                        <?php } ?>
                                                        <div class="col-12 col-md-6 col-lg-4">
                                                            <div class="card <?= $animalClass ?>">
                                                                <img src="<?= htmlspecialchars($animal['picture']) ?>" class="card-img-top" alt="<?= htmlspecialchars($animal['race']) ?>">
                                                                <div class="card-body">
                                                                    <!-- Début accordéons animaux -->
                                                                    <div class="accordion" id="<?= 'accordion'.htmlspecialchars($animal['name']) ?>">
                                                                        <div class="accordion-item">
                                                                            <div class="accordion-header">
                                                                            <button class="accordion-button fs-2 <?= $accordionClass ?>" data-bs-toggle="collapse" data-bs-target="<?= '#collapse'.htmlspecialchars($animal['name']) ?>" aria-expanded="true" aria-controls="collapseAnimals" type="button" tabindex="0">
                                                                            <?= htmlspecialchars($animal['name']) ?>
                                                                            </button>
                                                                        </div>
                                                                            <div id="<?= 'collapse'.htmlspecialchars($animal['name']) ?>" class="accordion-collapse collapse" data-bs-parent="<?= '#accordion'.htmlspecialchars($animal['name']) ?>">
                                                                                <div class="accordion-body <?= $bodyClass ?>">
                                                                                    <ul class="text-start">
                                                                                        <li>
                                                                                            <p>Race : <?= htmlspecialchars($animal['race']) ?></p>
                                                                                        </li>
                                                                                        <li>
                                                                                            <p>Habitat : <?= htmlspecialchars($animal['habitat']) ?></p>
                                                                                        </li>
                                                                                        <li> <!-- Echanger avec rapport véto !! -->
                                                                                            <p>Etat de l'animal : <?= htmlspecialchars($animal['name']) ?></p>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Fin accordéons animaaux -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Fin card jungle -->
                </div>
            </div>
        </div>
    </section>
</main>
<?php require_once __DIR__. "/templates/footer.php"; ?>