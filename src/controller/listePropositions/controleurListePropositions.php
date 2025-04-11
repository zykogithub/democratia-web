<?php
    
    $actions=["creerProposition","gestionMembres","optionsRole"];
    $internautePresent = (isset($_GET["idInternaute"])&&($_GET["idInternaute"]!=""));
    $groupePresent = (isset($_GET["idGroupe"])&&($_GET["idGroupe"]!=""));
    $actionPresnte = (isset($_GET["action"])&&(in_array($_GET["action"],$actions)));
    if($internautePresent && $groupePresent && $actionPresnte){
        $idInternaute=$_GET["idInternaute"];
        $idGroupe=$_GET["idGroupe"];
        require_once("/src/modele/groupe.php");
        switch($_GET["action"]){
            case "creerProposition":
                require_once("../../vue/espaceGroupe/newProposition/newProposition.php");
                break;
            case "gestionMembres":
                require_once("/src/modele/Internaute.php");
                require_once("../../vue/espaceGroupe/manageMembers/manageMembers.php");
                break;
            case "optionsRole":
                require_once("../../modele/Internaute.php");
                require_once("../../modele/proposition.php");
                require_once("../../vue/espaceGroupe/roleOptions/roleOptions.php");
                break;
        }
        
    }else if($internautePresent && $groupePresent){
        $idInternaute=$_GET["idInternaute"];
        $idGroupe=$_GET["idGroupe"];
        require_once("/src/modele/proposition.php");
        require_once("/src/modele/groupe.php");
        require_once("/src/modele/Internaute.php");
        require_once("../../vue/espaceGroupe/listPropositions/listPropositions.php");
    }else{
        header("Location: ../../vue/connexion/");
        exit();
    }
?>