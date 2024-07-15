<?php 

require_once __DIR__. "/templates/header.php";
require_once __DIR__. "/lib/pdo.php";

$validate = 1;
$sql = "SELECT * FROM reviews WHERE validate = :validate";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':validate', $validate, PDO::PARAM_INT).
    $stmt->execute();
} catch(Exception $e){
    echo " Erreur ! ".$e->getMessage();
}
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<main>
    <!-- Image de présentation -->
    <img class="img-accueil" src="assets/header/victoria-landavazo--OdpvGOejME-unsplash(3).jpg" alt="image représentant un groupe de flamants roses présents dans le zoo">
    <!--  Titre de présentation -->
    <div class="overlay">
        <h1 class="title-index">Bienvenue au Zoo Arcadia</h1>
    </div>
    <!-- Bandeau de séparation -->
    <div class="bandeau">
        <h2>Venez découvrir un lieu aux valeurs écologiques et humaines</h2>
    </div>
    <!-- Début présentation du zoo -->
    <div class="container-presentation">
        <div class="photo">
            <img src="assets/main/presentation/presentation.png" alt="Photo de deux éléphants devant un groupe de visiteurs">
        </div>
        <div class="description">
            <article class="article">
                <h3>Un zoo fort de 60 années d'expérience</h3>
                <p>Niché au cœur de la majestueuse forêt de Brocéliande en Bretagne depuis 1960, le zoo Arcadia est bien plus qu'un simple sanctuaire animalier.</p>
                <p>C'est un havre de paix où la faune prospère dans des habitats soigneusement reconstitués, de la savane à la jungle luxuriante en passant par le marais humide.</p>
                <p>Vous retrouverez dans ces habitats bon nombre de petits et gros pensionnaires dont le bien-être est notre priorité.</p>
                <p> Chaque jour,vétérinaires et employés veillent attentivement à la santé de leurs petits protégés, qui par ailleurs se portent à mérveille! Vous pourrez d'ailleur (avec un peu de chance) aux nourissages quotidiens. Mais Arcadia ne se contente pas de prendre soin de ses animaux. </p>
                <p>Fier de son engagement envers l'environnement, le zoo a réalisé l'exploit de devenir totalement indépendant sur le plan énergétique.</p>
                <p>C'est un engagement important pour l'avenir du zoo mais aussi de la panète.</p>                   
            </article>
        </div>
    </div>
    <!-- Fin présentation du zoo -->
    <!-- Début cards habitats/animaux -->
    <div class="container accueil">
        <div class="container-card text-center mt-5">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 card-savane" style="width: 100%;">
                        <img src="assets/main/accueil-habitats/savane-girafe_optimized_.webp" class="card-img-top h-100" alt="Photo d'une girafe dans la savane">
                        <div class="card-body">
                            <h3 class="card-title text-center">Savane</h3>
                            <p class="card-text">Bienvenue dans l'habitat savane de notre zoo, une vaste étendue qui capture l'essence des plaines africaines. Ici, les lions règnent en maîtres, les élégantes girafes se promènent gracieusement et les majestueux éléphants complètent ce tableau.</p>
                            <a href="habitats.php#heading1" class="btn btn-dark fs-5">Je découvre la savane !</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 card-marais" style="width: 100%;">
                        <img src="assets/main/accueil-habitats/marais-alligator.png" class="card-img-top h-100" alt="Photo d'un alligator dans l'eau">
                        <div class="card-body">
                            <h3 class="card-title text-center">Marais</h3>
                            <p class="card-text">Bienvenue dans l'habitat marais de notre zoo, un écosystème fascinant où l'eau et la terre se rencontrent pour créer un refuge unique. Les imposants alligators, Les flamboyants flamants roses et les robustes buffles peuplent cet habitat.</p>
                            <a href="habitats.php#heading2" class="btn btn-dark fs-5">Je découvre le marais !</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 card-jungle" style="width: 100%;">
                        <img src="assets/main/accueil-habitats/jungle-koala_optimized_.webp" class="card-img-top h-100" alt="Photo d'un koala marchant sur une branche">
                        <div class="card-body">
                            <h3 class="card-title text-center">Jungle</h3>
                            <p class="card-text">Bienvenue dans l'habitat jungle de notre zoo, une oasis luxuriante où la nature s'épanouit dans toute sa splendeur. Ici, vous pouvez admirer les majestueux gorilles, plus loin, les adorables koalas et enfin, les puissants tigres.</p>
                            <a href="habitats.php#heading3" class="btn btn-dark justify-content-center fs-5">Je découvre la jungle !</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin cards habitats/animaux -->
    <!-- Début accueil services -->
    <div class="container">
        <div class="container-services text-center fs-5 p-1">
            <h2>Retrouvez nos services</h2>
            <p>Notre zoo possède tous les services nécessaires pour une journée réussie, retrouvez entre autre :</p>
            <ul class="custom-list">
                <li > 
                    <h3 class="title-with-logo fs-3 h4">
                    <span>
                        <img src="assets/main/accueil-services/restaurant_7409492.svg" alt="Logo restaurant">
                    </span>
                    <span>
                        Restauration
                    </span>
                    <span  class="px-3">
                        <img src="assets/main/accueil-services/restaurant_7409492.svg" alt="Logo restaurant">
                    </span>
                    </h3>
                    <p>Venez goûter aux spécialités bretonnes dans l'un de nos trois restaurants !</p>
                </li>
                <li>
                    <h3 class="title-with-logo fs-3 h4">
                        <span>
                            <img src="assets/main/accueil-services/guide_13794712.svg" alt="Logo visite guidée">
                        </span>
                        <span>
                            Visite guidée
                        </span>
                        <span class="px-3">
                            <img src="assets/main/accueil-services/guide_13794712.svg" alt="Logo visite guidée">
                        </span>
                    </h3>
                    <p>Un guide vous fera visiter gratuitement les différents habitats du parc !</p>
                </li>
                <li>
                    <h3 class="title-with-logo fs-3 h4">
                        <span>
                            <img src="assets/main/accueil-services/icons8-train-64.png" alt="Logo petit train">
                        </span>
                        <span>
                            Tour du zoo en petit train
                        </span>
                        <span class="px-2">
                            <img src="assets/main/accueil-services/icons8-train-64.png" alt="Logo petit train">
                        </span>
                        </h3>
                    <p>Si vous aussi vous adorez les balades en petit train ne râtez pas le départ !</p>
                </li>
                <li>
                    <a href="services.php" class="btn btn-dark fs-3">Voir tous les services</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Fin accueil services -->
    <!-- Début avis -->
    <!-- Présentation avis-->
    <div id="reviewsCarousel" class="carousel carousel-dark review-carousel slide mt-5" data-bs-ride="carousel">
        <div class="carousel-inner" id="reviewsSection">
            <?php foreach ($reviews as $index => $review) { ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="card review-card text-center ">
                        <div class="card-header fs-5">
                            <h3 class="h5"><?= htmlspecialchars($review['name']) ?></h3>
                        </div>
                        <div class="card-body fs-5" id="reviewsComment">
                            <p><?= htmlspecialchars($review['comment']) ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>
    </div>
    <!-- Fin présentation avis-->
    <!-- Début laisser un avis-->
    <div class="container my-3" id="review">
        <!-- Formulaire d'avis -->
        <div class="row">
            <div class="card text-center form-card mb-5">
                <div class="card-header">
                    <h3>Laisser un avis</h3>
                </div>
                <div class="card-body">
                    <form action="submit_review.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label form-label-bg fs-5">Nom</label>
                            <input type="text" id="name" class="form-control" name="name" placeholder="Ecrivez votre pseudo ici" required>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label form-label-bg fs-5" >Avis</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Ecrivez votre texte ici" required></textarea>
                        </div>
                        <!-- Champ caché pour le token CSRF -->
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                        <button type="submit" name="submit_review" class="btn btn-dark fs-5">Soumettre</button>
                    </form>
                </div>
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
            </div>   
        </div>
    </div>
</main>
<script src="js/script.js"></script>
<?php require_once __DIR__. "/templates/footer.php"; ?>