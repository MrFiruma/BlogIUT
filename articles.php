<?php require './config/init.conf.php'; ?>

<?php include './includes/header.inc.php'; ?>
    <!-- Responsive navbar-->
<?php include './includes/nav.inc.php'; ?>

<?php

$articles = new articles();
$articles->hydrate($_POST);
$articles->setDate(date('Y-m-d'));
$articlesManager = new articlesManager($bdd);

if (empty ($_POST['id'])) {
    $id = '';
    $titre = '';
    $texte = '';
    // print_r2($id,$titre,$texte);
} else {
    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $texte = $_POST['texte'];
    // print_r2($id,$titre,$texte);
}


if (!empty($_GET['id'])) {
    // On détermine sur quelle id on se trouve
    $id = $_GET['id'];
    $articlesManager = new articlesManager($bdd);
    $articleID= $articlesManager->getListId($id);
    $titre = $articleID -> getTitre();
    $texte = $articleID -> getTexte();
    // print_r2($id);
    // print_r2($articleID);
}

if (!empty($_POST['submit'])) {
    if ($id == '') {
    //print_r2($_POST);
        $articles = new articles();
        $articles->hydrate($_POST);
        $articles->setDate(date('Y-m-d'));
        // print_r2($articles);
        // print_r2($_FILES);
    
        /**
         * ajout de l'article en BDD
         */
        $ajoutArticle = $articlesManager->add($articles);
    
        $messageNotification = $articlesManager->get_result() == true ? "Votre article a bien été pris en compte !" : "Votre article n'as pas été pris en compte !";
        $resultNotification = $articlesManager->get_result() == true ? "success" : "danger";
    
        $_SESSION['notification']['result'] = $resultNotification;
        $_SESSION['notification']['message'] = $messageNotification;
        // echo($id);

        if ($articlesManager->get_result() == true) {
            if ($_FILES['image']['error'] == 0) {
                if ($_POST['id'] == "") {
                    $image = $articlesManager->get_getLastInsertId();
                } else {
                    $image = $_POST['id'];
                }
                $from = $_FILES['image']['tmp_name'];
                move_uploaded_file($from, __DIR__ . "/img/" . $image . ".jpg");
            }
        }

        header("Location: index.php");
        exit();
    } else {
        /**
         * modification de l'article en BDD
         */
        $ajoutArticle = $articlesManager->update($articles);
    
        $messageNotification = $articlesManager->get_result() == true ? "Votre article a bien été modifié !" : "Votre article n'as pas été modifié !";
        $resultNotification = $articlesManager->get_result() == true ? "success" : "danger";
    
        $_SESSION['notification']['result'] = $resultNotification;
        $_SESSION['notification']['message'] = $messageNotification;
        echo($id);

        if ($articlesManager->get_result() == true) {
            if ($_FILES['image']['error'] == 0) {
                if ($_POST['id'] == "") {
                    $image = $articlesManager->get_getLastInsertId();
                } else {
                    $image = $_POST['id'];
                }
                $from = $_FILES['image']['tmp_name'];
                move_uploaded_file($from, __DIR__ . "/img/" . $image . ".jpg");
            }
        }
    
        header("Location: index.php");
        exit();
    }
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
                <input type="hidden" name="id" class="form-control" value="<?= $id ?>" id="id">
            </div>
            <div class="mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" value="<?= $titre ?>" id="title" required>
            </div>
            <div class="mb-3">
                <label for="textarea" class="form-label">Texte</label>
                <textarea class="form-control" id="textarea" rows="4" name="texte" required><?= $texte ?></textarea>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Image article</label>
                <input class="form-control" name="image" type="file" id="formFile">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="checkbox" class="form-check-input" id="Check1">
                <label class="form-check-label" for="Check1">Publier ? O/N </label>
            </div>
            <button type="submit" name="submit" value="ajouter" class="btn btn-primary">Soumettre</button>
            </form>
        </div>
    </div>
</div>


<?php include './includes/script.inc.php'; ?>