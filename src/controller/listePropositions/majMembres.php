<<?php
    
    require_once("/src/utils/ApiClient.php");
    require_once("/API/ActionPossible.php");

    $idGroupe=$_GET["idGroupe"];
    $idInternaute=$_GET["idInternaute"];
    $deletedMembers = explode(',', $_GET['deletedMembers']);
    $deletedMembers = array_map('intval', $deletedMembers);
    $memberIds = explode(',', $_GET['memberIds']);
    $memberIds = array_map('intval', $memberIds);
    $newRoles = explode(',', $_GET['newRoles']);
    $newRoles = array_map('intval', $newRoles);
    $modifs = "";

    if (isset($_GET['memberIds'])){
        $requete="UPDATE infos_membre SET id_role = ? WHERE id_groupe = ? AND id_internaute = ?";
        $api = new ApiClient();
        for($i=0;$i<count($memberIds);$i++){
            if (!in_array($memberIds[$i], $deletedMembers)){
                $api->patch([$newRoles[$i],$idGroupe,$memberIds[$i]],$requete);
            }
        }
    }
    if (isset($_GET['deletedMembers'])) {
        $requete="DELETE FROM infos_membre WHERE id_groupe = ? AND id_internaute = ?";
        $api = new ApiClient();
        foreach($deletedMembers as $idMembre){
            $api->delete([$idGroupe,$idMembre],$requete);
        }
    }
    header("Location: controleurListePropositions.php?action=gestionMembres&idGroupe=".$idGroupe."&idInternaute=".$idInternaute);
    exit();
?>