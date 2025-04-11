<?php

$idInternaute = intval($_GET["idInternaute"]);
echo "
    <header>
        <a href='".$previousPage."'>
            <img src='../../ressource/image/back.png' alt='Logo'>
        </a>
        <a href='../../controleur/listeGroupes/controleurListeGroupes.php?idInternaute=".$idInternaute."'>
            <img src='../../ressource/image/logo_white_border.png' alt='Logo'>
        </a>
        <a href='../../vue/connexion/parametre.php?idInternaute=$idInternaute'>
            <img src='../../ressource/image/user.png' alt='userIcon'>
        </a>
    </header>";
?>