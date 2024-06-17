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
                            <?= $_SESSION['message'] ?>
                        </div>
                        <?php unset($_SESSION['message']); ?>
                        <?php } else if (isset($_SESSION['error'])) { ?>
                            <div class="alert alert-danger">
                            <?= $_SESSION['error'] ?>
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
<!-- Début Formulaires CRUD Services -->
    <div class="pt-5">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 text-light">
                    <h2>Ajouter un service</h2>
                    <!--  le formulaire contient un file upload -->
                    <form action="administrateur.php" method="POST" enctype="multipart/form-data">
                        <div class="mt-2">
                            <label for="add_name" class="form-label">Nom du Service :</label>
                            <input type="text" name="add_name" class="form-control" required>
                        </div>
                        <div class="mt-2">
                            <label for="add_description" class="form-label">Description :</label>
                            <textarea name="add_description" class="form-control" required></textarea>
                        </div>
                        <div class="mt-2">
                            <label for="add_picture" class="form-label">Image :</label>
                            <input type="file" name="add_picture" class="form-control" required>
                        </div>
                        <button type="submit" name="add_service" class="btn btn-outline-light mt-2 btn-lg">Ajouter le Service</button>
                    </form>
                    
                    <h2 class="pt-5">Modifer / Supprimer un service</h2>
                    <?php foreach ($services as $service) { ?>
                        <div class="card mb-3 mt-3">
                            <img src="<?= htmlspecialchars($service['picture']) ?>" alt="Image du service" class="img-fluid">
                            <div class="card-body">
                                <form action="administrateur.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= $service['id'] ?>">
                                    <div class="mb-3">
                                        <label for="ud_name" class="form-label fs-5">Nom du Service :</label>
                                        <input type="text" name="ud_name" class="form-control" value="<?= htmlspecialchars($service['name']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label fs-5">Description :</label>
                                        <textarea name="ud_description" class="form-control" required><?= htmlspecialchars($service['description']) ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ud_picture" class="form-label fs-5">Image (laisser vide pour conserver l'actuelle) :</label>
                                        <input type="file" name="ud_picture" class="form-control">
                                    </div>
                                    <button type="submit" name="update_service" class="btn btn-warning">Mettre à jour le Service</button>
                                    <button type="submit" name="delete_service" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');">Supprimer le Service</button>
                                </form>
                            </div>
                        </div>
                    <?php }; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Formulaires CRUD Services -->
    <!-- Début Formulaires CRUD horaires -->
    <div class="pt-5">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 text-light">
                <h2>Ajouter un horaire</h2>
                    <form action="administrateur.php" method="POST">
                        <div class="mt-2">
                            <label for="add_days" class="form-label">Jours d'ouverture :</label>
                            <input type="text" name="add_days" class="form-control"  required>
                        </div>
                        <div class="mt-2">
                            <label for="add_hours" class="form-label">Heures d'ouverture :</label>
                            <input name="add_hours" class="form-control" required></input>
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
                <?php foreach($schedules as $schedule) { ?>
                    <div class="col-12 col-lg-4 text-light">
                        <h2>Modifier / Supprimer un horaire</h2>
                        <div class="card mb-3 mt-3">
                            <div class="card-body">
                                <form action="administrateur.php" method="POST">
                                <input type="hidden" name="id" value="<?= $schedule['id'] ?>">
                                    <div class="mt-2">
                                        <label for="ud_days" class="form-label">Jours d'ouverture :</label>
                                        <input type="text" name="ud_days" class="form-control" value="<?= htmlspecialchars($schedule['day']) ?>" required>
                                    </div>
                                    <div class="mt-2">
                                        <label for="ud_hours" class="form-label">Heures d'ouverture :</label>
                                        <input name="ud_hours" class="form-control" value="<?= htmlspecialchars($schedule['hour']) ?>"required>
                                    </div>
                                    <button type="submit" name="update_schedule" class="btn btn-warning">Modifier l'horaire</button>
                                    <button type="submit" name="delete_schedule" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet horaire ?');">Supprimer l'horaire</button>
                                    <div id="passwordHelpBlock" class="form-text">
                                    Attention : supprimer les horaires non valides est très important pour l'affichage sur l'application. Ne garder qu'un seul horaire.
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
                            <label for="add_name" class="form-label">Nom de l'Habitat :</label>
                            <input type="text" name="add_name" class="form-control" required>
                        </div>
                        <div class="mt-2">
                            <label for="add_description" class="form-label">Description :</label>
                            <textarea name="add_description" class="form-control" required></textarea>
                        </div>
                        <div class="mt-2">
                            <label for="add_picture" class="form-label">Image :</label>
                            <input type="file" name="add_picture" class="form-control" required>
                        </div>
                        <button type="submit" name="add_habitat" class="btn btn-outline-light mt-2 btn-lg">Ajouter l'Habitat'</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- ?JoseArcadia!555 / 6976 / Windows Hello -->
<?php 
require_once __DIR__. "/templates/footer.php";
?>