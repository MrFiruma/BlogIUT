<?php require './config/init.conf.php'; ?>
<?php require './config/check-connected.php'; ?>
<?php include './includes/header.inc.php'; ?>
<!-- Responsive navbar-->
<?php include './includes/nav.inc.php'; ?>
<!-- Page content-->
<div class="container">
    <div class="text-center mt-5">
        <h1>À la une !</h1>
        <p class="lead">Rechercher selon vos envies !</p>
    </div>

     <!-- * Verification de la barre de reherche -->
    <?php
    if (!empty($_GET['search'])) {
        // print_r2($_GET);
        $articleManager = new articlesManager($bdd);
        $listeArticles = $articleManager->getListArticlesFromRecherche($_GET['search']);

        //print_r2($listeArticles);
    }
    else {
        $listeArticles = [];
    }
    ?>

    <div class="col-md-6 offset-md-3">
        <form id="" method="GET" action="recherche.php">
                <input type="text" class="form-control" name="search" value="" placeholder="Mot clé...."> 
                <button type="submit" id="submit" value="recherche" class="btn btn-primary">Rechercher</button>              
                </div>  
        </form>
    </div>

    <div class="row">
        <?php
        foreach ($listeArticles as $articles) {
            /**
             * @var Article $article
             */
        ?>
            <div class="col-6 mb-4">
                <div class="card">
                    <img src='img/<?= $articles->getId() ?>.jpg' style="max-width: 200px;" class="card-img-top" alt="erreur image">
                    <div class="card-body">
                        <h5 class="card-title"><?= $articles->getTitre() ?></h5>
                        <p class="card-text"><?= $articles->getTexte() ?></p>
                        <p class="card-text"><?= $articles->getDate() ?></p>
                        <a href="articles.php" class="btn btn-primary">Modifier l'article</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

<?php include './includes/script.inc.php'; ?>