<?php
    echo "<!DOCTYPE html>
    <html lang=\"fr\">
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <title>Liste des Propositions</title>
        <link rel=\"icon\" type=\"image/png\" href=\"../../ressource/image/logo.png\">
        <link rel=\"stylesheet\" href=\"../../ressource/style/listePropositions.css\">
        <link rel=\"stylesheet\" href=\"../../ressource/style/header.css\">
    </head>
    <body>";
        require_once( "../../../route.php");
        $previousPage="../listeGroupes/listeGroupes.php?idInternaute=".$_GET["idInternaute"];
        require_once("/src/vue/header.php");
        require_once("/src/modele/proposition.php");
        require_once("/src/modele/groupe.php");
        $groupe = Groupe::getGroupeById($_GET["idGroupe"]);
        echo "<main>";
            $groupe->page();
            Proposition::afficherPropositionsUtilisateur($groupe);
        echo "</main>
    </body>
    </html>";
?>
