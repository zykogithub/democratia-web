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
        $previousPage="controleurListePropositions.php?idInternaute=".$idInternaute."&idGroupe=".$idGroupe;
        require_once("/src/vue/header.php");
        $utilisateur = Internaute::getInternauteById($idGroupe,$idInternaute);
        $groupe = Groupe::getGroupeById($idGroupe);
        echo "<main>
            <h1 class='title'>
                ".$groupe->get("nomGroupe")."</br>Gestion des membres
            </h1>";
            if($utilisateur->get("role")=="Administrateur"){
                require_once("/src/vue/espaceGroupe/manageMembers/containerAjoutMembres.php");
            }
            Internaute::afficherMembresGroupe($idGroupe,$utilisateur->get("role"));
        echo "</main>
    </body>
    </html>";
?>
