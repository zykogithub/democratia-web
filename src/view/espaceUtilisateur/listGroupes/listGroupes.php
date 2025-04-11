<?php
    echo "<!DOCTYPE html>
    <html lang=\"fr\">
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <title>Mon espace</title>
        <link rel=\"icon\" type=\"image/png\" href=\"../../ressource/image/logo.png\">
        <link rel=\"stylesheet\" href=\"../../ressource/style/listeGroupes.css\">
        <link rel=\"stylesheet\" href=\"../../ressource/style/header.css\">
    </head>
    <body>";
        $previousPage="controleurListeGroupes.php?idInternaute=".$idInternaute;
        require_once("/src/vue/header.php");
        require_once("/src/modele/groupe.php");
        echo "<main>
            <h1 class='title'>
                Mes groupes
            </h1>";
            Groupe::afficherGroupesUtilisateur(intval($_GET["idInternaute"]));
            echo"<div id=\"newGroupeButton\">
                <a href='controleurListeGroupes.php?idInternaute=".$idInternaute."&action=creerGroupe'>Créer un groupe</a>
            </div>";
        echo "</main>
    </body>
    </html>";
?>
