<?php
require_once 'config/init.conf.php';

setcookie('sid', '',-1);

$_SESSION['notification']['result'] = 'success';
$_SESSION['notification']['message'] = 'Déconnexion réussi !';

header("Location: index.php");
?>