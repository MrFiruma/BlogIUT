<?php

/**
 * Verification de l'existence du cookie + récup des infos utilisateurs
 */
$isConnected = false;

if (isset($_COOKIE["sid"])) {

    $utilisateursManager = new utilisateursManager($bdd);
    $utilisateursEnBdd = $utilisateursManager->getBySid($_COOKIE["sid"]);
    // print_r2($utilisateursEnBdd);

    $isConnected = true;
    
}

/**
 *  affichage d'un texte si connection accepté
 */
if ($isConnected == true) {
    echo "Connecté";
}

?>