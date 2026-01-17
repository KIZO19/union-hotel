<?php include 'app/views/layout/header.php'; ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Guichet de Caisse</h2>
        <a href="index.php?action=logout" class="btn btn-outline-danger">Quitter</a>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card p-4 shadow-sm mb-4">
                <h5>Nouvelle Facture</h5>
                <form class="row g-3 mt-2">
                    <div class="col-md-6"><input type="text" class="form-control" placeholder="Nom Client"></div>
                    <div class="col-md-4"><input type="number" class="form-control" placeholder="Montant HT"></div>
                    <div class="col-md-2"><button type="submit" class="btn btn-primary w-100">Créer</button></div>
                </form>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Dernières Factures Émises</h6>
                    <table class="table table-sm">
                        <thead><tr><th>N° Facture</th><th>Montant TTC</th><th>Statut</th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light p-3 border-0 shadow-sm">
                <h6>Journal du Jour</h6>
                <?php 
                $db = Database::getConnection();
                $journal = $db->query("SELECT SUM(total_encaisse) as total FROM vue_journal_caisse WHERE date_jour = CURDATE()")->fetch();
                ?>
                <h2 class="text-primary"><?= number_format($journal['total'] ?? 0, 2) ?> $</h2>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/layout/footer.php'; ?>
