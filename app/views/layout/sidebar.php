<?php 
// 1. On s'assure que la session contient bien l'utilisateur pour éviter d'autres erreurs
$role = $_SESSION['user']['niveau_acces'] ?? '';

// 2. On définit la variable AVANT de l'utiliser plus bas
$isDirection = in_array($role, ['PDG', 'DG']);

// 3. Optionnel : On récupère l'action actuelle pour le style "active"
$currentAction = $_GET['action'] ?? 'dashboard';
?>


<div class="sidebar d-flex flex-column p-3 text-white bg-dark shadow">
    <div class="text-center mb-4">
        <i class="bi bi-building-fill-check fs-1 text-primary"></i>
        <h5 class="mt-2 fw-bold">UNION HÔTEL</h5>
        <hr>
    </div>
    
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="index.php?action=dashboard" class="nav-link text-white <?= (!isset($_GET['page'])) ? 'active bg-primary' : '' ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <?php if (in_array($role, ['PDG', 'DG', 'COMPTABLE'])): ?>
            <li class="mt-3 small text-uppercase text-muted fw-bold">Finance</li>
            <li><a href="#" class="nav-link text-white"><i class="bi bi-cash-stack me-2"></i> Trésorerie</a></li>
            <li><a href="#" class="nav-link text-white"><i class="bi bi-journal-text me-2"></i> Grand Livre</a></li>
        <?php endif; ?>

        <?php if (in_array($role, ['PDG', 'DRH'])): ?>
            <li class="mt-3 small text-uppercase text-muted fw-bold">Ressources Humaines</li>
            <li><a href="index.php?action=presence" class="nav-link text-white"><i class="bi bi-qr-code-scan me-2"></i> Scanner Présence</a></li>
            <?php if ($isDirection): ?>
        <li class="nav-item mb-2">
            <a class="nav-link text-white d-flex justify-content-between align-items-center" 
               data-bs-toggle="collapse" 
               href="#menuAgents" 
               role="button" 
               aria-expanded="<?= in_array($currentAction, ['utilisateurs', 'liste_agents']) ? 'true' : 'false' ?>">
                <span><i class="bi bi-people me-2"></i> Liste des Agents</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse <?= in_array($currentAction, ['utilisateurs', 'liste_agents']) ? 'show' : '' ?>" id="menuAgents">
                <ul class="nav nav-pills flex-column ps-3 mt-1 italic">
                    <li class="nav-item">
                        <a href="index.php?action=utilisateurs" class="nav-link text-white-50 small <?= $currentAction == 'utilisateurs' ? 'text-white fw-bold' : '' ?>">
                            <i class="bi bi-person-gear me-2"></i> Gestion Comptes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?action=liste_agents" class="nav-link text-white-50 small <?= $currentAction == 'liste_agents' ? 'text-white fw-bold' : '' ?>">
                            <i class="bi bi-person-badge me-2"></i> Cartes de Service
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <?php endif; ?>
        <?php endif; ?>
        <?php
// On définit une variable pour identifier la Haute Direction
$isDirection = in_array($_SESSION['user']['niveau_acces'], ['PDG', 'DG']);
?>

<?php if ($isDirection): ?>
    <li class="nav-item mb-2">
        <a href="index.php?action=finance" class="nav-link text-white">
            <i class="bi bi-bank me-2"></i> Rapports Financiers
        </a>
    </li>
    <li class="nav-item mb-2">
        <a href="index.php?action=utilisateurs" class="nav-link text-white">
            <i class="bi bi-shield-lock me-2"></i> Gestion Utilisateurs
        </a>
    </li>
<?php endif; ?>


        <?php if (in_array($role, ['PDG', 'RECEPTIONNISTE', 'DG'])): ?>
            <li class="mt-3 small text-uppercase text-muted fw-bold">Opérations</li>
            <li><a href="#" class="nav-link text-white"><i class="bi bi-calendar-event me-2"></i> Réservations</a></li>
            <li><a href="#" class="nav-link text-white"><i class="bi bi-door-open me-2"></i> Chambres</a></li>
        <?php endif; ?>

        <?php if ($role === 'CAISSIERE'): ?>
            <li class="mt-3 small text-uppercase text-muted fw-bold">Caisse</li>
            <li><a href="#" class="nav-link text-white"><i class="bi bi-receipt me-2"></i> Nouvelle Facture</a></li>
        <?php endif; ?>

        <?php if ($role === 'CLIENT'): ?>
            <li class="mt-3 small text-uppercase text-muted fw-bold">Mon Espace</li>
            <li><a href="#" class="nav-link text-white"><i class="bi bi-clock-history me-2"></i> Mes Séjours</a></li>
        <?php endif; ?>
    </ul>
    
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle me-2"></i>
            <strong><?= $_SESSION['user']['prenom'] ?></strong>
        </a>

        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li><a class="dropdown-item" href="index.php?action=profile" class="btn btn-outline-light btn-sm w-100 mb-2 py-2">
            <i class="bi bi-person-gear me-2"></i>Mon Profil
        </a></li>
            <li><a class="dropdown-item" href="index.php?action=logout">Déconnexion</a></li>

        </ul>
    </div>
</div>
