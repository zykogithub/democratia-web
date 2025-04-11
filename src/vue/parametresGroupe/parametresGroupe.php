<?php
    echo "<!DOCTYPE html>
    <html lang=\"fr\">
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <title>Paramètre du groupe</title>
        <link rel=\"icon\" type=\"image/png\" href=\"../../ressource/image/logo.png\">
        <link rel=\"stylesheet\" href=\"../../ressource/style/header.css\">
        <link rel=\"stylesheet\" href=\"../../ressource/style/parametresGroupe.css\">
    </head>
    <body>";
        $previousPage="../listePropositions/listePropositions.php?idGroupe=".$_GET["idGroupe"]."&idInternaute=".$_GET["idInternaute"];
        require_once("../header.php");
        require_once("../../modele/groupe.php");
        echo "<main>
            <h1 class='title'>
                Paramètre du groupe
            </h1>";
        echo "</main>
    </body>
    </html>";
?>
