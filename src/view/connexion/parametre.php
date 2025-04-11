<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parametre</title>
    <link rel="icon" type="image/png" href="../../ressource/image/logo.png">
    <link rel="stylesheet" href="../../ressource/style/connexion.css">
    <link rel="stylesheet" href="../../ressource/couleur/theme.css" id="theme">
    <link rel="stylesheet" href="../../ressource/style/header.css">
    <script src="../../script/changementCouleur.js"></script>
</head>
<?php
    // TODO: faire cela côté controleur
    $veutModifier = false;
    $veutSupprimer = false;
    $aSupprimer = false;
    $messageErreur = "";
    $nom = "";
    $prenom = "";
    $domicile = "";
    $courriel = "";
    $mdp = "";
    $messageConfirmation = "";
    $tableauReponse = [];
    $_COOKIE["idInternaute"] = $_GET["idInternaute"];
    
    require_once "/src/utils/ApiClient.php";

    if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["idInternaute"]){
        $id = intval($_GET["idInternaute"]);
        $api = new ApiClient();
        $api->get(array($id),  "SELECT nom_internaute,prenom_internaute,adresse_postale,courriel,hashageMDP FROM internaute WHERE id_internaute = ?");
        if ($api->getCodDeRetourApi() === 200) {
        $data = $api->getValeurRetourne();
            if (isset($data[0])) {
                $nom = $data[0]['nom_internaute'];
                $prenom = $data[0]['prenom_internaute'];
                $domicile = $data[0]['adresse_postale'];
                $courriel = $data[0]['courriel'];
                $mdp = $data[0]['hashageMDP'];
            }
            else $messageErreur = "Aucune donnée n'a été trouvé";
        }
        else $messageErreur = $api->getMessaDerreur();;
    }
    elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['modifier'])) {
            $id = intval($_POST["modifier"]);
            $veutModifier = true;
            $api = new ApiClient();
            $api->get(array($id),  "SELECT nom_internaute,prenom_internaute,adresse_postale,courriel,hashageMDP FROM internaute WHERE id_internaute = ?");
            if ($api->getCodDeRetourApi() === 200) {
            $data = $api->getValeurRetourne();
                if (isset($data[0])) {
                    $nom = $data[0]['nom_internaute'];
                    $prenom = $data[0]['prenom_internaute'];
                    $domicile = $data[0]['adresse_postale'];
                    $courriel = $data[0]['courriel'];
                    $mdp = $data[0]['hashageMDP'];
                }
                else $messageErreur = "Aucune donnée n'a été trouvé";
            }
            else $messageErreur = $api->getMessaDerreur();
        } elseif (isset($_POST['supprimer'])) {
            $id = intval($_POST["supprimer"]);            
            $veutSupprimer = true;
        } elseif (isset($_POST['supprimerCompte'])) {
            $id = intval($_POST["supprimerCompte"]);
            $api = new ApiClient();
            $api->delete(array($id),  "DELETE FROM internaute WHERE id_internaute = ?");
            if ($api->getCodDeRetourApi() === 200) $aSupprimer = true;
            else $messageErreur = $api->getMessaDerreur();
        }
        elseif (isset($_POST['Amodifie'])) {
            $id = intval($_POST["Amodifie"]);
            $api = new ApiClient();
            $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/';
            $estUnMotDepasseValide = preg_match($pattern,$_POST["mdp"]);
            $requeteVerif = "SELECT hashageMDP FROM internaute WHERE courriel=?";
			$api->get([$_POST["courriel"]],$requeteVerif);
			if($api->getCodDeRetourApi()==200){
				$check=$api->getValeurRetourne();
				if (is_array($check) && count($check) == 1) {
					$mdp = $check[0]["hashageMDP"];
					$estLeMemeMdp = password_verify($_POST["mdp"], $mdp);
                }
            }
            if(!$estUnMotDepasseValide || $estLeMemeMdp) {
                $messageErreur = "mot de passe au format incorrecte";
                $veutModifier = true;
                $api->get(array($id),  "SELECT nom_internaute,prenom_internaute,adresse_postale,courriel,hashageMDP FROM internaute WHERE id_internaute = ?");
                if ($api->getCodDeRetourApi() === 200) {
                $data = $api->getValeurRetourne();
                    if (isset($data[0])) {
                        $nom = $data[0]['nom_internaute'];
                        $prenom = $data[0]['prenom_internaute'];
                        $domicile = $data[0]['adresse_postale'];
                        $courriel = $data[0]['courriel'];
                        $mdp = $data[0]['hashageMDP'];
                    }
                    else $messageErreur = "Aucune donnée n'a été trouvé";
                }
                else $messageErreur = $api->getMessaDerreur();;
            }
            else{    
                
                $api->patch(array($_POST['nom'], $_POST['prenom'], $_POST['domicile'], $_POST['courriel'], password_hash($_POST['mdp'],PASSWORD_DEFAULT),$id),  "UPDATE internaute SET nom_internaute = ?, prenom_internaute = ?, adresse_postale = ?, courriel = ?, hashageMDP = ? WHERE id_internaute = ?");
                if ($api->getCodDeRetourApi() === 200) {
                    $messageConfirmation = "Les modifications ont été enregistrées";
                    $api->get(array($id),  "SELECT nom_internaute,prenom_internaute,adresse_postale,courriel,hashageMDP FROM internaute WHERE id_internaute = ?");
                    if ($api->getCodDeRetourApi() === 200) {
                    $data = $api->getValeurRetourne();
                        if (isset($data[0])) {
                            $nom = $data[0]['nom_internaute'];
                            $prenom = $data[0]['prenom_internaute'];
                            $domicile = $data[0]['adresse_postale'];
                            $courriel = $data[0]['courriel'];
                            $mdp = $data[0]['hashageMDP'];
                        }
                        else $messageErreur = "Aucune donnée n'a été trouvé";
                    }
                    else $messageErreur = $api->getMessaDerreur();
                    }
                else $messageErreur = $api->getMessaDerreur();
            }
        }
        else die("Erreur : arrivée sur la page sans id");
    }
    else die("Erreur : arrivée sur la page sans id");

    function supprimerCompte() : void {
        
        
    }
    function modifierCompte() : void {
        
        
    }
    function affichageDonner() : void {
        
    }
    
