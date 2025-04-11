<<?php
    require_once( "../../../route.php");
    require_once($chemin."/API/Api.php");
    require_once($chemin."/API/ActionPossible.php");

    if (isset($_GET['ids'])) {
        $codesRetour=[];
        $idGroupe=$_GET["idGroupe"];
        $idInternautes = explode(',', $_GET['ids']);
        $idInternautes = array_map('intval', $idInternautes);
        $api = new Api();
        foreach($idInternautes as $idInternaute){
            $api->post([$idGroupe,$idInternaute],PostMethode::AjouterMembre,null);
            $codesRetour[$idInternaute]=$api->getCodDeRetourApi();
        }
        header("Location: gestionMembres.php?idGroupe=".$_GET["idGroupe"]."&idInternaute=".$_GET["idInternaute"]."&codesRetour=".print_r($codesRetour));
        exit();
    }
    header("Location: gestionMembres.php?idGroupe=".$_GET["idGroupe"]."&idInternaute=".$_GET["idInternaute"]);
    exit();
?>