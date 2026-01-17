<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Union Hôtel Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --sidebar-width: 260px; }
        
        body { display: flex; min-height: 100vh; margin: 0; background-color: #f4f7f6; overflow-x: hidden; }

        /* Sidebar Responsive */
        .sidebar { 
            width: var(--sidebar-width); 
            min-width: var(--sidebar-width); 
            height: 100vh; 
            position: sticky; 
            top: 0; 
            background: #1a1d20; 
            color: white; 
            transition: all 0.3s;
            z-index: 1050;
        }
@media (max-width: 768px) {
    .sidebar {
        width: 100% !important;
        min-height: auto !important;
        position: relative;
    }
    
    /* On transforme la sidebar en menu horizontal sur mobile si besoin */
    .sidebar .nav-item {
        text-align: center;
    }
}

/* Conteneur principal pour éviter que le contenu ne passe sous la sidebar */
.main-content {
    flex-grow: 1;
    padding: 20px;
    transition: all 0.3s;
}      
        .content-area { flex-grow: 1; display: flex; flex-direction: column; min-width: 0; transition: all 0.3s; }

        /* Top Header */
        .top-header {
            background:rgb(71, 122, 233); /* Fond blanc pour contraster avec le sidebar noir */
            border-bottom: 1px solid #e0e0e0;
            padding: 10px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* Ajustements Mobile */
        @media (max-width: 992px) {
            .sidebar { position: fixed; left: -260px; }
            .sidebar.active { left: 0; }
            .content-area { width: 100%; }
        }

        .main-container { padding: 20px; flex-grow: 1; }
        
        /* Styles Notifications */
        .line-height-1 { line-height: 1.2; }
        #notifBtn:hover i { animation: bell-ring 0.5s ease-in-out; }
        @keyframes bell-ring {
            0% { transform: rotate(0); }
            20% { transform: rotate(15deg); }
            40% { transform: rotate(-15deg); }
            100% { transform: rotate(0); }
        }
        /* Animation du chevron dans la sidebar */
[aria-expanded="true"] .bi-chevron-down {
    transform: rotate(180deg);
    transition: 0.3s;
}

.nav-link .bi-chevron-down {
    transition: 0.3s;
}

/* Style spécifique pour les sous-menus */
.nav-white-50:hover {
    color: white !important;
}
/* On cible la classe sidebar que vous avez définie dans votre div */
.sidebar {
    width: 280px;
    /* Fixe la hauteur à 100% de la fenêtre */
    height: 100vh; 
    /* Permet à la sidebar de rester fixe pendant que le contenu défile */
    position: sticky;
    top: 0;
    left: 0;
    /* Si le contenu de la sidebar elle-même est trop long, on permet le scroll interne */
    overflow-y: auto;
    /* Assure que la sidebar est au-dessus du contenu si nécessaire */
    z-index: 1000;
}

/* Ajustement pour le conteneur parent (dans vos pages PHP) */
.d-flex {
    display: flex;
    align-items: stretch;
}
    </style>
</head>
<body>

<?php if (isset($_SESSION['user'])): ?>
    <?php include 'app/views/layout/sidebar.php'; ?>
<?php endif; ?>

<div class="content-area">
    <?php if (isset($_SESSION['user'])): ?>
    <header class="top-header">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-light d-lg-none shadow-sm" id="sidebarCollapse">
                <i class="bi bi-list fs-4"></i>
            </button>
            <h6 class="mb-0 fw-bold text-primary d-none d-sm-block">UNION HÔTEL</h6>
        </div>
        

        <div class="d-flex align-items-center gap-3">
            <div class="dropdown">
                <button class="btn btn-light position-relative rounded-circle shadow-sm" type="button" id="notifBtn" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell-fill text-secondary"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">3</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="width: 280px;">
                    <li class="p-2 border-bottom text-center small fw-bold">Notifications</li>
                    <li><a class="dropdown-item small p-2 border-bottom" href="#">Dépense à valider (250$)</a></li>
                    <li><a class="dropdown-item small p-2 border-bottom" href="#">Check-out : Chambre 104</a></li>
                    <li><a class="dropdown-item text-center small text-primary py-2" href="#">Voir tout</a></li>
                </ul>
            </div>

            <div class="vr mx-2 text-muted opacity-25" style="height: 25px;"></div>

            <div class="user-identity text-end">
                <div class="fw-bold text-dark small line-height-1">
                    Bienvenue, <?= $_SESSION['user']['nom'] ?> <span class="d-none d-md-inline"><?= $_SESSION['user']['postnom'].$_SESSION['user']['prenom'] ?></span>
                    <span class="badge bg-light text-dark border p-1" style="font-size: 0.6rem;"><?= $_SESSION['user']['niveau_acces']?></span>
                     
                </div>
                <div class="d-flex align-items-center justify-content-end gap-1">
                   
            <a href="index.php?action=logout" class="btn btn-outline-danger btn-sm">Déconnexion</a>
                </div>
            </div>
        </div>
    </header>
    <?php endif; ?>

    <div class="main-container">