<?php
require_once __DIR__. "/lib/pdo.php";
require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/veterinaire_crud.php";

// Récupère les animaux pour les options du select 
$sql = 'SELECT id, name FROM animals';
try {
    $stmtAnimals = $pdo->query($sql);
}catch (Exception $e) {
    echo " Erreur ! " . $e->getMessage();
}
$animals = $stmtAnimals->fetchAll();

// Récupère les habitats pour les options du select
$sql = 'SELECT id, name FROM habitats';
try {
    $stmtHabitats = $pdo->query($sql);
}catch (Exception $e) {
    echo " Erreur ! " . $e->getMessage();
}
$habitats = $stmtHabitats->fetchAll();

// Récupérer les animaux et leurs repas
// Jointure combine chaque ligne sélectionnée de animals avec les lignes correspondantes de foods où animals.id est égal à foods.animal_id.
$sql =     "SELECT
animals.id AS animal_id, 
animals.name AS animal_name, 
animals.picture AS animal_picture, 
foods.food AS food_name, 
foods.food_weight AS food_weight, 
foods.date AS food_date
FROM animals
LEFT JOIN foods ON animals.id = foods.animal_id
ORDER BY animals.id, foods.date DESC";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}catch (Exception $e) {
    echo " Erreur ! " . $e->getMessage();
}
$food_by_animal = $stmt->fetchAll(PDO::FETCH_ASSOC);

$animals_history = [];

foreach ($food_by_animal as $row) {

    // Extrait l'id de l'animal pour chaque ligne
    $animal_id = $row['animal_id'];
    // Vérifie si l'animal est déjà présent
    if (!isset($animals_history[$animal_id])) {

        $animals_history[$animal_id] = [
            'name' => $row['animal_name'],
            'picture' => $row['animal_picture'],
            'meals' => []
        ];
    }
    // Vérifie si food n'est pas null
    if ($row['food_name'] !== null) {

        $animals_history[$animal_id]['meals'][] = [
            'food' => $row['food_name'],
            'food_weight' => $row['food_weight'],
            'date' => $row['food_date']
        ];
    }
}


?>

<main>
    <!-- Début formulaire compte rendu animaux -->
    <div class="pt-5" id="reportSection">
        <div class="container pt-5">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 text-light">
                <?php if (isset($_SESSION['message'])){ ?>
                    <div class="alert alert-info">
                        <?= htmlspecialchars($_SESSION['message']) ?>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                    <?php } else if (isset($_SESSION['error'])) { ?>
                        <div class="alert alert-danger">
                        <?= htmlspecialchars($_SESSION['error']) ?>
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
                        <label for="animal_id" class="form-label">Animal :</label>
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
    <!-- Laisser un commentaire sur un habitat -->
    <div class="pt-5">
        <div class="container pt-5">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 text-light">
                    <h2>Laisser un commentaire sur un habitat</h2>
                    <form action="veterinaire.php" method="POST">
                        <div class="mt-2">
                        <label for="comment" class="form-label">Commentaire :</label>
                        <textarea type="text" class="form-control" id="comment" name="comment" placeholder="Ecrivez votre commentaire" required></textarea>                      
                        </div>
                        <div class="mt-2">
                            <label for="selectHabitat" class="form-label">Habitat :</label>
                            <select class="form-select" id="selectHabitat" name="selectHabitat" required>
                                <?php foreach ($habitats as $habitat) { ?>
                                    <option value="<?= $habitat['id'] ?>"><?= htmlspecialchars($habitat['name']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button type="submit" name="add_comment" class="btn btn-outline-light mt-2 btn-lg">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Début affichage repas -->
    <div class="container pt-5">
        <h2 class="text-light text-center fs-1">Historique des Repas par Animal</h2>
        <div class="row">
            <?php foreach ($animals_history as $animal_history) { ?>
                <div class="col-md-4">
                    <div class="card mb-4 text-center">
                        <img src="<?= $animal_history['picture']; ?>" class="card-img-top" alt="<?= $animal_history['name']; ?>">
                        <div class="card-body">
                            <h4 class="card-title"><?= $animal_history['name']; ?></h4>
                            <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#meals-<?= $animal_history['name']; ?>" aria-expanded="false" aria-controls="meals-<?= $animal['name']; ?>">
                                Voir l'historique des repas
                            </button>
                            <div class="collapse mt-2" id="meals-<?= $animal_history['name']; ?>">
                                <ul class="list-group">
                                    <?php if (empty($animal_history['meals'])) { ?>
                                        <li class="list-group-item">Aucun repas trouvé.</li>
                                    <?php } else { ?>
                                        <?php foreach ($animal_history['meals'] as $meal) { ?>
                                            <li class="list-group-item">
                                                <strong><?= $meal['date']; ?></strong>: 
                                                <?= $meal['food']; ?> (<?= $meal['food_weight']; ?> kg)
                                            </li>
                                        <?php  } ?>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</main>
<?php require_once __DIR__. "/templates/footer.php" ?>