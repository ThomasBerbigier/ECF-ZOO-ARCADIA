<?php 

require_once __DIR__. "/templates/header.php" ;
require_once __DIR__. "/contact_email.php" ;

?>
<!-- Début formulaire contact -->
<main> 
    <div class="container form-style">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-6">
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
                <h1 class="text-center">Contactez-nous</h1>
                <form id="contactForm" method="post" action="contact.php">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Ecrivez votre titre ici" required>
                    </div>
                    <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Ecrivez votre message ici" required></textarea>
                    </div>
                    <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Ecrivez votre adresse mail ici" required>
                    </div>
                    <!-- Champ caché pour le token CSRF -->
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                    <button type="submit" name="submitContact" class="btn btn-outline-light btn-lg">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php 

require_once __DIR__. "/templates/footer.php" ;

?>