<?php

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname("/src/vue/connexion/index.php"), '');
$extra = 'index.php';
if(preg_match("/projets.iut-orsay.fr/",$host)) $host .= "\/saes3-mmarti32\/";
header("Location: http://$host$uri/$extra");
exit;