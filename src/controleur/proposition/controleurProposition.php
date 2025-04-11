<?php
// Inclusion des modèles
require_once '../../modele/propositionDetails.php';
require_once '../../../API/Api.php';

// Variables dynamiques
$page = "controleurProposition.php";
$idProposition = $_GET['idProposition'] ?? $_POST['idProposition'] ?? 4;
$idInternaute = $_GET['idInternaute'] ?? $_POST['idInternaute'] ?? 77;
$action = $_GET['action'] ?? $_POST['action'] ?? null;


// Initialisation de l'API et de l'objet Proposition
$api = new Api();

$proposition = new Proposition($api, (int)$idProposition);

// Gestion des actions
switch ($action) {
    case 'back':
        header("Location: ../listePropositions/controleurListePropositions.php?idInternaute=".$idInternaute."&idGroupe=".$proposition->get("idGroupe"));
        exit;

    case 'voter':
        $proposition->toggleVoteRequest($idInternaute);
        break;
        
    case 'vote':
        // Valider le choix
        $choice = trim($_GET['selected_choice'] ?? $_POST['selected_choice'] ?? '');
        if (empty($choice)) {
            throw new Exception("Aucun choix sélectionné pour le vote.");
        }

        // Appeler la méthode de vote
        $proposition->vote((int)$idInternaute, (int)$choice);
        break;

    case 'like':
        $proposition->like((int)$idInternaute);
        break;

    case 'dislike':
        $proposition->dislike((int)$idInternaute);
        break;

    case 'parapetres':
        header("Location: controleurSettingsProposition.php?idProposition=" . urlencode($idProposition) . "&idInternaute=" . urlencode($idInternaute));
        exit;

    case 'ajouter_commentaire':
        $commentaire = trim($_GET['contenu_message'] ?? $_POST['contenu_message'] ?? '');
        if (empty($commentaire)) {
            throw new Exception("Le contenu du commentaire est vide.");
        }
        $proposition->ajouterCommentaire((int)$idInternaute, $commentaire);
        break;
}


// Récupération des détails de la proposition
$detailsProposition = $proposition->getPropositionDetails();
$detailsProposition['nombre_demandes_vote'] = $proposition->getNombreDemandesVote();
$detailsProposition['nombre_likes'] = $proposition->getNombreLikes();
$detailsProposition['nombre_dislikes'] = $proposition->getNombreDislikes();

$commentaires = $proposition->getCommentaires();

$userHasLiked = $proposition->checkIfUserLiked($idInternaute);
$userHasDisliked = $proposition->checkIfUserDisliked($idInternaute);
$userHasVoted = $proposition->checkIfUserVoted($idInternaute);


$voteFinished = $proposition->checkIfVoteFinished();
$voteInProgress = $proposition->checkIfVoteInProgress();

$desideur = $proposition->Desideur($idInternaute);

if ($voteFinished){
    $detailsvotes = $proposition->getVotesProposition();

    $choixStatistiques = [];
    foreach ($detailsvotes as $vote) {
        $choix = $vote['libelle_choix'];
        $choixStatistiques[$choix] = ($choixStatistiques[$choix] ?? 0) + 1;
    }
    $totalVotes = count($detailsvotes);

    echo '<!DOCTYPE html>';
    echo '<html lang="fr">';
    echo '<head>';
    echo '    <meta charset="UTF-8">';
    echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '    <title>Proposition</title>';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/general.css">';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/headerProposition.css">';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/bandeauTitreProposition.css">';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/detailsVotesProposition.css">';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/footerProposition.css">';
    echo '</head>';
    echo '<body>';

    include "../../vue/proposition/headerProposition.php";

    echo '<main>';
    include "../../vue/proposition/bandeauTitreProposition.php";
    include "../../vue/proposition/detailsVotesProposition.php";
    echo '</main>';
    
    include "../../vue/proposition/footerProposition.php";
}
else{
    if ($voteInProgress){
        
        $choices = $proposition->getChoices();
        $verifVote = $proposition->getVerifVote($idInternaute);

        echo '<!DOCTYPE html>';
        echo '<html lang="fr">';
        echo '<head>';
        echo '    <meta charset="UTF-8">';
        echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '    <title>Proposition</title>';
        echo '    <link rel="stylesheet" href="../../ressource/style/proposition/general.css">';
        echo '    <link rel="stylesheet" href="../../ressource/style/proposition/headerProposition.css">';
        echo '    <link rel="stylesheet" href="../../ressource/style/proposition/bandeauTitreProposition.css">';
        echo '    <link rel="stylesheet" href="../../ressource/style/proposition/chatProposition.css">';
        echo '    <link rel="stylesheet" href="../../ressource/style/proposition/voteProposition.css">';
        if (empty($choices) && $desideur){
            echo ' <link rel="stylesheet" href="../../ressource/style/proposition/boutonOrganiserVote.css">';
        }
        echo '    <link rel="stylesheet" href="../../ressource/style/proposition/footerProposition.css">';
        echo '</head>';
        echo '<body>';

        include "../../vue/proposition/headerProposition.php";

        echo '<main>';
        include "../../vue/proposition/bandeauTitreProposition.php";
        include "../../vue/proposition/chatProposition.php";
        include "../../vue/proposition/voteProposition.php";
        if ($desideur && empty($choices)){
            include "../../vue/proposition/boutonOrganiserVote.php";
        }
        echo '</main>';

        include "../../vue/proposition/footerProposition.php";
    }
    else{
        echo '<!DOCTYPE html>';
        echo '<html lang="fr">';
        echo '<head>';
        echo '    <meta charset="UTF-8">';
        echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '    <title>Proposition</title>';
        echo '    <link rel="stylesheet" href="../../ressource/style/proposition/general.css">';
        echo '    <link rel="stylesheet" href="../../ressource/style/proposition/headerPropositionLike.css">';
        echo '    <link rel="stylesheet" href="../../ressource/style/proposition/bandeauTitreProposition.css">';
        echo '    <link rel="stylesheet" href="../../ressource/style/proposition/chatProposition.css">';
        echo '    <link rel="stylesheet" href="../../ressource/style/proposition/ajoutCommentaireProposition.css">';
        echo '    <link rel="stylesheet" href="../../ressource/style/proposition/footerProposition.css">';
        if ($desideur){
            echo ' <link rel="stylesheet" href="../../ressource/style/proposition/boutonOrganiserVote.css">';
        }

        echo '</head>';
        echo '<body>';

        include "../../vue/proposition/headerPropositionLike.php";

        echo '<main>';
        include "../../vue/proposition/bandeauTitreProposition.php";
        include "../../vue/proposition/chatProposition.php";
        include "../../vue/proposition/ajoutCommentaireProposition.php";
        if ($desideur){
            include "../../vue/proposition/boutonOrganiserVote.php";
        }
        echo '</main>';

        include "../../vue/proposition/footerProposition.php";
    }
}
