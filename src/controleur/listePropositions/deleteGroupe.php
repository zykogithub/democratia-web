<?php
    require_once( "../../../route.php");
    require_once($chemin."/API/Api.php");
    require_once($chemin."/API/ActionPossible.php");
    require_once("../../modele/groupe.php");
    $idInternaute=$_GET["idInternaute"];
    $idGroupe=$_GET["idGroupe"];
    $groupe=Groupe::getGroupeById($idGroupe);
    $directory = "../../ressource/image/groupes";
    $imageName = $groupe->get("image");
    $fileLink = $directory.'/'.$imageName;
    echo $fileLink;
    if(unlink($fileLink)){
        $api = new API();
        $parametres=[$idGroupe];
        $api->delete($parametres,null,"DELETE FROM groupe WHERE id_groupe = ?");
    }
    header("Location: ../listeGroupes/controleurListeGroupes.php?idInternaute=".$idInternaute);
    exit();
?>