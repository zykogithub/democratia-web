<?php
// Inclusion des modèles
require_once '../../modele/propositionDetails.php';
require_once '../../../src/utils/ApiClient.php';

// Variables dynamiques
$page = "controleurVoteProposition.php";
$idProposition = $_GET['idProposition'] ?? $_POST['idProposition'] ?? 5;
$idInternaute = $_GET['idInternaute'] ?? $_POST['idInternaute'] ?? 77;
$action = $_GET['action'] ?? $_POST['action'] ?? null;
$date_fin_vote = $_GET['date_fin_vote'] ?? $_POST['date_fin_vote'] ?? null;
$id_scrutin = $_GET['id_scrutin'] ?? $_POST['id_scrutin'] ?? null;
$choixs = $_GET['choix'] ?? $_POST['choix'] ?? null;


// Initialisation des objets
$api = new ApiClient();
$proposition = new Proposition($api, (int)$idProposition);

switch ($action) {
    case 'back':
        // Redirection vers la page précédente
        header("Location: controleurProposition.php?idProposition=" . urlencode($idProposition) . "&idInternaute=" . urlencode($idInternaute));
        exit;

    case 'organiserVote':
        $proposition->organiserVote( $date_fin_vote, $id_scrutin, $choixs);
        header("Location: controleurProposition.php?idProposition=" . urlencode($idProposition) . "&idInternaute=" . urlencode($idInternaute));
        exit;
}

$detailsProposition = $proposition->getPropositionDetails();

$typeScrutins = $proposition->getTypeScrutin();

// Inclusion des vues
if ($action == 'organiserVote1') {
    $choixCount = isset($_GET['choix_count']) ? intval($_GET['choix_count']) : 2;
    echo '<!DOCTYPE html>';
    echo '<html lang="fr">';
    echo '<head>';
    echo '    <meta charset="UTF-8">';
    echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '    <title>organiser vote</title>';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/general.css">';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/headerProposition.css">';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/organiserVote2.css">';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/footerProposition.css">';
    echo '</head>';
    echo '<body>';

    include '../../vue/proposition/headerProposition.php';
    include '../../vue/proposition/organiserVote2.php';
    include '../../vue/proposition/footerProposition.php';
}
else{
    echo '<!DOCTYPE html>';
    echo '<html lang="fr">';
    echo '<head>';
    echo '    <meta charset="UTF-8">';
    echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '    <title>organiser vote</title>';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/general.css">';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/headerProposition.css">';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/organiserVote1.css">';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/footerProposition.css">';
    echo '</head>';
    echo '<body>';

    include '../../vue/proposition/headerProposition.php';
    include '../../vue/proposition/organiserVote1.php';
    include '../../vue/proposition/footerProposition.php';
}
?>
