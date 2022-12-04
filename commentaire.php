<?php 
require './config/init.conf.php';
include './includes/header.inc.php'; 
include './includes/nav.inc.php'; 

/**
 * Création des variables
 */
$articles = new articles();
$articles->hydrate($_POST);
$articles->setDate(date('Y-m-d'));
$articlesManager = new articlesManager($bdd);

/**
 * definition de l'id par rapport a l'url via POST
 */
$id = $_GET['id'];
$prenom = '';
$commentaire = '';

if (!empty($_POST['submit'])) {
        /**
         * Ajout du comm en bdd
         */
        $ajoutComm = $articlesManager->addComm($articles);
    
        $messageNotification = $articlesManager->get_result() == true ? "Votre commentaire a été pris en compte !" : "Votre commetaire n'as pas été pris en compte !";
        $resultNotification = $articlesManager->get_result() == true ? "success" : "danger";
    
        $_SESSION['notification']['result'] = $resultNotification;
        $_SESSION['notification']['message'] = $messageNotification;
        echo($id);

        // if ($articlesManager->get_result() == true) {
        //     if ($_FILES['image']['error'] == 0) {
        //         if ($_POST['id'] == "") {
        //             $image = $articlesManager->get_getLastInsertId();
        //         } else {
        //             $image = $_POST['id'];
        //         }
        //         $from = $_FILES['image']['tmp_name'];
        //         move_uploaded_file($from, __DIR__ . "/img/" . $image . ".jpg");
        //     }
        // }
    
        header("Location: index.php");
        exit();
    }
    ?>


<div class="container">
    <div class="text-center mt-5">
        <h1>ARTICLES</h1>
    </div>
    
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form id="articleForm" method="POST" action="articles.php" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="text" name="id" class="form-control" value="<?= $id ?>" id="id">
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" value="<?= $prenom ?>" id="prenom" required>
            </div>
            <div class="mb-3">
                <label for="comm" class="form-label">Commentaire</label>
                <textarea class="form-control" id="comm" rows="4" name="comm" required><?= $commentaire ?></textarea>
            </div>
            <button type="submit" name="submit" value="ajouter" class="btn btn-primary">Soumettre</button>
            </form>
        </div>
    </div>
</div>


<?php include './includes/script.inc.php'; ?>