<?php include 'app/views/layout/header.php'; ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Accueil & Réception</h2>
        <span class="badge bg-info text-dark">Agent: <?= $_SESSION['user']['nom'] ?></span>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold">Disponibilité des Chambres en Temps Réel</div>
                <div class="card-body">
                    <div class="row g-3">
                        <?php 
                        $db = Database::getConnection();
                        $chambres = $db->query("SELECT * FROM vue_etat_chambres")->fetchAll();
                        foreach($chambres as $c): ?>
                        <div class="col-md-2 col-6">
                            <div class="card text-center p-2 <?= ($c['statut'] == 'Libre') ? 'bg-light text-success border-success' : 'bg-warning text-dark border-warning' ?>">
                                <i class="bi bi-door-closed fs-3"></i>
                                <div class="fw-bold">Ch. <?= $c['numero_chambre'] ?></div>
                                <small><?= $c['statut'] ?></small>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/layout/footer.php'; ?>
