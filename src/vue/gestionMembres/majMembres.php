<<?php
    require_once( "../../../route.php");
    require_once($chemin."/API/Api.php");
    require_once($chemin."/API/ActionPossible.php");

    if (isset($_GET['deletedMembers'])) {
        $codesRetour=[];
        $idGroupe=$_GET["idGroupe"];
        $deletedMembers = explode(',', $_GET['deletedMembers']);
        $deletedMembers = array_map('intval', $deletedMembers);
        $requete="DELETE FROM infos_membre WHERE id_groupe = ? AND id_internaute = ?";
        $api = new Api();
        foreach($deletedMembers as $idInternaute){
            $api->delete([$idGroupe,$idInternaute],null,$requete);
            $codesRetour[$idInternaute]=$api->getCodDeRetourApi();
        }
        header("Location: gestionMembres.php?idGroupe=".$_GET["idGroupe"]."&idInternaute=".$_GET["idInternaute"]."&codesRetour=".print_r($codesRetour));
        exit();
    }
    header("Location: gestionMembres.php?idGroupe=".$_GET["idGroupe"]."&idInternaute=".$_GET["idInternaute"]);
    exit();
?>