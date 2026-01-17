<?php 
require_once 'app/views/layout/header.php'; 

$db = Database::getConnection();
$id = $_GET['id'] ?? 0;

// On récupère tout depuis la super vue globale
$stmt = $db->prepare("SELECT * FROM vue_globale_agents WHERE id_utilisateur = ?");
$stmt->execute([$id]);
$agent = $stmt->fetch();

if (!$agent) {
    header("Location: index.php?action=liste_agents");
    exit;
}
?>

<div class="d-flex">
    <?php require_once 'app/views/layout/sidebar.php'; ?>

    <main class="flex-grow-1 bg-light p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="index.php?action=liste_agents" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Retour à la liste
            </a>
            <div class="d-flex gap-2">
                <a href="index.php?action=print_card&id=<?= $agent['id_utilisateur'] ?>" target="_blank" class="btn btn-danger shadow-sm px-4">
                    <i class="bi bi-printer me-2"></i>Imprimer la Carte
                </a>
                <button class="btn btn-primary shadow-sm px-4">
                    <i class="bi bi-pencil-square me-2"></i>Modifier le profil
                </button>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm text-center p-4 rounded-4 mb-4">
                    <div class="mx-auto bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px; border: 4px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                        <span class="fs-1 fw-bold text-primary"><?= strtoupper(substr($agent['nom'], 0, 1)) ?></span>
                    </div>
                    <h3 class="fw-bold mb-1"><?= $agent['identite_complete'] ?></h3>
                    <p class="text-primary fw-semibold mb-3"><?= $agent['statut'] ?> (<?= $agent['niveau_acces'] ?>)</p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-light text-dark border rounded-pill px-3">
    <?= htmlspecialchars($agent['departement'] ?? 'Non assigné') ?>
</span>

<p class="fs-6 fw-semibold"><?= htmlspecialchars($agent['sexe'] ?? 'N/C') ?></p>
<p class="fs-6 fw-semibold">
    <?= !empty($agent['date_naissance']) ? date('d/m/Y', strtotime($agent['date_naissance'])) : 'Non renseignée' ?>
</p>
                        <span class="badge <?= $agent['statut_compte'] == 'Actif' ? 'bg-success' : 'bg-danger' ?> rounded-pill px-3">
                            <?= $agent['statut_compte'] ?>
                        </span>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted d-block">Mois en cours</small>
                            <span class="fw-bold fs-5 text-dark"><?= $agent['jours_travailles_mois'] ?>j</span>
                        </div>
                        <div class="col-6 border-start">
                            <small class="text-muted d-block">Taux Ponctualité</small>
                            <span class="fw-bold fs-5 <?= $agent['assiduite_pourcentage'] > 80 ? 'text-success' : 'text-warning' ?>">
                                <?= $agent['assiduite_pourcentage'] ?>%
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt me-2"></i>État du Jour</h6>
                    <div class="d-flex align-items-center p-3 rounded-3 <?= $agent['statut_actuel'] == 'Present' ? 'bg-success-subtle text-success' : 'bg-light text-muted' ?>">
                        <i class="bi <?= $agent['statut_actuel'] == 'Present' ? 'bi-check-circle-fill' : 'bi-clock' ?> fs-3 me-3"></i>
                        <div>
                            <div class="fw-bold"><?= $agent['statut_actuel'] == 'Present' ? 'Présent au poste' : 'Absent' ?></div>
                            <small><?= $agent['statut_actuel'] == 'Present' ? 'Arrivé à ' . $agent['arrivee_aujourdhui'] : 'Pas de scan enregistré' ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-dark">Informations Administratives</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="small text-muted text-uppercase fw-bold">Matricule</label>
                                <p class="fs-6 fw-semibold">#UH-<?= str_pad($agent['id_utilisateur'], 4, '0', STR_PAD_LEFT) ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted text-uppercase fw-bold">Sexe</label>
                                <p class="fs-6 fw-semibold"><?= $agent['sexe'] ?? 'Non précisé' ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted text-uppercase fw-bold">Email professionnel</label>
                                <p class="fs-6 fw-semibold"><?= $agent['email'] ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted text-uppercase fw-bold">Téléphone</label>
                                <p class="fs-6 fw-semibold"><?= $agent['telephone'] ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted text-uppercase fw-bold">Date de naissance</label>
                                <p class="fs-6 fw-semibold"><?= !empty($agent['date_naissance']) ? date('d/m/Y', strtotime($agent['date_naissance'])) : 'N/C' ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted text-uppercase fw-bold">Date d'embauche</label>
                                <p class="fs-6 fw-semibold"><?= date('d F Y', strtotime($agent['date_creation'])) ?></p>
                            </div>
                            <div class="col-12">
                                <label class="small text-muted text-uppercase fw-bold">Adresse résidentielle</label>
                                <p class="fs-6 fw-semibold mb-0"><?= $agent['adresse'] ?? 'Non renseignée' ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-dark">Assiduité ce mois</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold">Taux de présence globale</span>
                                <span class="fw-bold"><?= $agent['assiduite_pourcentage'] ?>%</span>
                            </div>
                            <div class="progress" style="height: 12px;">
                                <div class="progress-bar rounded-pill" role="progressbar" style="width: <?= $agent['assiduite_pourcentage'] ?>%"></div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3">
                                    <h2 class="fw-bold text-primary mb-0"><?= $agent['jours_travailles_mois'] ?></h2>
                                    <small class="text-muted">Jours travaillés</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3">
                                    <h2 class="fw-bold text-warning mb-0"><?= $agent['retards_mois'] ?></h2>
                                    <small class="text-muted">Retards enregistrés</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3">
                                    <h2 class="fw-bold text-danger mb-0"><?= 22 - $agent['jours_travailles_mois'] ?></h2>
                                    <small class="text-muted">Absences estimées</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once 'app/views/layout/footer.php'; ?>