<?php
    
    require_once("/src/utils/ApiClient.php");
    require_once("/API/ActionPossible.php");
    $idInternaute=$_GET["idInternaute"];

    $nomGroupe = $_POST['groupeName'] ?? null;
    $couleurGroupe = $_POST['groupeColor'] ?? null;
    $budgetGroupe = $_POST['groupeBudget'] ?? null;
    $themesRecues = $_POST['groupeThematiques'] ?? null;
    $nbjDftDiscuss = $_POST['groupeNbjDftDiscuss'] ?? null;
    $nbjDftVote = $_POST['groupeNbjDftVote'] ?? null;

    $api = new ApiClient();

    // Création du groupe
    $parametres = [$nomGroupe,$couleurGroupe,$budgetGroupe,$nbjDftVote,$nbjDftDiscuss];

    $api->post($parametres,null);
    echo $api->getMessaDerreur();
    $api->get([$nomGroupe],"SELECT id_groupe FROM groupe WHERE nom_groupe = ?");
    $resultat = $api->getValeurRetourne();
    print_r($resultat);
    $idGroupe = $resultat[0]['id_groupe'];
    $api->post([$idGroupe,$idInternaute],"INSERT INTO infos_membre (id_groupe, id_internaute, id_notification, id_role) VALUES (?,?,(SELECT MAX(id_notification) FROM notification),2)");

    $imageGroupe = $_FILES['groupeImage'] ?? null;
    $dossierImages = '../../ressource/image/groupes';

    if ($imageGroupe && $imageGroupe['error'] === UPLOAD_ERR_OK) {
        $extension = strtolower(pathinfo($imageGroupe['name'], PATHINFO_EXTENSION));

        if (in_array($extension, ['jpg', 'png'])) {
            $imageName = $idGroupe.".".$extension;
            $destination = $dossierImages . '/' . $imageName;
            move_uploaded_file($imageGroupe['tmp_name'], $destination);
            $api->patch([$imageName,$idGroupe],"UPDATE groupe SET image = ? WHERE id_groupe = ?");
        }
    }

    // Ajout des thématiques aux groupe

    // Construction du tableau des themes du groupe
    $themesRecues = array_filter(explode("\n", $themesRecues));
    $themesGroupe=[];
    foreach($themesRecues as $thematique){
        $themesGroupe[]=array_filter(explode(",", $thematique));
    }
    // Récupérer la liste des thématiques présentes
    $api->get([],"SELECT * FROM thematique");
    $resultats = $api->getValeurRetourne();
    $thematiques=[];
    foreach($resultats as $thematique){
        $thematiques[$thematique["id_thematique"]]=$thematique["nom_thematique"];
    }
    // Ajouter les thématiques non présentes
    foreach($themesGroupe as $thematique){
        if(!in_array($thematique[0], $thematiques)){
            $api->post([$thematique[0]],"INSERT INTO thematique (nom_thematique) VALUES (?)");
        }
    }
    // Récupérer la liste des thématiques présentes mises à jours
    $api->get([],"SELECT * FROM thematique");
    $resultats = $api->getValeurRetourne();
    $thematiques=[];
    foreach($resultats as $thematique){
        $thematiques[$thematique["nom_thematique"]]=$thematique["id_thematique"];
    }
    // Insérer les thématiques du groupe
    foreach($themesGroupe as $thematique){
        $api->get([$thematique[0]],"SELECT id_thematique FROM thematique WHERE nom_thematique = ?");
        $resultat=$api->getValeurRetourne();
        $idTheme=$resultat[0]["id_thematique"];
        $api->post([$idGroupe,$idTheme,$thematique[1]],"INSERT INTO theme_groupe (id_groupe, id_thematique, budget_thematique) VALUES (?,?,?)");
    }

    header("Location: controleurListeGroupes.php?idInternaute=".$idInternaute);
    exit();
?>
