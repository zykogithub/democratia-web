<?php
    require_once( "../../../route.php");
    require_once($chemin."/API/Api.php");
    require_once($chemin."/API/ActionPossible.php");
    $idInternaute=$_GET["idInternaute"];
    $idGroupe=$_GET["idGroupe"];
    
    $api = new API();
    $parametres=[$idGroupe,$idInternaute];
    $api->delete($parametres,null,"DELETE FROM infos_membre WHERE id_groupe = ? AND id_internaute = ?");

    header("Location: ../listeGroupes/controleurListeGroupes.php?idInternaute=".$idInternaute);
    exit();
?>
