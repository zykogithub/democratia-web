<div class="conteneur-discussion">
    <?php if (!empty($commentaires)): ?>
        <?php foreach ($commentaires as $commentaire): ?>
            <div class="message-discussion <?= ($commentaire['id_internaute'] == $idInternaute) ? 'Moi' : 'Autre'; ?>">
                <div class="meta-discussion">
                    <span class="auteur-discussion">
                        <?= ($commentaire['id_internaute'] == $idInternaute) ? 'Moi' : htmlspecialchars($commentaire['nom_internaute'] ?? 'Anonyme') ?>
                    </span>
                    <span class="date-discussion">
                        <?= htmlspecialchars($commentaire['horodatage']) ?>
                    </span>
                </div>
                <div class="contenu-discussion">
                    <?= htmlspecialchars($commentaire['contenu_message']) ?>
                </div>
                <!-- Ajout du bouton pour signaler si ce n'est pas le propriétaire -->
                <?php if ($commentaire['id_internaute'] != $idInternaute): ?>
                    <div class="actions-commentaire">
                        <form action="../../controleur/proposition/controleurSettingsProposition.php" method="GET">
                            <input type="hidden" name="idProposition" value="<?= htmlspecialchars($idProposition) ?>">
                            <input type="hidden" name="idInternaute" value="<?= htmlspecialchars($idInternaute) ?>">
                            <input type="hidden" name="idCommentaire" value="<?= $commentaire['id_commentaire'] ?>">
                            <button type="submit" class="btn-signalement">Signaler</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="aucun-commentaire">Aucun commentaire disponible.</p>
    <?php endif; ?>
</div>
