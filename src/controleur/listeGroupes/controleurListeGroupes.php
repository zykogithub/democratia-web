<?php
    require_once("../../../route.php");
    $internautePresent = (isset($_GET["idInternaute"])&&($_GET["idInternaute"]!=""));
    $actionPresnte = (isset($_GET["action"])&&($_GET["action"]=="creerGroupe"));
    if($internautePresent && $actionPresnte){
        $idInternaute=$_GET["idInternaute"];
        require_once("/src/vue/espaceUtilisateur/newGroupe/newGroupe.php");
    }else if($internautePresent){
        $idInternaute=$_GET["idInternaute"];
        require_once("/src/vue/espaceUtilisateur/listGroupes/listGroupes.php");
    }else{
        header("Location: ../../vue/connexion/");
        exit();
    }
?>