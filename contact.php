<?php require_once __DIR__. "/templates/header.php" ?>
            <!-- Début formulaire contact -->
    <main> 
        <div class="container form-style">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-6">
                    <h1 class="text-center">Contactez-nous</h1>
                    <form id="contactForm" method="post" action="send_email.php">
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
                    <button type="submit" class="btn btn-outline-light btn-lg">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php require_once __DIR__. "/templates/footer.php" ?>