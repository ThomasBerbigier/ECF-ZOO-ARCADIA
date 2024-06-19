<?php
require_once __DIR__. "/lib/pdo.php";
require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/veterinaire_crud.php";

// Récupère les animaux pour les options du select
$stmtAnimaux = $pdo->query('SELECT id, name FROM animals');
$animals = $stmtAnimaux->fetchAll();

$stmtFoods = $pdo->query('SELECT * FROM foods');
$foods = $stmtFoods->fetchAll();
?>

<main>
    <!-- Début formulaire compte rendu animaux -->
    <div class="pt-5" id="reportSection">
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
                    <h2>Suivi des animaux</h2>
                    <form action="veterinaire.php#reportSection" method="POST">
                    <div class="mt-2">
                        <label for="selectState" class="form-label">État général :</label>
                        <select class="form-select" id="selectState" name="selectState" aria-label="Default select example" required>
                            <option  value="En bonne santé">En bonne santé</option>
                            <option value="Stressé">Stressé</option>
                            <option value="Anormal">Anormal</option>
                            <option value="Mauvais">Mauvais</option>
                        </select>
                    <div class="mt-2">
                        <label for="food" class="form-label">Nourriture à donner :</label>
                        <input type="text" class="form-control" id="food" name="food" placeholder="Entrer la nourriture" required>
                    </div>
                    <div class="mt-2">
                        <label for="food_weight" class="form-label">Quantité à donner (en kilogrammes) :</label>
                        <input type="number" class="form-control" id="food_weight" name="food_weight" placeholder="Entrer la quantité" required>
                    </div>
                    <div class="mt-2">
                        <label for="passage" class="form-label">Date de passage :</label>
                        <input type="date" id="passage" class="form-control" name="passage" value="2024-06-19" min="2024-06-19"required>
                    </div>
                    <div class="mt-2">
                        <label for="animal_id" class="form-label">Animal</label>
                        <select class="form-select" id="animal_id" name="animal_id" required>
                        <?php foreach ($animals as $animal) { ?>
                            <option value="<?= $animal['id'] ?>"><?= htmlspecialchars($animal['name']) ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="mt-2">
                        <label for="detail" class="form-label">Détail de l'état de l'animal (facultatif) :</label>
                        <textarea class="form-control" id="detail" name="detail" placeholder="Facultatif" rows="2"></textarea>
                    </div>
                    <button type="submit" name="add_report" class="btn btn-outline-light mt-2 btn-lg">Poster compte rendu</button>
                </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Formulaire nourrissage animaux -->
    <!-- Début affichage repas -->
</main>
<?php require_once __DIR__. "/templates/footer.php" ?>