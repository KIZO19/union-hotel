<?php include 'app/views/layout/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-secondary sidebar p-3 text-white" style="min-height:100vh;">
            <h4 class="text-center py-3">DIRECTION GÉNÉRALE</h4>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link text-white active" href="#"><i class="bi bi-eye me-2"></i> Supervision</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-door-open me-2"></i> État des Chambres</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-box-seam me-2"></i> Stocks</a></li>
            </ul>
        </nav>
        <main class="col-md-10 ms-sm-auto px-md-4 py-4">
            <h2>Supervision de l'Hôtel</h2>
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card shadow-sm p-3">
                        <h5 class="text-muted small uppercase">Taux d'occupation actuel</h5>
                        <div class="progress mt-2" style="height: 25px;">
                            <div class="progress-bar bg-success" style="width: 75%">75%</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm p-3">
                        <h5 class="text-muted small uppercase">Alertes Stocks (Produits Critiques)</h5>
                        <ul class="list-group list-group-flush">
                            <?php 
                            $db = Database::getConnection();
                            $stocks = $db->query("SELECT * FROM vue_alerte_stock")->fetchAll();
                            foreach($stocks as $s): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= $s['nom_produit'] ?>
                                <span class="badge bg-danger">Reste: <?= $s['quantite_actuelle'] ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php include 'app/views/layout/footer.php'; ?>
