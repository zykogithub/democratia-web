<div class="vote-form">
    <?php if (empty($choices)): ?>
        <p>En attente du vote.</p>
    <?php else: ?>
        <?php if (!$verifVote): ?>
            <h2>Veuillez sélectionner la réponse de votre choix :</h2>
            <form action="../../controleur/proposition/controleurProposition.php" method="GET">
                <!-- Champ caché pour les métadonnées -->
                <input type="hidden" name="idProposition" value="<?= htmlspecialchars($idProposition) ?>">
                <input type="hidden" name="idInternaute" value="<?= htmlspecialchars($idInternaute) ?>">
                <input type="hidden" name="action" value="vote">
                
                <!-- Options de vote -->
                <?php foreach ($choices as $choice): ?>
                    <label>
                        <input type="radio" name="selected_choice" value="<?= htmlspecialchars($choice['id_choix']) ?>" required>
                        <?= htmlspecialchars($choice['libelle_choix']) ?>
                    </label><br>
                <?php endforeach; ?>
                
                <!-- Bouton de validation -->
                <button type="submit">Valider le choix</button>
            </form>
        <?php else: ?>
            <p>Vous avez déjà voté.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>
