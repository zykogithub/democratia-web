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

    <!-- Section Voter -->
    <div class="section-vote">
        <form action="../../controleur/proposition/<?= htmlspecialchars($page) ?>" method="GET">
            <input type="hidden" name="idProposition" value="<?= htmlspecialchars($idProposition) ?>">
            <input type="hidden" name="idInternaute" value="<?= htmlspecialchars($idInternaute) ?>">
            <button class="bouton-icone bouton-vote" name="action" value="voter">
                <?php if ($userHasVoted): ?>
                    <img src="../../ressource/image/proposition/voted-icon.png" alt="Déjà voté">
                <?php else: ?>
                    <img src="../../ressource/image/proposition/vote-icon.png" alt="Voter">
                <?php endif; ?>
            </button>
        </form>
        <p><?= htmlspecialchars($detailsProposition['nombre_demandes_vote']) ?></p>
    </div>

    <!-- Section Feedback -->
    <div class="section-retour-utilisateur">
        <!-- Bouton J'aime -->
        <form action="../../controleur/proposition/<?= htmlspecialchars($page) ?>" method="GET">
            <input type="hidden" name="idProposition" value="<?= htmlspecialchars($idProposition) ?>">
            <input type="hidden" name="idInternaute" value="<?= htmlspecialchars($idInternaute) ?>">
            <button class="bouton-icone bouton-jaime" name="action" value="like">
                <?php if ($userHasLiked): ?>
                    <img src="../../ressource/image/proposition/liked-icon.png" alt="Aimé">
                <?php else: ?>
                    <img src="../../ressource/image/proposition/like-icon.png" alt="J'aime">
                <?php endif; ?>
            </button>
        </form>
        <p><?= htmlspecialchars($detailsProposition['nombre_likes']) ?></p>

        <!-- Bouton Je n'aime pas -->
        <form action="../../controleur/proposition/<?= htmlspecialchars($page) ?>" method="GET">
            <input type="hidden" name="idProposition" value="<?= htmlspecialchars($idProposition) ?>">
            <input type="hidden" name="idInternaute" value="<?= htmlspecialchars($idInternaute) ?>">
            <button class="bouton-icone bouton-jaimepas" name="action" value="dislike">
                <?php if ($userHasDisliked): ?>
                    <img src="../../ressource/image/proposition/disliked-icon.png" alt="Pas aimé">
                <?php else: ?>
                    <img src="../../ressource/image/proposition/dislike-icon.png" alt="Je n'aime pas">
                <?php endif; ?>
            </button>
        </form>
        <p><?= htmlspecialchars($detailsProposition['nombre_dislikes']) ?></p>
    </div>
</header>
