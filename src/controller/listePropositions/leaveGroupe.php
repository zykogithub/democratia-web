<?php
    
    require_once("/src/utils/ApiClient.php");
    require_once("/API/ActionPossible.php");
    $idInternaute=$_GET["idInternaute"];
    $idGroupe=$_GET["idGroupe"];
    
    $api = new ApiClient();
    $parametres=[$idGroupe,$idInternaute];
    $api->delete($parametres,"DELETE FROM infos_membre WHERE id_groupe = ? AND id_internaute = ?");

    header("Location: ../listeGroupes/controleurListeGroupes.php?idInternaute=".$idInternaute);
    exit();
?>
