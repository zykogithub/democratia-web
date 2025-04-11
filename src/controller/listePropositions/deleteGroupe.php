<?php
    
    require_once("/src/utils/ApiClient.php");
    require_once("/API/ActionPossible.php");
    require_once("../../modele/groupe.php");
    $idInternaute=$_GET["idInternaute"];
    $idGroupe=$_GET["idGroupe"];
    $groupe=Groupe::getGroupeById($idGroupe);
    $directory = "../../ressource/image/groupes";
    $imageName = $groupe->get("image");
    $fileLink = $directory.'/'.$imageName;
    echo $fileLink;
    if(unlink($fileLink)){
        $api = new ApiClient();
        $parametres=[$idGroupe];
        $api->delete($parametres,"DELETE FROM groupe WHERE id_groupe = ?");
    }
    header("Location: ../listeGroupes/controleurListeGroupes.php?idInternaute=".$idInternaute);
    exit();
?>