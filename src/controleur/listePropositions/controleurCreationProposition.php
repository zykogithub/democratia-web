<?php
    require_once( "../../../route.php");
    require_once("/src/utils/ApiClient.php");
    require_once("/API/ActionPossible.php");
    $idInternaute=$_GET["idInternaute"];
    $idGroupe=$_GET["idGroupe"];

    print_r($_POST);
    echo "</br>";

    $titreProposition = $_POST['propositionTitle'] ?? null;
    $descriptionProposition = $_POST['propositionDescription'] ?? null;
    $dateFinDiscuss = $_POST['propositionDiscussEndDate'] ?? null;
    $idThematique = $_POST['propositionIdThematique'] ?? null;
    $budget = $_POST['propositionBudget'] ?? null;
    $idTypeScrutin = $_POST['propositionTypeScrutin'] ?? null;
    $choixProp = $_POST['propositionChoix'] ?? null;
    $choixProp = array_filter(explode(",", $choixProp));
    $now = date('Y-m-d');
    print_r($choixProp);

    // Création de la proposition
    $parametresProp = [$titreProposition, $descriptionProposition,$now,$dateFinDiscuss,$budget,$idGroupe,$idThematique];
    print_r($parametresProp);
    echo "</br>";
    $api = new ApiClient();
    $api->post($parametresProp,"INSERT INTO proposition (titre_proposition, description_proposition, date_publication, date_fin_discuss, budget, id_groupe, id_thematique) VALUES (?,?,?,?,?,?,?);");
    echo "</br>";
    echo $api->getMessaDerreur();

    // Création du scrutin associé
    $api->get([$titreProposition],"SELECT id_proposition FROM proposition WHERE titre_proposition = ?");
    $idProp=$api->getValeurRetourne()[0]["id_proposition"];
    echo "</br>";
    echo $idProp;
    $api->post([$idProp,$idTypeScrutin,null],);
    echo "</br>";
    echo $api->getMessaDerreur();

    // Ajout des choix au scrutin
    $api->get([$idProp],"SELECT id_vote FROM vote WHERE id_proposition = ?");
    $idVote=$api->getValeurRetourne()[0]["id_vote"];
    echo "</br>";
    echo $idVote;
    foreach($choixProp as $choix){
        $api->patch([$idVote,$choix],);
        echo "</br>";
        echo $api->getMessaDerreur();
    }

    header("Location: controleurListePropositions.php?idInternaute=".$idInternaute."&idGroupe=".$idGroupe);
    exit();
?>
