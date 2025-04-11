<?php
    echo "<!DOCTYPE html>
    <html lang=\"fr\">
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <title>Ajouter une proposition</title>
        <link rel=\"icon\" type=\"image/png\" href=\"../../ressource/image/logo.png\">
        <link rel=\"stylesheet\" href=\"../../ressource/style/creationProposition.css\">
        <link rel=\"stylesheet\" href=\"../../ressource/style/header.css\">
    </head>
    <body>";
        $previousPage="controleurListePropositions.php?idInternaute=".$idInternaute."&idGroupe=".$idGroupe;
        require_once("/src/vue/header.php");
        $groupe = Groupe::getGroupeById($idGroupe);
        echo "<main>
            <h1 class='title'>
                Ajouter une proposition
            </h1>";
            require_once("/src/vue/espaceGroupe/newProposition/formulaireProposition.php");
        echo "</main>
    </body>
    </html>";
?>