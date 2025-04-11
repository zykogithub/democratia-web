<?php
    echo "<!DOCTYPE html>
    <html lang=\"fr\">
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <title>Gestion des membres</title>
        <link rel=\"icon\" type=\"image/png\" href=\"../../ressource/image/logo.png\">
        <link rel=\"stylesheet\" href=\"../../ressource/style/header.css\">
        <link rel=\"stylesheet\" href=\"../../ressource/style/gestionMembres.css\">
    </head>
    <body>";
        $previousPage="../listePropositions/listePropositions.php?idGroupe=".$_GET["idGroupe"]."&idInternaute=".$_GET["idInternaute"];
        require_once("../header.php");
        require_once("../../modele/groupe.php");
        require_once("../../modele/Internaute.php");
        $utilisateur = Internaute::getInternauteById($_GET["idGroupe"],$_GET["idInternaute"]);
        $groupe = Groupe::getGroupeById($_GET["idGroupe"]);
        echo "<main>
            <h1 class='title'>
                ".$groupe->get("nomGroupe")."</br>Gestion des membres
            </h1>";
            if($utilisateur->get("role")=="Administrateur"){
                require_once("containerAjoutMembres.php");
            }
            Internaute::afficherMembresGroupe($groupe->get("idGroupe"),$utilisateur->get("role"));
        echo "</main>
    </body>
    </html>";
?>
