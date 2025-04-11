<?php
    require_once( "../../../route.php");
    require_once($chemin."/API/Api.php");
    require_once($chemin."/API/ActionPossible.php");
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
    $api = new Api();
    $api->post($parametresProp,null,"INSERT INTO proposition (titre_proposition, description_proposition, date_publication, date_fin_discuss, budget, id_groupe, id_thematique) VALUES (?,?,?,?,?,?,?);");
    echo "</br>";
    echo $api->getMessaDerreur();

    // Création du scrutin associé
    $api->get([$titreProposition],null,"SELECT id_proposition FROM proposition WHERE titre_proposition = ?");
    $idProp=$api->getValeurRetourne()[0]["id_proposition"];
    echo "</br>";
    echo $idProp;
    $api->post([$idProp,$idTypeScrutin,null],PostMethode::demarrerVote,null,);
    echo "</br>";
    echo $api->getMessaDerreur();

    // Ajout des choix au scrutin
    $api->get([$idProp],null,"SELECT id_vote FROM vote WHERE id_proposition = ?");
    $idVote=$api->getValeurRetourne()[0]["id_vote"];
    echo "</br>";
    echo $idVote;
    foreach($choixProp as $choix){
        $api->patch([$idVote,$choix],PatchMethode::enregistrerChoixVote,null,);
        echo "</br>";
        echo $api->getMessaDerreur();
    }

    header("Location: controleurListePropositions.php?idInternaute=".$idInternaute."&idGroupe=".$idGroupe);
    exit();
?>
