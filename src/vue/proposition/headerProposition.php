<header>
    <!-- Bouton Retour -->
    <div class="section-retour">
        <form action="../../controleur/proposition/<?= htmlspecialchars($page) ?>" method="GET">
            <input type="hidden" name="idProposition" value="<?= htmlspecialchars($idProposition) ?>">
            <input type="hidden" name="idInternaute" value="<?= htmlspecialchars($idInternaute) ?>">
            <input type="hidden" name="action" value="back">
            <button type="submit" class="bouton-retour">
                <span>&lt;</span>
            </button>
        </form>
    </div>
    
    <!-- Logo Institution -->
    <div class="section-institution">
        <img src="../../ressource/image/logo.png" alt="Institution">
    </div>
</header>
