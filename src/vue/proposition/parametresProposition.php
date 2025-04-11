<main class="signalement">
    <div class="entete-signalement">
        <h1 class="titre-signalement">Signaler</h1>
        <p class="question-signalement">
            Pour quelle raison signalez-vous la proposition 
            "<span class="titre-proposition"><?= htmlspecialchars($detailsProposition['titre_proposition']) ?></span>" ?
        </p>
    </div>
    <div class="formulaire-signalement">
        <form action="../../controleur/proposition/<?= htmlspecialchars($page) ?>" method="GET">
            <input type="hidden" name="idProposition" value="<?= htmlspecialchars($idProposition) ?>">
            <input type="hidden" name="idInternaute" value="<?= htmlspecialchars($idInternaute) ?>">
            <input type="hidden" name="action" value="signaler">
            
            <textarea id="contenu_message" name="contenu_message" class="textarea-formulaire" 
                      placeholder="Écrivez ici votre raison du signalement..." required></textarea>
            
            <button type="submit" class="bouton-valider">Valider</button>
        </form>
    </div>
</main>
