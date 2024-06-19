<?php

require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php";
require_once __DIR__. "/employe_crud.php";

// Récupère les avis en attente de validation
$validate = 0;

$stmtReviews = $pdo->prepare("SELECT * FROM reviews WHERE validate = :validate");
$stmtReviews->bindValue(':validate', $validate, PDO::PARAM_INT);
$stmtReviews->execute();
$reviews = $stmtReviews->fetchAll(PDO::FETCH_ASSOC);

// Récupère les animaux pour les options du select
$stmtAnimaux = $pdo->query('SELECT id, name FROM animals');
$animals = $stmtAnimaux->fetchAll();

?>
<!-- Formulaire de validation / invalidation avis -->
<main>
    <div class="pt-5">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <h2 class="pt-5 text-light text-center">Valider / Invalider un avis</h2>
                <?php if (isset($_SESSION['message'])){ ?>
                    <div class="alert alert-info">
                        <?= $_SESSION['message'] ?>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                    <?php } else if (isset($_SESSION['error'])) { ?>
                        <div class="alert alert-danger">
                        <?= $_SESSION['error'] ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php }; ?>
                <?php foreach ($reviews as $review) { ?>
                    <div class="col-6 col-lg-3 ">
                        <div class="card mb-3 mt-3">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($review['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($review['comment']) ?></p>
                                <form action="submit_review.php" method="post" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $review['id'] ?>">
                                    <button type="submit" name="action" value="validate" class="btn btn-success">Valider</button>
                                </form>
                                <form action="submit_review.php" method="post" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $review['id'] ?>">
                                    <button type="submit" name="action" value="invalidate" class="btn btn-danger">Invalider</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php }; ?>
            </div>
        </div>
    </div>
    <!-- Début formulaire nourrissage animaux -->
    <div class="pt-5" id="foodSection">
        <div class="container pt-5">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 text-light">
                <?php if (isset($_SESSION['message'])){ ?>
                    <div class="alert alert-info">
                        <?= $_SESSION['message'] ?>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                    <?php } else if (isset($_SESSION['error'])) { ?>
                        <div class="alert alert-danger">
                        <?= $_SESSION['error'] ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                    <?php }; ?>
                    <h2>Nourrir un animal</h2>
                    <form action="employe.php#foodSection" method="POST">
                    <div class="mt-2">
                        <label for="food" class="form-label">Nourriture :</label>
                        <input type="text" class="form-control" id="food" name="food" placeholder="Entrer la nourriture" required>
                    </div>
                    <div class="mt-2">
                        <label for="food_weight" class="form-label">Quantité (en kilogrammes) :</label>
                        <input type="number" class="form-control" id="food_weight" name="food_weight" placeholder="Entrer la quantité" required>
                    </div>
                    <div class="mt-2">
                        <label for="date" class="form-label">Date :</label>
                        <input type="date" id="date" class="form-control" name="date" value="2024-06-19" min="2024-06-19"required>
                    </div>
                    <div class="mt-2">
                        <label for="animal_id" class="form-label">Animal</label>
                        <select class="form-select" id="animal_id" name="animal_id" required>
                        <?php foreach ($animals as $animal) { ?>
                            <option value="<?= $animal['id'] ?>"><?= htmlspecialchars($animal['name']) ?></option>
                        <?php } ?>
            </select>
                    </div>
                    <button type="submit" name="add_food" class="btn btn-outline-light mt-2 btn-lg">Nourrir l'animal</button>
                </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Formulaire nourrissage animaux -->
    <?php require_once __DIR__. '/services_form.php'; ?>
</main>





<?php require_once __DIR__. "/templates/footer.php"; ?>
                                