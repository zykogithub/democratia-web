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
        $previousPage="../listeGroupes/controleurListeGroupes.php?idInternaute=".$idInternaute;
        require_once("/src/vue/header.php");
        $internaute = Internaute::getInternauteById($_GET["idGroupe"],$_GET["idInternaute"]);
        $groupe = Groupe::getGroupeById($_GET["idGroupe"]);
        echo "<main>";
            $groupe->page();
            Proposition::afficherPropositionsUtilisateur($groupe);
            echo"<div id=\"newPropositionButton\">
                <a href='controleurListePropositions.php?action=creerProposition&idInternaute=".$idInternaute."&idGroupe=".$idGroupe."'>Créer un groupe</a>
            </div>";
        echo "</main>
    </body>
    </html>";
?>
