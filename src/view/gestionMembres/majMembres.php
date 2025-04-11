<<?php
    
    require_once("/src/utils/ApiClient.php");
    require_once("/API/ActionPossible.php");

    if (isset($_GET['deletedMembers'])) {
        $codesRetour=[];
        $idGroupe=$_GET["idGroupe"];
        $deletedMembers = explode(',', $_GET['deletedMembers']);
        $deletedMembers = array_map('intval', $deletedMembers);
        $requete="DELETE FROM infos_membre WHERE id_groupe = ? AND id_internaute = ?";
        $api = new ApiClient();
        foreach($deletedMembers as $idInternaute){
            $api->delete([$idGroupe,$idInternaute],$requete);
            $codesRetour[$idInternaute]=$api->getCodDeRetourApi();
        }
        header("Location: gestionMembres.php?idGroupe=".$_GET["idGroupe"]."&idInternaute=".$_GET["idInternaute"]."&codesRetour=".print_r($codesRetour));
        exit();
    }
    header("Location: gestionMembres.php?idGroupe=".$_GET["idGroupe"]."&idInternaute=".$_GET["idInternaute"]);
    exit();
?>