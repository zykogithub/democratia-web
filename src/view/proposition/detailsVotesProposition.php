<div class="vote-summary">
    <div class="header">
        <h2>Résumé des Votes</h2>
    </div>
    <div class="content">
        <p><strong>Budget :</strong> <?= htmlspecialchars($detailsvotes[0]['budget'] ?? 'N/A') ?> €</p>
        <p><strong>Type de scrutin :</strong> <?= htmlspecialchars($detailsvotes[0]['nom_type'] ?? 'N/A') ?></p>
        <p><strong>Date de fin des votes :</strong> <?= htmlspecialchars($detailsvotes[0]['date_fin_vote'] ?? 'N/A') ?></p>
    </div>
    <div class="statistics">
        <h3>Statistiques des Votes</h3>
        <p><strong>Total de votes :</strong> <?= htmlspecialchars($totalVotes ?? 0) ?></p>
        <?php 
        $labels = [];
        $data = [];
        if (!empty($choixStatistiques)) {
            foreach ($choixStatistiques as $choix => $nombre): 
                $pourcentage = round(($nombre / ($totalVotes ?: 1)) * 100, 2); // Éviter division par zéro
                $labels[] = htmlspecialchars($choix);
                $data[] = $nombre;
        ?>
                <p><strong><?= htmlspecialchars($choix) ?> :</strong> <?= $nombre ?> votes (<?= $pourcentage ?>%)</p>
        <?php 
            endforeach;
        }
        ?>
    </div>
    <div class="chart-container">
        <canvas id="voteChart" aria-label="Graphique des votes" role="img"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('voteChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Votes',
                data: <?= json_encode($data) ?>,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw;
                            const total = <?= $totalVotes ?>;
                            const percentage = ((value / total) * 100).toFixed(2);
                            return `${label}: ${value} votes (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
</script>
