<?php require_once __DIR__. "/templates/header.php" ?>
    <main>
        <!-- Bandeau page-->
        <section>
            <div class="presentation-habitats">
                <h1 class="text-center">Découvrez les habitats et leurs habitants</h1>
            </div>
        </section>
        <!--Cards habitats-->
        <section>
            <div class="container habitats">
                <div class="container-card text-center mt-5">
                    <div class="row">
                        <div class="col-12 my-4 d-flex justify-content-center" id="savane">
                            <!-- Début card savane -->
                            <div class="card habitat-savane">
                                <img src="assets/main/habitats/habitats/savane.png" class="card-img-top image" alt="Photo d'une savane sauvage"  data-bs-toggle="collapse" data-bs-target="#collapseSavane" aria-expanded="false" aria-controls="collapseSavane" role="button" tabindex="0">
                                <div class="card-body ">
                                    <h2 class="card-title text-center">Savane</h2>
                                    <div class="collapse" id="collapseSavane">
                                        <div class="collapse-savane">
                                            <div class="container">
                                                <div class="fs-5">
                                                    <p class="habitats-text">Bienvenue dans notre habitat savane, où vous pouvez admirer la majesté des lions, la grandeur des girafes, et la puissance des éléphants, recréant l'éblouissante biodiversité de la savane africaine.</p>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-6 col-lg-4">
                                                        <div class="card animal-savane">
                                                            <img src="assets/main/habitats/animaux/girafe.png" class="card-img-top" alt="Photo d'une girafe dans un zoo">
                                                            <div class="card-body">
                                                                <!-- Début accordéon girafe -->
                                                                <div class="accordion" id="accordionGirafe">
                                                                    <div class="accordion-item">
                                                                        <div class="accordion-header">
                                                                        <button class="accordion-button accordion-button-savane fs-2" data-bs-toggle="collapse" data-bs-target="#collapseTwiga" aria-expanded="true" aria-controls="collapseTwiga" type="button" tabindex="0">
                                                                            Twiga
                                                                        </button>
                                                                    </div>
                                                                        <div id="collapseTwiga" class="accordion-collapse collapse" data-bs-parent="#accordionGirafe">
                                                                            <div class="accordion-body savane-body">
                                                                                <ul class="text-start">
                                                                                    <li>
                                                                                        <p>Race :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Habitat :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Etat de l'animal :</p>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Fin accordéon girafe -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-4">
                                                        <div class="card animal-savane">
                                                            <img src="assets/main/habitats/animaux/elephant.png" class="card-img-top" alt="Photo d'un éléphant dans un zoo">
                                                            <div class="card-body">
                                                                <!-- Début accordéon éléphant -->
                                                                <div class="accordion" id="accordionElephant">
                                                                    <div class="accordion-item">
                                                                        <div class="accordion-header">
                                                                        <button class="accordion-button accordion-button-savane fs-2" data-bs-toggle="collapse" data-bs-target="#collapseKibo" aria-expanded="true" aria-controls="collapseTwiga" type="button" tabindex="0">
                                                                            Kibo
                                                                        </button>
                                                                    </div>
                                                                        <div id="collapseKibo" class="accordion-collapse collapse" data-bs-parent="#accordionElephant">
                                                                            <div class="accordion-body savane-body">
                                                                                <ul class="text-start">
                                                                                    <li>
                                                                                        <p>Race :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Habitat :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Etat de l'animal :</p>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Fin accordéon éléphant -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-4">
                                                        <div class="card animal-savane">
                                                            <img src="assets/main/habitats/animaux/lion.png" class="card-img-top" alt="Photo d'un lion dans un zoo">
                                                            <div class="card-body">
                                                                <!-- Début accordéon lion -->
                                                                <div class="accordion" id="accordionLion">
                                                                    <div class="accordion-item">
                                                                        <div class="accordion-header">
                                                                        <button class="accordion-button accordion-button-savane fs-2" data-bs-toggle="collapse" data-bs-target="#collapseLeo" aria-expanded="true" aria-controls="collapseTwiga" type="button" tabindex="0">
                                                                            Leo
                                                                        </button>
                                                                    </div>
                                                                        <div id="collapseLeo" class="accordion-collapse collapse" data-bs-parent="#accordionLion">
                                                                            <div class="accordion-body savane-body">
                                                                                <ul class="text-start">
                                                                                    <li>
                                                                                        <p>Race :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Habitat :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Etat de l'animal :</p>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <!-- Fin accordéon lion-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin card savane -->
                        <!-- Début card marais -->
                        <div class="col-12 my-4 d-flex justify-content-center" id="marais">
                            <div class="card habitat-marais">
                                <img src="assets/main/habitats/habitats/marais.png" class="card-img-top" alt="Photo d'un marais sauvage"  data-bs-toggle="collapse" data-bs-target="#collapseMarais" aria-expanded="false" aria-controls="collapseMarais" role="button" tabindex="0">
                                <div class="card-body">
                                    <h2 class="card-title text-center">Marais</h2>
                                    <div class="collapse" id="collapseMarais">
                                        <div class="collapse-marais">
                                            <div class="container">
                                                <div class="fs-5">
                                                    <p class="habitats-text">Bienvenue dans notre habitat marais, un écosystème unique où vous pourrez observer la puissance des alligators, la grâce des flamants roses et la robustesse des buffles dans leur environnement naturel.</p>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-6 col-lg-4">
                                                        <div class="card animal-marais">
                                                            <img src="assets/main/habitats/animaux/alligator.png" class="card-img-top" alt="Photo d'un alligator dans un zoo">
                                                            <div class="card-body">
                                                                <!-- Début accordéon alligator -->
                                                                <div class="accordion" id="accordionAlligator">
                                                                    <div class="accordion-item">
                                                                        <div class="accordion-header">
                                                                        <button class="accordion-button accordion-button-marais fs-2" data-bs-toggle="collapse" data-bs-target="#collapseGator" aria-expanded="true" aria-controls="collapseGator" type="button" tabindex="0">
                                                                            Gator
                                                                        </button>
                                                                    </div>
                                                                        <div id="collapseGator" class="accordion-collapse collapse" data-bs-parent="#accordionAlligator">
                                                                            <div class="accordion-body marais-body">
                                                                                <ul class="text-start">
                                                                                    <li>
                                                                                        <p>Race :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Habitat :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Etat de l'animal :</p>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Fin accordéon alligator -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-4">
                                                        <div class="card animal-marais">
                                                            <img src="assets/main/habitats/animaux/flamant_rose.png" class="card-img-top " alt="Photo d'un flamant rose dans un zoo">
                                                            <div class="card-body">
                                                                <!-- Début accordéon flamant -->
                                                                <div class="accordion" id="accordionFlamant">
                                                                    <div class="accordion-item">
                                                                        <div class="accordion-header">
                                                                        <button class="accordion-button accordion-button-marais fs-2" data-bs-toggle="collapse" data-bs-target="#collapseFlora" aria-expanded="true" aria-controls="collapseFlora" type="button" tabindex="0">
                                                                            Flora
                                                                        </button>
                                                                    </div>
                                                                        <div id="collapseFlora" class="accordion-collapse collapse" data-bs-parent="#accordionFlamant">
                                                                            <div class="accordion-body marais-body">
                                                                                <ul class="text-start">
                                                                                    <li>
                                                                                        <p>Race :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Habitat :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Etat de l'animal :</p>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Fin accordéon Flamant -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-4">
                                                        <div class="card animal-marais">
                                                            <img src="assets/main/habitats/animaux/buffle.png" class="card-img-top" alt="Photo d'un buffle dans un zoo">
                                                            <div class="card-body">
                                                                <!-- Début accordéon buffle -->
                                                                <div class="accordion" id="accordionBuffle">
                                                                    <div class="accordion-item">
                                                                        <div class="accordion-header">
                                                                        <button class="accordion-button accordion-button-marais fs-2" data-bs-toggle="collapse" data-bs-target="#collapseBilly" aria-expanded="true" aria-controls="collapseBilly" type="button" tabindex="0">
                                                                            Billy
                                                                        </button>
                                                                    </div>
                                                                        <div id="collapseBilly" class="accordion-collapse collapse" data-bs-parent="#accordionBuffle">
                                                                            <div class="accordion-body marais-body">
                                                                                <ul class="text-start">
                                                                                    <li>
                                                                                        <p>Race :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Habitat :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Etat de l'animal :</p>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <!-- Fin accordéon buffle -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin card marais-->
                        <!-- Début card jungle -->
                        <div class="col-12 my-4 d-flex justify-content-center" id="jungle">
                            <div class="card habitat-jungle">
                                <img src="assets/main/habitats/habitats/jungle.png" class="card-img-top" alt="Photo d'une jungle sauvage"  data-bs-toggle="collapse" data-bs-target="#collapseJungle" aria-expanded="false" aria-controls="collapseJungle" role="button" tabindex="0">
                                <div class="card-body">
                                    <h2 class="card-title text-center">Jungle</h2>
                                    <div class="collapse" id="collapseJungle">
                                        <div class="collapse-jungle">
                                            <div class="container">
                                                <div class="fs-5">
                                                    <p class="habitats-text">Plongez au cœur de notre habitat jungle, où vous pourrez admirer la majesté des gorilles, la douceur des koalas, et la puissance des tigres, dans un environnement luxuriant et exotique recréant fidèlement leur habitat naturel.</p>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-6 col-lg-4">
                                                        <div class="card animal-jungle">
                                                            <img src="assets/main/habitats/animaux/koala.png" class="card-img-top" alt="Photo d'un koala dans un zoo">
                                                            <div class="card-body">
                                                                <!-- Début accordéon koala -->
                                                                <div class="accordion" id="accordionKoala">
                                                                    <div class="accordion-item">
                                                                        <div class="accordion-header">
                                                                        <button class="accordion-button accordion-button-jungle fs-2" data-bs-toggle="collapse" data-bs-target="#collapseKoko" aria-expanded="true" aria-controls="collapseKoko" type="button" tabindex="0">
                                                                            Koko
                                                                        </button>
                                                                    </div>
                                                                        <div id="collapseKoko" class="accordion-collapse collapse" data-bs-parent="#accordionKoala">
                                                                            <div class="accordion-body jungle-body">
                                                                                <ul class="text-start">
                                                                                    <li>
                                                                                        <p>Race :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Habitat :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Etat de l'animal :</p>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Fin accordéon koala -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-4">
                                                        <div class="card animal-jungle">
                                                            <img src="assets/main/habitats/animaux/gorille.png" class="card-img-top " alt="Photo d'un gorille dans un zoo">
                                                            <div class="card-body">
                                                                <!-- Début accordéon gorille -->
                                                                <div class="accordion" id="accordionGorille">
                                                                    <div class="accordion-item">
                                                                        <div class="accordion-header">
                                                                        <button class="accordion-button accordion-button-jungle fs-2" data-bs-toggle="collapse" data-bs-target="#collapseGoliath" aria-expanded="true" aria-controls="collapseGoliath" type="button" tabindex="0">
                                                                            Goliath
                                                                        </button>
                                                                    </div>
                                                                        <div id="collapseGoliath" class="accordion-collapse collapse" data-bs-parent="#accordionGorille">
                                                                            <div class="accordion-body jungle-body">
                                                                                <ul class="text-start">
                                                                                    <li>
                                                                                        <p>Race :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Habitat :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Etat de l'animal :</p>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Fin accordéon gorille -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-4">
                                                        <div class="card animal-jungle">
                                                            <img src="assets/main/habitats/animaux/tigre.png" class="card-img-top" alt="Photo d'un tigre dans un zoo">
                                                            <div class="card-body">
                                                                <!-- Début accordéon tigre -->
                                                                <div class="accordion" id="accordionTigre">
                                                                    <div class="accordion-item">
                                                                        <div class="accordion-header">
                                                                        <button class="accordion-button accordion-button-jungle fs-2" data-bs-toggle="collapse" data-bs-target="#collapseTalia" aria-expanded="true" aria-controls="collapseTalia" type="button" tabindex="0">
                                                                            Talia
                                                                        </button>
                                                                    </div>
                                                                        <div id="collapseTalia" class="accordion-collapse collapse" data-bs-parent="#accordionTigre">
                                                                            <div class="accordion-body jungle-body">
                                                                                <ul class="text-start">
                                                                                    <li>
                                                                                        <p>Race :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Habitat :</p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p>Etat de l'animal :</p>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <!-- Fin accordéon tigre -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin card jungle -->
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php require_once __DIR__. "/templates/footer.php" ?>