?>
<body class="theme" id="light">
    <!-- <button onclick="toggleTheme()" ><img src="../../ressource/image/light.png" id="light"></button> -->
    
    <main>
    <div class="connexion-container">
        <?php $idInternaute = $_COOKIE["idInternaute"]; ?>
        <?php if ($veutModifier): ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <h1>Information compte</h1>
                <h2>Le mot de passe doit au moins contenir une majuscule, une minuscule, un chiffre, un caractère spécial et doit être d'une longueur minimale de 8 caractères.</h2>
                <!-- Champs du formulaire -->
                <div class="input-field"><label for="prenom">Prénom</label><input type="text" name="prenom" id="prenom" value="<?php echo $prenom ?>"></div>
                <div class="input-field"><label for="nom">Nom</label><input type="text" name="nom" id="nom"  value="<?php echo $nom ?>"></div>
                <div class="input-field"><label for="domicile">Adresse postale</label><input type="text" name="domicile" id="domicile"  value="<?php echo $domicile ?>"></div>
                <div class="input-field"><label for="courriel">Adresse mail</label><input type="email" name="courriel" id="courriel"  value="<?php echo $courriel ?>"></div>
                <div class="input-field"><label for="mdp">Mot de passe</label><input type="password" name="mdp" id="mdp" ></div>
                <div class="erreurCompte"><?php echo $messageErreur ?></div>
                <!-- Bouton d'inscription -->
                <div class="button-container"><button name="Amodifie" value="<?php echo $id ?>">Enregistrer</div>
                <div class="footer-color"></div>  
            </form>
        <?php elseif ($veutSupprimer): ?>
            <h1>Etes-vous sûr de vouloir supprimer le compte</h1>
            <!-- Bouton d'inscription -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div class="button-container">
                    <button name="supprimerCompte" value="<?php echo $id ?>">Supprimer le compte</button>
                </div>    
            </form>
            <div class="footer-color"></div>
        <?php elseif ($aSupprimer): ?>
            <a href="index.php"><img src="../ressource/image/back.png" alt=""></a>
            <p>Votre compte a été supprimé</p>
            <h1>Quelle mauvaise idée de nous quitter</h1>
            <div class="footer-color"></div>
        <?php else: ?> 
            <?php require "/src/vue/header.php"; ?>
            <h1>Information compte</h1>
            <div class="valideCompte"><?php echo $messageConfirmation ?></div>
            <!-- Champs du formulaire -->
            <div class="input-field"><label for="prenom">Prénom</label><p><?php echo $nom ?></p></div>
            <div class="input-field"><label for="nom">Nom</label><p><?php echo $prenom ?></p></div>
            <div class="input-field"><label for="domicile">Adresse postale</label><p><?php echo $domicile ?></p></div>
            <div class="input-field"><label for="courriel">Adresse mail</label><p><?php echo $courriel ?></p></div>
            <!-- je ne récupère pas le mot de passe car l'affichage de la maquette inplique un input de type password, et on ne veut pas que
                l'utilisateur puisse modifier cette entrée sans avoir appuyer sur le boutton
            En plus, on ne peut pas récupérer le mot de passe originel à partir du mot de passe hasher donc encore pire -->
            <div class="erreurCompte"><?php echo $messageErreur ?></div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div class="button-container">
                    <button name="modifier" value="<?php echo $id ?>">Modifier</button>
                    <button name="supprimer" value="<?php echo $id ?>">Supprimer</button>
                </div>
            </form>
            <div class="footer-color"></div>
        <?php endif; ?>
    </div>
    </main>
</body>
</html>