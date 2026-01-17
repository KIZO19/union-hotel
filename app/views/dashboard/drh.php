<?php include 'app/views/layout/header.php'; ?>
<div class="container py-4">
    <div class="row">
        <div class="col-md-12 mb-4 d-flex justify-content-between">
            <h2>Gestion du Personnel & Présences</h2>
            <button class="btn btn-primary" onclick="window.location.href='?action=presence'"><i class="bi bi-qr-code-scan"></i> Scanner Présence</button>
        </div>
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">Pointages du jour (<?= date('d/m/Y') ?>)</div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead><tr><th>Agent</th><th>Fonction</th><th>Entrée</th><th>Statut</th></tr></thead>
                        <tbody>
                            <?php 
                            $db = Database::getConnection();
                            $pres = $db->query("SELECT * FROM vue_presences_du_jour")->fetchAll();
                            foreach($pres as $p): ?>
                            <tr>
                                <td><?= $p['identite_complete'] ?></td>
                                <td><?= $p['fonction'] ?></td>
                                <td><?= $p['heure_entree'] ?></td>
                                <td><span class="badge bg-<?= ($p['statut_presence']=='Retard')?'warning':'success' ?>"><?= $p['statut_presence'] ?></span></td>
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
