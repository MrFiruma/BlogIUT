<?php require './config/init.conf.php'; ?>
<?php require './config/check-connected.php'; ?>
<?php include './includes/header.inc.php'; ?>
<!-- Responsive navbar-->
<?php include './includes/nav.inc.php'; ?>

<?php

if (!empty($_POST['submit'])) {
    //echo 'le formulaire est posté';
    //print_r2($_POST);
    //print_r2($_FILES);
    //Création de l'utilisateur
    $utilisateursFormulaire = new utilisateurs();
    $utilisateursFormulaire->hydrate($_POST);
    // print_r2($utilisateursFormulaire);


    $utilisateursManager = new utilisateursManager($bdd);
    $utilisateursEnBdd = $utilisateursManager->getByEmail($utilisateursFormulaire->getEmail());
    // print_r2($utilisateursEnBdd);

    $isConnect = password_verify($utilisateursFormulaire->getMdp(), $utilisateursEnBdd->getMdp());

    //dump($isConnect);

    if ($isConnect == true) {
        $sid = md5($utilisateursEnBdd->getEmail() . time());
        //echo $sid;
        //Création du cookie
        setcookie('sid', $sid, time() + 86400);
        //Mise en bdd du sid
        $utilisateursEnBdd->setSid($sid);
        //dump($utilisateursEnBdd);
        $utilisateursManager->updateByEmail($utilisateursEnBdd);
        //dump($utilisateurManager->get_result());
    }

    if ($isConnect == true) {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'Vous êtes connecté !';
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = 'Vérifiez votre login / mot de passe !';
        header("Location: connect.php");
        exit();
    }
}

?>

<?php
    if (isset($_SESSION['notification'])) {
    ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-<?= $_SESSION['notification']['result'] ?>" role="alert">
                    <?= $_SESSION['notification']['message'] ?>
                    <?php unset($_SESSION['notification']) ?>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

<div class="container">
    <div class="text-center mt-5">
        <h1>connection</h1>
    </div>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form id="articleForm" method="POST" action="connect.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="mdp" class="form-label">Mot de passe</label>
                    <input type="password" name="mdp" class="form-control" value="" id="mdp" required>
                </div>
                <button type="submit" name="submit" value="ajouter" class="btn btn-primary">Soumettre</button>
            </form>
        </div>
    </div>
</div>
</div>

<?php include './includes/script.inc.php'; ?>