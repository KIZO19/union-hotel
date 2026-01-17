<?php 
require_once 'app/views/layout/header.php'; 

$db = Database::getConnection();
// On récupère les données (le champ 'statut' représente ici la fonction/poste)
$agents = $db->query("SELECT * FROM vue_globale_agents ORDER BY identite_complete ASC")->fetchAll();
?>

<div class="d-flex">
    <?php require_once 'app/views/layout/sidebar.php'; ?>

    <main class="flex-grow-1 bg-light p-4" style="min-height: 100vh;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Gestion du Personnel</h2>
                <p class="text-muted">Liste détaillée des agents et de leurs fonctions au sein de l'Union Hôtel.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-white text-muted">
                        <tr style="font-size: 0.85rem; text-transform: uppercase;">
                            <th class="ps-4">Agent & Fonction</th> <th>Département</th>
                            <th>Niveau d'Accès</th>
                            <th>Statut Jour</th>
                            <th class="text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($agents as $a): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px; border-radius: 12px;">
                                        <?= strtoupper(substr($a['nom'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 1rem;"><?= $a['identite_complete'] ?></div>
                                        <div class="text-primary small fw-semibold">
                                            <i class="bi bi-briefcase me-1"></i><?= $a['statut'] ?? 'Poste non défini' ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted small fw-bold text-uppercase"><?= $a['departement'] ?></span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-3"><?= $a['niveau_acces'] ?></span>
                            </td>
                            <td>
                                <?php if($a['statut_actuel'] == 'Present'): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle py-2">
                                        En poste (<?= $a['arrivee_aujourdhui'] ?>)
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-light text-muted border py-2">Non pointé</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group">
                                    <a href="index.php?action=details_agent&id=<?= $a['id_utilisateur'] ?>" class="btn btn-sm btn-outline-primary border-0" title="Dossier">
                                        <i class="bi bi-eye-fill fs-5"></i>
                                    </a>
                                    <a href="index.php?action=print_card&id=<?= $a['id_utilisateur'] ?>" target="_blank" class="btn btn-sm btn-outline-danger border-0" title="Carte">
                                        <i class="bi bi-card-heading fs-5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php require_once 'app/views/layout/footer.php'; ?>