<?php

require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/administrateur_crud.php";

?>
<!-- Début Formulaire ajout utilisateur employé ou vétérinaire -->
<main>
    <div class="pt-5">
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
                    <h2>Créer un compte utilisateur</h2>
                    <form action="administrateur.php" method="POST">
                    <div class="mt-2">
                        <label for="createEmail" class="form-label">Email :</label>
                        <input type="email" class="form-control" id="createEmail" name="createEmail" placeholder="Entrer l'email" required>
                    </div>
                    <div class="mt-2">
                        <label for="createPassword" class="form-label">Mot de passe :</label>
                        <input type="password" class="form-control" id="createPassword" name="createPassword" placeholder="Entrer le mot de passe" required>
                    </div>
                    <div class="mt-2">
                        <label for="selectRole" class="form-label">Rôle :</label>
                        <select class="form-select" id="selectRole" name="selectRole" aria-label="Default select example" required>
                            <option value="2">Employé</option>
                            <option value="3">Vétérinaire</option>
                        </select>
                    </div>
                    <button type="submit" name="add_user" class="btn btn-outline-light mt-2 btn-lg">Créer le compte</button>
                </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Formulaire ajout utilisateur employé ou vétérinaire -->
    <!-- Inclusion formulaires CRUD Services -->
    <?php require_once __DIR__. '/services_form.php'; ?>
    <!-- Début Formulaires CRUD horaires -->
    <div class="pt-5">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 text-light">
                <h2>Ajouter un horaire</h2>
                    <form action="administrateur.php" method="POST">
                        <div class="mt-2">
                            <label for="add_days" class="form-label">Jours d'ouverture :</label>
                            <input type="text" id="add_days" name="add_days" class="form-control"  required>
                        </div>
                        <div class="mt-2">
                            <label for="add_hours" class="form-label">Heures d'ouverture :</label>
                            <input name="add_hours" id="add_hours" class="form-control" required></input>
                        </div>
                        <button type="submit" name="add_schedule" class="btn btn-outline-light mt-2 btn-lg">Ajouter l'horaire</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-5">
        <div class="container">
            <div class="row d-flex justify-content-center">
            <h2 class="text-light text-center">Modifier / Supprimer un horaire</h2>
                <?php foreach($schedules as $schedule) { ?>
                    <div class="col-12 col-lg-4">
                        <div class="card mb-3 mt-3">
                            <div class="card-body">
                                <form action="administrateur.php" method="POST">
                                <input type="hidden" name="id" value="<?= $schedule['id'] ?>">
                                    <div class="mt-2">
                                        <label for="ud_days" class="form-label">Jours d'ouverture :</label>
                                        <input type="text" id="ud_days" name="ud_days" class="form-control" value="<?= htmlspecialchars_decode($schedule['day'], ENT_QUOTES) ?>" required>
                                    </div>
                                    <div class="mt-2">
                                        <label for="ud_hours" class="form-label">Heures d'ouverture :</label>
                                        <input name="ud_hours" id="ud_hours" class="form-control" value="<?= htmlspecialchars_decode($schedule['hour'], ENT_QUOTES) ?>"required>
                                    </div>
                                    <button type="submit" name="update_schedule" class="btn btn-warning">Modifier l'horaire</button>
                                    <button type="submit" name="delete_schedule" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet horaire ?');">Supprimer l'horaire</button>
                                    <div id="passwordHelpBlock" class="form-text">
                                    Attention : supprimer les horaires non valides est très important pour l'affichage sur l'application. <br> Ne garder qu'un seul horaire.
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php }; ?>
            </div>
        </div>
    </div>
    <!-- Fin Formulaires CRUD horaires -->
    <!-- Début Formulaires CRUD habitats -->
    <div class="pt-5">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 text-light">
                    <h2>Ajouter un habitat</h2>
                    <!--  le formulaire contient un file upload -->
                    <form action="administrateur.php" method="POST" enctype="multipart/form-data">
                        <div class="mt-2">
                            <label for="add_name_habitat" class="form-label">Nom de l'Habitat :</label>
                            <input type="text" id="add_name_habitat" name="add_name" class="form-control" required>
                        </div>
                        <div class="mt-2">
                            <label for="add_description_habitat" class="form-label">Description :</label>
                            <textarea name="add_description" id="add_description_habitat" class="form-control" required></textarea>
                        </div>
                        <div class="mt-2">
                            <label for="add_picture_habitat" class="form-label">Image :</label>
                            <input type="file" id="add_picture_habitat" name="add_picture" class="form-control" required>
                        </div>
                        <button type="submit" name="add_habitat" class="btn btn-outline-light mt-2 btn-lg">Ajouter l'Habitat</button>
                    </form>

                    <h2 class="pt-5">Modifer / Supprimer un habitat</h2>
                    <?php foreach ($habitats as $habitat) { ?>
                        <div class="card mb-3 mt-3">
                            <img src="<?= htmlspecialchars($habitat['picture']) ?>" alt="Image de l'habitat " class="img-fluid">
                            <div class="card-body">
                                <form action="administrateur.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= $habitat['id'] ?>">
                                    <div class="mb-3">
                                        <label for="<?= htmlspecialchars($habitat['name']) ?>" class="form-label fs-5">Nom de l'habitat :</label>
                                        <input type="text" id="<?= htmlspecialchars($habitat['name']) ?>" name="ud_name" class="form-control" value="<?= htmlspecialchars($habitat['name']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="<?= htmlspecialchars($habitat['description']) ?>" class="form-label fs-5">Description :</label>
                                        <textarea name="ud_description" id="<?= htmlspecialchars($habitat['description']) ?>" class="form-control" required><?= htmlspecialchars($habitat['description']) ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="<?= htmlspecialchars($habitat['picture']) ?>" class="form-label fs-5">Image (laisser vide pour conserver l'actuelle) :</label>
                                        <input type="file" id="<?= htmlspecialchars($habitat['picture']) ?>" name="ud_picture" class="form-control">
                                    </div>
                                    <button type="submit" name="update_habitat" class="btn btn-warning">Mettre à jour l'Habitat</button>
                                    <button type="submit" name="delete_habitat" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet habitat ?');">Supprimer l'habitat</button>
                                </form>
                            </div>
                        </div>
                    <?php }; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Formulaires CRUD habitats -->
    <!-- Début Formulaires CRUD animaux -->
    <div class="pt-5">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 text-light">
                    <h2>Ajouter un animal</h2>
                    <!--  le formulaire contient un file upload -->
                    <form action="administrateur.php" method="POST" enctype="multipart/form-data">
                        <div class="mt-2">
                            <label for="add_name" class="form-label">Prénom :</label>
                            <input type="text" id="add_name" name="add_name" class="form-control" required>
                        </div>
                        <div class="mt-2">
                            <label for="add_race" class="form-label">Race :</label>
                            <textarea name="add_race" id="add_race" class="form-control" required></textarea>
                        </div>
                        <div class="mt-2">
                            <label for="add_animal_habitat" class="form-label">Habitat :</label>
                            <textarea name="add_animal_habitat" id="add_animal_habitat" class="form-control" required></textarea>
                        </div>
                        <div class="mt-2">
                            <label for="add_picture" class="form-label">Image :</label>
                            <input type="file" id="add_picture" name="add_picture" class="form-control" required>
                        </div>
                        <button type="submit" name="add_animal" class="btn btn-outline-light mt-2 btn-lg">Ajouter l'animal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-5">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <h2 class="pt-5 text-light text-center">Modifer / Supprimer un animal</h2>
                <?php foreach ($animals as $animal) { ?>
                    <div class="col-6 col-lg-3 ">
                        <div class="card mb-3 mt-3">
                            <img src="<?= htmlspecialchars($animal['picture']) ?>" alt="<?= htmlspecialchars($animal['race']) ?> " class="img-fluid">
                            <div class="card-body">
                                <form action="administrateur.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= $animal['id'] ?>">
                                    <div class="mb-3">
                                        <label for="<?= htmlspecialchars($animal['name']) ?>" class="form-label fs-5">Prénom :</label>
                                        <input type="text" id="<?= htmlspecialchars($animal['name']) ?>" name="ud_name" class="form-control" value="<?= htmlspecialchars($animal['name']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="<?= htmlspecialchars($animal['race']) ?>" class="form-label fs-5">Race :</label>
                                        <textarea name="ud_race" id="<?= htmlspecialchars($animal['race']) ?>" class="form-control" required><?= htmlspecialchars($animal['race']) ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="<?= htmlspecialchars($animal['id']).htmlspecialchars($animal['name']) ?>" class="form-label fs-5">Habitat :</label>
                                        <textarea name="ud_animal_habitat" id="<?= htmlspecialchars($animal['id']).htmlspecialchars($animal['name']) ?>" class="form-control" required><?= htmlspecialchars($animal['habitat']) ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="<?= htmlspecialchars($animal['picture']) ?>" class="form-label fs-5">Image (laisser vide pour conserver l'actuelle) :</label>
                                        <input type="file" id="<?= htmlspecialchars($animal['picture']) ?>" name="ud_picture" class="form-control">
                                    </div>
                                    <button type="submit" name="update_animal" class="btn btn-warning">Mettre à jour l'animal</button>
                                    <button type="submit" name="delete_animal" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet habitat ?');">Supprimer l'animal</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php }; ?>
            </div>
        </div>
    </div>
    <!-- Fin Formulaires CRUD animaux -->
    <!-- Début Comptes rendus filtrés  -->
    <section>
        <div class="container mt-5">
            <h2 class="text-center mb-4 text-light">Liste des Comptes Rendus</h2>
                <!-- Formulaires de filtrage -->
                <form method="GET" class="mb-4" action="#reports-table">
                    <div class="row d-flex justify-content-center">
                        <div class="col-12 col-lg-3">
                            <label for="animal_id" class="form-label text-light">Filtrer par Animal :</label>
                            <select name="animal_id" id="animal_id" class="form-select">
                                <option value="">Tous les animaux</option>
                                <!-- Option pour chaque animal -->
                                <?php foreach ($animals_filter as $animal_filter) { ?>
                                    <option value="<?= $animal_filter['id'] ?>" <?= ($_GET['animal_id'] ?? '') == $animal_filter['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($animal_filter['name']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-12 col-lg-3">
                            <label for="report_date" class="form-label text-light">Filtrer par Date :</label>
                            <input type="date" name="report_date" id="report_date" class="form-control" value="<?= $_GET['report_date'] ?? '' ?>">
                        </div>
                        <div class="col-3 align-self-end">
                            <button type="submit" class="btn btn-primary">Filtrer</button>
                        </div>
                    </div>
                </form>
                <!-- Ancre pour le tableau -->
                <div id="reports-table">
                </div>
                <!-- Tableau des comptes rendus -->
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-lg-8">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date de Passage</th>
                                        <th>Nom de l'Animal</th>
                                        <th>État</th>
                                        <th>Nourriture</th>
                                        <th>Poids de la Nourriture</th>
                                        <th>Détail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reports as $index => $row) { ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= htmlspecialchars($row['passage']) ?></td>
                                            <td><?= htmlspecialchars($row['animal_name']) ?></td>
                                            <td><?= htmlspecialchars($row['state']) ?></td>
                                            <td><?= htmlspecialchars($row['food']) ?></td>
                                            <td><?= htmlspecialchars($row['food_weight']) ?></td>
                                            <td><?= htmlspecialchars($row['detail']) ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin Comptes rendus filtrés -->
    <!-- Début dashboard clics animaux -->
    <section>
        <div class="container mt-5">
            <h2 class="text-center text-light">Tableau de bord des clics sur les animaux</h2>
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6">
                    <table class="table table-striped table-hover mt-3 ">
                        <thead>
                            <tr>
                                <th>Nom de l'animal</th>
                                <th>Nombre de clics</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cursor as $document) { ?>
                            <tr>
                                <td><?= htmlspecialchars($document['animal_name']) ?></td>
                                <td><?= htmlspecialchars($document['click_count']) ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin dashboard clics animaux -->
</main>

<!-- ?JoseArcadia!555 / 6976 / Windows -->
<?php 
require_once __DIR__. "/templates/footer.php";
?>