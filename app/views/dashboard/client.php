<?php include 'app/views/layout/header.php'; ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#"><i class="bi bi-building-fill-check me-2"></i>UNION HÔTEL</a>
        <div class="d-flex align-items-center">
            <span class="text-white me-3 d-none d-md-inline">Bienvenue, <?= $_SESSION['user']['prenom'] ?></span>
            <a href="index.php?action=logout" class="btn btn-outline-danger btn-sm">Déconnexion</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <?php
    // Récupération des données 360° du client depuis la vue SQL
    $db = Database::getConnection();
    $stmt = $db->prepare("SELECT * FROM vue_fiche_client_globale WHERE id_client = ?");
    $stmt->execute([$_SESSION['user']['id_utilisateur']]);
    $client = $stmt->fetch();
    ?>

    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                        <i class="bi bi-person-circle text-primary" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="fw-bold"><?= $client['nom'] . ' ' . $client['prenom'] ?></h4>
                    <span class="badge rounded-pill bg-info text-dark mb-3"><?= $client['classification_client'] ?></span>
                    <p class="text-muted small mb-1"><i class="bi bi-telephone me-2"></i><?= $client['telephone'] ?></p>
                    <p class="text-muted small"><i class="bi bi-geo-alt me-2"></i><?= $client['nationalite'] ?></p>
                </div>
            </div>

            <?php if ($client['dette_actuelle_totale'] > 0): ?>
            <div class="alert alert-warning border-0 shadow-sm">
                <h6 class="alert-heading fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Solde à payer</h6>
                <p class="mb-0 fs-4 fw-bold text-danger"><?= number_format($client['dette_actuelle_totale'], 2) ?> $</p>
                <hr>
                <p class="small mb-0">Veuillez régulariser votre situation à la réception.</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-8">
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-4">
                    <div class="card text-center p-3 h-100">
                        <div class="text-primary mb-2"><i class="bi bi-calendar-check fs-3"></i></div>
                        <h5 class="fw-bold mb-0"><?= $client['nbr_total_reservations'] ?></h5>
                        <small class="text-muted">Séjours</small>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="card text-center p-3 h-100">
                        <div class="text-success mb-2"><i class="bi bi-cash-stack fs-3"></i></div>
                        <h5 class="fw-bold mb-0"><?= number_format($client['total_reellement_paye'], 2) ?> $</h5>
                        <small class="text-muted">Total Versé</small>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card text-center p-3 h-100">
                        <div class="text-info mb-2"><i class="bi bi-clock-history fs-3"></i></div>
                        <small class="text-muted d-block">Dernière visite</small>
                        <h6 class="fw-bold mb-0"><?= $client['date_derniere_visite'] ?? 'Aucune' ?></h6>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0"><i class="bi bi-list-stars me-2 text-primary"></i>Mes Réservations</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Service</th>
                                    <th>Début</th>
                                    <th>Fin</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt_res = $db->prepare("SELECT * FROM vue_mes_reservations WHERE id_client = ? ORDER BY date_debut DESC");
                                $stmt_res->execute([$_SESSION['user']['id_utilisateur']]);
                                while ($res = $stmt_res->fetch()):
                                ?>
                                <tr>
                                    <td><strong><?= $res['nom_service'] ?></strong></td>
                                    <td><?= date('d/m/Y', strtotime($res['date_debut'])) ?></td>
                                    <td><?= date('d/m/Y', strtotime($res['date_fin'])) ?></td>
                                    <td>
                                        <span class="badge bg-<?= ($res['statut_reservation'] == 'Confirmée') ? 'success' : 'secondary' ?>">
                                            <?= $res['statut_reservation'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary"><i class="bi bi-file-earmark-pdf"></i></button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>