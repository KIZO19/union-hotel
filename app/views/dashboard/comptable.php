<?php include 'app/views/layout/header.php'; ?>
<div class="container py-4">
    <h3>Journal de Comptabilité Globale</h3>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Date</th>
                                <th>Libellé</th>
                                <th>Débit</th>
                                <th>Crédit</th>
                                <th>Solde</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php 
$db = Database::getConnection();
$compta = $db->query("SELECT * FROM vue_grand_livre ORDER BY date_transaction ASC")->fetchAll();
$solde_cumule = 0; // On initialise le calcul
foreach($compta as $row): 
    // Calcul du solde : on ajoute le crédit (entrée) et on soustrait le débit (sortie)
    $solde_cumule += ($row['credit'] - $row['debit']);
?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($row['date_transaction'])) ?></td>
                                <td><?= $row['libelle'] ?></td>
                                <td class="text-danger">
                                    <?= $row['debit'] > 0 ? number_format($row['debit'], 2).' $' : '-' ?></td>
                                <td class="text-success">
                                    <?= $row['credit'] > 0 ? number_format($row['credit'], 2).' $' : '-' ?></td>
                                <td class="fw-bold <?= ($solde_cumule >= 0) ? 'text-dark' : 'text-danger' ?>">
                                    <?= number_format($solde_cumule, 2) ?> $
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/layout/footer.php'; ?>