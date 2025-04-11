<div class="boutonOrganiserVote">
    <form action="../../controleur/proposition/controleurVoteProposition.php" method="GET">
        <input type="hidden" name="idProposition" value="<?= htmlspecialchars($idProposition) ?>">
        <input type="hidden" name="idInternaute" value="<?= htmlspecialchars($idInternaute) ?>">
        <button type="submit">Organiser le vote</button>
    </form>
</div>
