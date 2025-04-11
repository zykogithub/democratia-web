<?php
    
    require_once("/src/utils/ApiClient.php");
    require_once("/API/ActionPossible.php");
    require_once("../../modele/proposition.php");
    $idInternaute=$_GET["idInternaute"];
    $idGroupe=$_GET["idGroupe"];
    $idProposition=$_GET["idProposition"];
    $api = new ApiClient();
    $parametres=[$idProposition];
    $api->delete($parametres,"DELETE FROM proposition WHERE id_proposition = ?");
    header("Location: ../listePropositions/controleurListePropositions.php?action=optionsRole&idGroupe=".$idGroupe."&idInternaute=".$idInternaute);
    exit();
?>