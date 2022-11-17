<?php require './config/init.conf.php';
include './includes/header.inc.php';
include './includes/nav.inc.php';

// $loader = new \Twig\Loader\FilesystemLoader('templates/');
// $twig = new \Twig\Environment($loader, ['debug'=>true]);

// echo $twig->render('utilisateur.html.twig');
?>
<div class="container">
    <div class="text-center mt-5">
        <h1>utilisateurs</h1>
    </div>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form id="articleForm" method="POST" action="utilisateurs.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" value="" id="nom" required>
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prenom</label>
                    <input type="text" name="prenom" class="form-control" value="" id="prenom" required>
                </div>
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
<?php
if (!empty($_POST['submit'])) {
    //print_r2($_POST);
    $utilisateurs = new utilisateurs();
    $utilisateurs->hydrate($_POST);
    // print_r2($utilisateurs);
    // print_r2($_FILES);

    $utilisateurs->setMdp(password_hash($utilisateurs->Getmdp(),PASSWORD_DEFAULT));

    /**
     * ajout de l'utilisateur en BDD
     */
    $utilisateursManager = new utilisateursManager($bdd);
    $ajoutUtilisateur = $utilisateursManager->add($utilisateurs);

    $messageNotification = $utilisateursManager->get_result() == true ? "Votre compte est bien enregistrer !" : "Un problèem est survenu, dommage !";
    $resultNotification = $utilisateursManager->get_result() == true ? "success" : "danger";

    $_SESSION['notification']['result'] = $resultNotification;
    $_SESSION['notification']['message'] = $messageNotification;

    header("Location: index.php");
    exit();
}

include './includes/script.inc.php'; ?>