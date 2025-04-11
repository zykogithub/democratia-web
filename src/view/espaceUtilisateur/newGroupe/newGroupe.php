<?php
    echo "<!DOCTYPE html>
    <html lang=\"fr\">
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <title>Création de groupe</title>
        <link rel=\"icon\" type=\"image/png\" href=\"../../ressource/image/logo.png\">
        <link rel=\"stylesheet\" href=\"../../ressource/style/creationGroupe.css\">
        <link rel=\"stylesheet\" href=\"../../ressource/style/header.css\">
    </head>
    <body>";
        $previousPage="controleurListeGroupes.php?idInternaute=".$idInternaute;
        require_once("/src/vue/header.php");
        echo "<main>
            <h1 class='title'>
                Création de groupe
            </h1>";
            require_once("/src/vue/espaceUtilisateur/newGroupe/formulaireGroupe.php");
        echo "</main>
    </body>
    </html>";
?>
