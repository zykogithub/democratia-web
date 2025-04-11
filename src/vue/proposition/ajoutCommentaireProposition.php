<div class="ajouter-commentaire">
    <h2>Ajouter un commentaire</h2>
    <form action="../../controleur/proposition/<?= htmlspecialchars($page) ?>" method="GET">
        <input type="hidden" name="idProposition" value="<?= htmlspecialchars($idProposition) ?>">
        <input type="hidden" name="idInternaute" value="<?= htmlspecialchars($idInternaute) ?>">
        <input type="hidden" name="action" value="ajouter_commentaire">
        <textarea name="contenu_message" placeholder="Écrivez votre commentaire ici..." required></textarea>
        <button type="submit">Envoyer</button>
    </form>
</div>
