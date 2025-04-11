<?php
    require_once( "../../../route.php");
    require_once($chemin."/API/Api.php");
    require_once($chemin."/API/ActionPossible.php");
    require_once("../../modele/proposition.php");
    $idInternaute=$_GET["idInternaute"];
    $idGroupe=$_GET["idGroupe"];
    $idProposition=$_GET["idProposition"];
    $api = new API();
    $parametres=[$idProposition];
    $api->delete($parametres,null,"DELETE FROM proposition WHERE id_proposition = ?");
    header("Location: ../listePropositions/controleurListePropositions.php?action=optionsRole&idGroupe=".$idGroupe."&idInternaute=".$idInternaute);
    exit();
?>