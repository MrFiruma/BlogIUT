<?php require './config/init.conf.php';
include './includes/header.inc.php';
include './includes/nav.inc.php';
require_once './vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates/');
$twig = new \Twig\Environment($loader, ['debug'=>true]);

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

echo $twig->render('utilisateurs.html.twig');

include './includes/script.inc.php'; ?>