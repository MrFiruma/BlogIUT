<?php require './config/init.conf.php';
require './config/check-connected.php';
require_once './vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates/');
$twig = new \Twig\Environment($loader, ['debug'=>true]);

include './includes/header.inc.php';
include './includes/nav.inc.php';

$articlesManager = new articlesManager($bdd);

$listeArticles = $articlesManager->getList();

// print_r2($articles);

$page = !empty($_GET['page']) ? $_GET['page'] : 1;

$articlesManager = new articlesManager($bdd);
$nbArticlesTotalAPublie = $articlesManager->countArticles();

$nbPages = ceil($nbArticlesTotalAPublie / nb_articles_par_page);

$indexDepart = ($page - 1) * nb_articles_par_page;

$listeArticles = $articlesManager->getListArticlesAAfficher($indexDepart, nb_articles_par_page);

//print_r2($listeArticles);
//var_dump($bdd);

// On détermine sur quelle page on se trouve
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}

echo $twig->render('index.html.twig', 
            [
                'session' => $_SESSION,
                'ListeArticles' => $listeArticles,
                // 'utilisateurConnecte' => $utilisateurConnecte,
                'nbPages' => $nbPages,
                'page' => $page
            ]);
unset ($_SESSION['notification']);
    
include './includes/script.inc.php'; 
?>