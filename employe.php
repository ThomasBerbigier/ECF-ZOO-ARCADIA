<?php

require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php";
require_once __DIR__. "/employe_crud.php";

$validate = 0;

$stmt = $pdo->prepare("SELECT * FROM reviews WHERE validate = :validate");
$stmt->bindValue(':validate', $validate, PDO::PARAM_INT);
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

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
</main>





<?php require_once __DIR__. "/templates/footer.php"; ?>
                                