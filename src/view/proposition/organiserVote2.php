<main>
    <!-- Choix dynamiques -->
    <div id="choix-container">
        <form action="" method="GET">
            <!-- Champs cachés pour les métadonnées -->
            <input type="hidden" name="id_scrutin" value="<?= htmlspecialchars($id_scrutin) ?>">
            <input type="hidden" name="idProposition" value="<?= htmlspecialchars($idProposition) ?>">
            <input type="hidden" name="idInternaute" value="<?= htmlspecialchars($idInternaute) ?>">
            <input type="hidden" name="date_fin_vote" value="<?= htmlspecialchars($date_fin_vote) ?>">
            <input type="hidden" name="action" value="organiserVote">

            <?php
            // Définir le nombre de choix en fonction du type de scrutin
            $choixCount = ($id_scrutin == 1) ? 2 : 10;

            // Générer les champs dynamiquement
            for ($i = 1; $i <= $choixCount; $i++): ?>
                <label for="choix_<?= $i ?>">Choix <?= $i ?> :</label>
                <input 
                    type="text" 
                    id="choix_<?= $i ?>" 
                    name="choix[]" 
                    placeholder="Entrez un choix" 
                    <?= ($i <= 2) ? 'required' : '' // Les deux premiers choix sont obligatoires ?>
                >
            <?php endfor; ?>

            <!-- Bouton de soumission -->
            <button type="submit">Valider</button>
        </form>
    </div>
</main>
