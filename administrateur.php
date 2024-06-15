<?php

require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/create_user.php";

?>
<main>
<div class="pt-5">
        <div class="container pt-5">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 text-light">
                    <h2>Créer un utilisateur</h2>
                    <form action="" method="POST">
                    <div class="form-group">
                        <label for="createEmail">Email :</label>
                        <input type="email" class="form-control" id="createEmail" name="createEmail" placeholder="Entrer l'email" required>
                    </div>
                    <div class="form-group">
                        <label for="createPassword">Mot de passe :</label>
                        <input type="password" class="form-control" id="createPassword" name="createPassword" placeholder="Entrer le mot de passe" required>
                    </div>
                    <div class="form-group">
                        <label for="selectRole">Rôle :</label>
                        <select class="form-control" id="selectRole" name="selectRole" required>
                            <option value="2">Employé</option>
                            <option value="3">Vétérinaire</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-light">Créer</button>
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