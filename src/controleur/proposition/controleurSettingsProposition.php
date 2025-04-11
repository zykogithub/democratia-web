<?php
// Inclusion des modèles
require_once '../../modele/propositionDetails.php';
require_once '../../../API/Api.php';

// Variables dynamiques
$page = "controleurSettingsProposition.php";
$idProposition = $_GET['idProposition'] ?? $_POST['idProposition'] ?? 5;
$idInternaute = $_GET['idInternaute'] ?? $_POST['idInternaute'] ?? 77;
$action = $_GET['action'] ?? $_POST['action'] ?? null;
$idCommentaire = $_GET['idCommentaire'] ?? $_POST['idCommentaire'] ?? null;
$contenu_message = $_GET['contenu_message'] ?? $_POST['contenu_message'] ?? '';

// Initialisation des objets
$api = new Api();
$proposition = new Proposition($api, (int)$idProposition);

switch ($action) {
    case 'back':
        // Redirection vers la page précédente
        header("Location: controleurProposition.php?idProposition=" . urlencode($idProposition) . "&idInternaute=" . urlencode($idInternaute));
        exit;

    case 'signaler':
        // Gestion du signalement
        $proposition->signalerProposition((int)$idInternaute, $contenu_message);
        header("Location: controleurProposition.php?idProposition=" . urlencode($idProposition) . "&idInternaute=" . urlencode($idInternaute));
        exit;
    
    case "signalerCom":
        $proposition->signalerCommentaire((int)$idCommentaire, $contenu_message, (int)$idInternaute);
        header("Location: controleurProposition.php?idProposition=" . urlencode($idProposition) . "&idInternaute=" . urlencode($idInternaute));
        exit;
}

// Inclusion des vues
if (is_null($idCommentaire)){
    $detailsProposition = $proposition->getPropositionDetails();
    echo '<!DOCTYPE html>';
    echo '<html lang="fr">';
    echo '<head>';
    echo '    <meta charset="UTF-8">';
    echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '    <title>signalement</title>';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/general.css">';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/headerProposition.css">';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/parametresProposition.css">';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/footerProposition.css">';
    echo '</head>';
    echo '<body>';

    include '../../vue/proposition/headerProposition.php';
    include '../../vue/proposition/parametresProposition.php';
    include '../../vue/proposition/footerProposition.php';
}
else {
    $detailCommentaire = $proposition->getCommentaire($idCommentaire);

    echo '<!DOCTYPE html>';
    echo '<html lang="fr">';
    echo '<head>';
    echo '    <meta charset="UTF-8">';
    echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '    <title>signalement</title>';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/general.css">';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/headerProposition.css">';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/signalerCommentaire.css">';
    echo '    <link rel="stylesheet" href="../../ressource/style/proposition/footerProposition.css">';
    echo '</head>';
    echo '<body>';

    include '../../vue/proposition/headerProposition.php';
    include '../../vue/proposition/signalerCommentaire.php';
    include '../../vue/proposition/footerProposition.php';
}
?>
