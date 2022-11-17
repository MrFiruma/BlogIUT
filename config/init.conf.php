<?php
session_start();

//Affichage des erreurs et avertissements PHP
error_reporting(E_ALL);
ini_set("display_errors", 1);

//Fonction debug
function print_r2($tab_a_afficher_print_r) {
    echo '<pre>';
    print_r($tab_a_afficher_print_r);
    echo '</pre>';
}

function loadClass($class) {
    if (is_file("classes/" . $class . ".class.php")) {
        require_once("classes/" . $class . ".class.php");
    }
}

define('nb_articles_par_page', 2);

spl_autoload_register("loadClass");
 
require_once 'bdd.conf.php';
// require_once 'vendor/autoload.php';