<main>
<div class="form-organiser-vote">
    <h2>Organiser un vote pour la proposition</h2>
    <form action="" method="GET">
        <!-- Identifiant de l'utilisateur -->
        <input type="hidden" name="idInternaute" value="<?= htmlspecialchars($idInternaute) ?>">
        <input type="hidden" name="idProposition" value="<?= htmlspecialchars($idProposition) ?>">
        <input type="hidden" name="action" value="organiserVote1">

        <!-- Date de fin du vote -->
        <div>
            <label for="date_fin_vote">Date de fin du vote :</label>
            <input type="date" id="date_fin_vote" name="date_fin_vote" required>
        </div>

        <!-- Type de scrutin (boutons radio) -->
        <div>
            <label for="type_scrutin">Type de scrutin :</label>
            <div id="type_scrutin">
                <?php foreach ($typeScrutins as $type): ?>
                    <div>
                        <input 
                            type="radio" 
                            id="scrutin_<?= htmlspecialchars($type['id_scrutin']) ?>" 
                            name="id_scrutin" 
                            value="<?= htmlspecialchars($type['id_scrutin']) ?>" 
                            required
                        >
                        <label for="scrutin_<?= htmlspecialchars($type['id_scrutin']) ?>">
                            <?= htmlspecialchars($type['nom_type']) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Bouton de soumission -->
        <button type="submit">suivant</button>
    </form>
</div>

</main>