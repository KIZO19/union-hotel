<?php 
// 1. Sécurité et variables de contrôle
$role = $_SESSION['user']['niveau_acces'] ?? '';
$prenom = $_SESSION['user']['prenom'] ?? 'Agent';
$isDirection = in_array($role, ['PDG', 'DG']);
$currentAction = $_GET['action'] ?? 'dashboard';
?>

<div class="sidebar d-flex flex-column p-3 text-white bg-dark shadow" style="min-height: 100vh; width: 280px;">
    <div class="text-center mb-4">
        <i class="bi bi-building-fill-check fs-1 text-primary"></i>
        <h5 class="mt-2 fw-bold">UNION HÔTEL</h5>
        <hr class="text-secondary">
    </div>
    
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="index.php?action=dashboard" class="nav-link text-white <?= ($currentAction == 'dashboard') ? 'active bg-primary' : '' ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <?php if (in_array($role, ['PDG', 'DG', 'COMPTABLE'])): ?>
            <li class="mt-3 small text-uppercase text-muted fw-bold">Finance</li>
            <li>
                <a href="index.php?action=finance" class="nav-link text-white <?= ($currentAction == 'finance') ? 'active bg-primary' : '' ?>">
                    <i class="bi bi-cash-stack me-2"></i> Trésorerie
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-journal-text me-2"></i> Grand Livre
                </a>
            </li>
        <?php endif; ?>

        <?php if (in_array($role, ['PDG', 'DG', 'DRH'])): ?>
            <li class="mt-3 small text-uppercase text-muted fw-bold">Ressources Humaines</li>
            <li>
                <a href="index.php?action=presence" class="nav-link text-white <?= ($currentAction == 'presence') ? 'active bg-primary' : '' ?>">
                    <i class="bi bi-qr-code-scan me-2"></i> Scanner Présence
                </a>
            </li>
            
            <?php if ($isDirection): ?>
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center" 
                   data-bs-toggle="collapse" href="#menuAgents" role="button">
                    <span><i class="bi bi-people me-2"></i> Gestion RH</span>
                    <i class="bi bi-chevron-down small"></i>
                </a>
                <div class="collapse <?= in_array($currentAction, ['utilisateurs', 'liste_agents']) ? 'show' : '' ?>" id="menuAgents">
                    <ul class="nav nav-pills flex-column ps-3 mt-1">
                        <li>
                            <a href="index.php?action=utilisateurs" class="nav-link text-white-50 small <?= $currentAction == 'utilisateurs' ? 'text-white fw-bold' : '' ?>">
                                <i class="bi bi-person-gear me-2"></i> Comptes Utilisateurs
                            </a>
                        </li>
                        <li>
                            <a href="index.php?action=liste_agents" class="nav-link text-white-50 small <?= $currentAction == 'liste_agents' ? 'text-white fw-bold' : '' ?>">
                                <i class="bi bi-person-badge me-2"></i> Cartes de Service
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (in_array($role, ['PDG', 'DG', 'RECEPTIONNISTE'])): ?>
            <li class="mt-3 small text-uppercase text-muted fw-bold">Opérations</li>
            <li><a href="#" class="nav-link text-white"><i class="bi bi-calendar-event me-2"></i> Réservations</a></li>
            <li><a href="#" class="nav-link text-white"><i class="bi bi-door-open me-2"></i> Chambres</a></li>
        <?php endif; ?>

        <?php if ($role === 'CAISSIERE'): ?>
            <li class="mt-3 small text-uppercase text-muted fw-bold">Caisse</li>
            <li><a href="#" class="nav-link text-white"><i class="bi bi-receipt me-2"></i> Nouvelle Facture</a></li>
        <?php endif; ?>
    </ul>
    
    <hr class="text-secondary">
    
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle me-2 fs-4"></i>
            <strong><?= htmlspecialchars($prenom) ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li>
                <a class="dropdown-item <?= ($currentAction == 'profile') ? 'active' : '' ?>" href="index.php?action=profile">
                    <i class="bi bi-person-badge me-2"></i> Mon Profil
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item text-danger" href="index.php?action=logout">
                    <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                </a>
            </li>
        </ul>
    </div>
</div>