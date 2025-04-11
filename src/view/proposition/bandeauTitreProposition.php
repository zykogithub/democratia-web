<div class="barre-titre">
    <h1><?= htmlspecialchars($detailsProposition['titre_proposition']) ?></h1>
    <form action="../../controleur/proposition/controleurSettingsProposition.php" method="GET">
        <input type="hidden" name="idProposition" value="<?= htmlspecialchars($idProposition) ?>">
        <input type="hidden" name="idInternaute" value="<?= htmlspecialchars($idInternaute) ?>">
        <button type="submit" class="settings-icone">
            <img src="../../ressource/image/proposition/settings-icon.png" alt="Paramètres">
        </button>
    </form>
</div>

<div class="description">
    <p><?= htmlspecialchars($detailsProposition['description_proposition']) ?></p>
</div>
