<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../ressource/style/connexion.css">
    <link rel="stylesheet" href="../../ressource/couleur/theme.css" id="theme">
    <script src="../../scripts/changementCouleur.js"></script>
    <title>Connexion</title>
    <link rel="icon" type="image/png" href="../../ressource/image/logo.png">
</head>
<?php
    // TODO : bug : la création de personne en doublon est possible
    // TODO : ne pas modifier utilisateur isabelle jusqu'à la fin du développement
    // TODO : permettre l'entièreté de la navigation via un bouton de retour en arrière
    $messageErreur = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        include "../../../route.php";
        require_once($chemin."//API//Api.php");
        include $chemin."//src//controleur//controleurConnexion.php";
        $messageErreur = $api->getMessaDerreur();
        if(isset($internaute)) {
            $host  = $_SERVER['HTTP_HOST'];
            $uri   = rtrim(dirname("/src/controleur/listeGroupes/controleurListeGroupes.php"), '');
            $extra = 'controleurListeGroupes.php';
            if(preg_match("/projets.iut-orsay.fr/",$host)) $host .= "\/saes3-mmarti32\/";
            $idInternaute = $internaute->get('id_internaute');
            header("Location: http://$host$uri/$extra?idInternaute=$idInternaute");
            exit;
            
            // TODO : exiger la redirection au controleur
        }
        elseif (isset($check,$_POST["courriel"],$_POST["mdp"]) && $check===0) $messageErreur = "Adresse mail ou mot de passe oublié";
            
    }
            
?>
<body class="theme" id="light">
    <button onclick="toggleTheme()" ><img src="../../ressource/image/light.png" id="light"></button>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="connexion-container" >
            <header>
                <div class="logo">
                    <img src="../../ressource/image/logo.png" alt="Logo">
                </div>
            </header>    
            <h1>Bon retour parmi nous</h1>
            <div class="input-field">
                <label for="courriel">Adresse mail</label>
                <input type="email" id="courriel" name="courriel">
            </div>
            <div class="input-field">
                <label for="mdp">Mot de passe</label>
                <input type="password" id="mdp" name="mdp">
            </div>
    
            <div class="lien-creation">
                Pas de compte ? <a href="creationCompte.php">Créez en un !</a>
                
            </div>
            <div class="erreurCompte">
                <?php 
                    echo $messageErreur
                ?>
            </div>
            
            
            
            <div class="button-container">
                <button type="submit">Se connecter</button>
            </div>
            
            
            <div class="footer-color"></div>
        </div>
    </form>
</body>
</html>
