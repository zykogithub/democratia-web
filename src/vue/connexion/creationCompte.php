  <!DOCTYPE html>
  <html lang="fr">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Créer un compte</title>
      <link rel="icon" type="image/png" href="../../ressource/image/logo.png">
      <link rel="stylesheet" href="../../ressource/style/connexion.css">
      <link rel="stylesheet" href="../../ressource/couleur/theme.css" id="theme">
      <script src="../../script/changementCouleur.js"></script>
  </head>
  <?php
  // TODO : faire cela côté controleur
    $messageErreur = "";
    $estEnregistre = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        include "../../../route.php";
        require_once($chemin."/API/Api.php");
        $api = new Api();
        $tousLesChampsRemplis = isset($_POST["courriel"],$_POST["mdp"],$_POST['prenom'],$_POST["nom"],$_POST["domicile"]);
        if($tousLesChampsRemplis) {
           $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/';
           $estUnMotDepasseValide = preg_match($pattern,$_POST["mdp"]);
           if(!$estUnMotDepasseValide) $messageErreur = "mot de passe au format incorrecte";
           else{
              $hashMdp = password_hash($_POST["mdp"], PASSWORD_DEFAULT); 
              $api->post([$_POST['nom'], $_POST['prenom'], $_POST['domicile'], $_POST['courriel'], $hashMdp], null, "INSERT INTO internaute (nom_internaute ,prenom_internaute ,adresse_postale,courriel,hashageMDP) VALUES (?,?,?,?,?)");
              if ($api->getCodDeRetourApi()===CodeDeRetourApi::OK->value) $estEnregistre = true;
              else $messageErreur = $api->getMessaDerreur();
           }
          
        }
        else $messageErreur = "Tous les champs ne sont pas remplis";
            
    }
            
?>
  <body class="theme" id="light">  
    <?php if ($estEnregistre): ?>
      <button onclick="toggleTheme()" ><img src="../../ressource/image/light.png"." id="."light"."></button>
      <div class="connexion-container">
        <header>
            <div class="logo"><img src="../../ressource/image/logo.png" alt="Logo"></div>
        </header>
        <h1>Votre compte a été crée</h1>
        <p>Quelle bonne idée de vous joindre à nous</p>
        <!-- Bouton d'inscription -->
          <div class="button-container">
            <button onclick="window.location.href='index.php';">Me connecter</button>
          </div>
        <div class="footer-color"></div>
      </div> 
    <?php else: ?>
      <button onclick="toggleTheme()" ><img src="../../ressource/image/light.png" id="light"></button>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div class="connexion-container">
          <header>
              <div class="logo"><img src="../../ressource/image/logo.png" alt="Logo"></div>
          </header>
          <h1>Inscription</h1>
          <div class="lien-creation">Déjà un compte ? <a href="<?php echo htmlspecialchars("index.php")  ?>">Connectez-vous !</a></div>
          <h2>Le mot de passe doit au moins contenir une majuscule, une minuscule, un chiffre, un caractère spécial et doit être d'une longueur minimale de 8 caractères.</h2>
          <!-- Champs du formulaire -->
          <div class="input-field"><label for="prenom">Prénom</label><input type="text" name="prenom" id="prenom" ></div>
          <div class="input-field"><label for="nom">Nom</label><input type="text" name="nom" id="nom" ></div>
          <div class="input-field"><label for="domicile">Adresse postale</label><input type="text" name="domicile" id="domicile" ></div>
          <div class="input-field"><label for="courriel">Adresse mail</label><input type="email" name="courriel" id="courriel" ></div>
          <div class="input-field"><label for="mdp">Mot de passe</label><input type="password" name="mdp" id="mdp" ></div>
          <div class="erreurCompte"><?php echo $messageErreur ?></div>
          <!-- Bouton d'inscription -->
          <div class="button-container"><button type="submit">M'inscrire</button></div>
          <div class="footer-color"></div>
        </div>  
      </form>
    <?php endif; ?>
  </body>
  </html>