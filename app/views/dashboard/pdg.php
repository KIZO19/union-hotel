<?php 
require_once 'app/views/layout/header.php'; 
$today = date('Y-m-d');
?>

<div class="wrapper d-flex">
    <?php require_once 'app/views/layout/sidebar.php'; ?>
    
    <main class="flex-grow-1 bg-light" style="min-height: 100vh;">
        <div class="p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0 text-dark">SYSTÈME DE MONITORING GLOBAL</h2>
                <span class="badge bg-white text-dark shadow-sm p-2 border">Date : <?php echo date('d/m/Y'); ?></span>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-4 border-primary">
                        <h6 class="text-muted small fw-bold text-uppercase mb-1">Présence Site</h6>
                        <h3 class="fw-bold mb-0" id="kpi-presents">--</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-4 border-danger">
                        <h6 class="text-muted small fw-bold text-uppercase mb-1">Retards / Alertes</h6>
                        <h3 class="fw-bold mb-0" id="kpi-alerts">--</h3>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white py-3 border-0">
                            <h5 class="fw-bold mb-0 text-dark">Mouvements du jour (Logs)</h5>
                        </div>
                        <div class="table-responsive px-3 pb-3">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr class="small text-muted text-uppercase">
                                        <th>Agent</th>
                                        <th>Arrivée</th>
                                        <th>Sortie</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody id="pdg-live-body">
                                    <tr><td colspan="4" class="text-center py-3">Chargement des données...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0 text-success">Personnel actuellement sur site</h5>
                            <span id="badge-total-site" class="badge bg-success py-2 px-3 rounded-pill">0 en ligne</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr class="small text-uppercase">
                                        <th>Agent</th>
                                        <th>Service</th>
                                        <th>Heure Entrée</th>
                                        <th>État</th>
                                    </tr>
                                </thead>
                                <tbody id="list-agents-presents">
                                    <tr><td colspan="4" class="text-center py-4 text-muted">Recherche des agents en poste...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white py-3 border-0">
                            <h5 class="fw-bold mb-0">Dernières Alertes</h5>
                        </div>
                        <div id="pdg-notif-list" class="card-body p-0" style="max-height: 600px; overflow-y: auto;">
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
function refreshMonitoring() {
    fetch('index.php?action=get_full_monitoring_data')
    .then(res => res.json())
    .then(data => {
        // 1. Mise à jour des KPI
        document.getElementById('kpi-presents').innerText = data.stats.presents || "0";
        document.getElementById('kpi-alerts').innerText = data.stats.total_alerts || "0";

        let fluxHtml = '';
        let siteHtml = '';
        let notifHtml = '';
        let countOnSite = 0;

        // 2. Traitement des Agents
        if (data.agents && data.agents.length > 0) {
            data.agents.forEach(a => {
                // Remplissage Logs Flux
                fluxHtml += `
                    <tr>
                        <td><strong>${a.nom} ${a.prenom}</strong></td>
                        <td>${a.heure_arrivee}</td>
                        <td>${a.heure_depart || '<span class="text-muted small">--:--</span>'}</td>
                        <td><span class="badge bg-${a.statut == 'Retard' ? 'danger' : 'success'}-subtle text-${a.statut == 'Retard' ? 'danger' : 'success'}">${a.statut}</span></td>
                    </tr>`;

                // Remplissage Agents sur site (si heure_depart est vide/nulle)
                if (!a.heure_depart || a.heure_depart === "00:00:00" || a.heure_depart === null) {
                    countOnSite++;
                    siteHtml += `
                        <tr>
                            <td><strong>${a.nom} ${a.prenom}</strong></td>
                            <td><span class="text-muted small">${a.departement || 'Hôtel'}</span></td>
                            <td class="text-primary fw-bold">${a.heure_arrivee}</td>
                            <td><span class="badge bg-success">En Poste</span></td>
                        </tr>`;
                }
            });
        }

        // 3. Traitement des Notifications
        if (data.notifications && data.notifications.length > 0) {
            data.notifications.forEach(n => {
                notifHtml += `
                    <div class="d-flex align-items-center p-3 border-bottom">
                        <div class="bg-${n.type_color || 'warning'}-subtle p-2 rounded-3 me-3">
                            <i class="bi bi-${n.icon || 'exclamation-circle'} text-${n.type_color || 'warning'}"></i>
                        </div>
                        <div>
                            <p class="mb-0 small fw-bold">${n.titre}</p>
                            <small class="text-muted">${n.message}</small>
                        </div>
                    </div>`;
            });
        } else {
            notifHtml = '<div class="p-4 text-center text-muted small">Aucune alerte critique aujourd\'hui</div>';
        }

        // 4. Injection Finale
        document.getElementById('pdg-live-body').innerHTML = fluxHtml || '<tr><td colspan="4" class="text-center py-3">Aucun mouvement aujourd\'hui</td></tr>';
        document.getElementById('list-agents-presents').innerHTML = siteHtml || '<tr><td colspan="4" class="text-center py-4">Aucun agent actuellement sur site</td></tr>';
        document.getElementById('pdg-notif-list').innerHTML = notifHtml;
        document.getElementById('badge-total-site').innerText = countOnSite + " en ligne";
    })
    .catch(err => {
        console.error("Erreur de rafraîchissement:", err);
    });
}

// Lancement automatique
refreshMonitoring();
setInterval(refreshMonitoring, 5000); // Mise à jour toutes les 5 secondes
</script>