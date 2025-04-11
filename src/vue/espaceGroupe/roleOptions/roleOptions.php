<?php
    echo "<!DOCTYPE html>
    <html lang=\"fr\">
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <title>Paramètre du groupe</title>
        <link rel=\"icon\" type=\"image/png\" href=\"../../ressource/image/logo.png\">
        <link rel=\"stylesheet\" href=\"../../ressource/style/header.css\">
        <link rel=\"stylesheet\" href=\"../../ressource/style/optionsGroupe.css\">
    </head>
    <body>";
        $previousPage="controleurListePropositions.php?idInternaute=".$idInternaute."&idGroupe=".$idGroupe;
        require_once($chemin."/src/vue/header.php");
        $internaute=Internaute::getInternauteById($idGroupe,$idInternaute);
        $groupe=Groupe::getGroupeById($idGroupe);
        echo "<main>
            <h1 class='title'>".
                $groupe->get("nomGroupe")."</br>
                Options > ".$internaute->get("role").
            "</h1>";
            $roleInternaute=$internaute->get("role");
            if($roleInternaute=="Administrateur"){
                require_once($chemin."/src/vue/espaceGroupe/roleOptions/deleteGroupeButton.php");
            }else{
                if($roleInternaute== "Modérateur"){
                    require_once($chemin."/src/vue/espaceGroupe/roleOptions/deletePropositionsBloc.php");
                }
                require_once($chemin."/src/vue/espaceGroupe/roleOptions/leaveGroupeButton.php");
            }
        echo "</main>
    </body>
    </html>";
?>
