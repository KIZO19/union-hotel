<?php
session_start();
// if (!isset($_SESSION['user']) && $action !== 'login') {
//     header('Location: index.php?action=login');
//     exit();
// }
require_once 'config/db.php';

$action = $_GET['action'] ?? 'login';

// Protection : Si pas connecté, on force le login (sauf si on y est déjà)
if (!isset($_SESSION['user']) && $action !== 'login') {
    header('Location: index.php?action=login');
    exit();
}

switch ($action) {
    case 'login':
        require_once 'app/controllers/AuthController.php';
        (new AuthController())->login();
        break;
        case 'profile':
    require_once 'app/views/user/profile.php'; // On créera cette page plus tard
    break;
    // Route pour afficher les détails d'un agent
case 'details_agent':
    // Vérification de sécurité : seuls les hauts gradés accèdent aux dossiers RH
    if (isset($_SESSION['user']) && in_array($_SESSION['user']['niveau_acces'], ['PDG', 'DG'])) {
        require_once 'app/views/direction/details_agent.php';
    } else {
        // Redirection si l'utilisateur n'a pas les droits
        header('Location: index.php?action=dashboard&error=access_denied');
    }
    break;
    case 'presence':
    // Vérifiez que ce fichier existe bien dans ce dossier précis
    require_once 'app/views/direction/presence.php'; 
    break;
    case 'print_card':
    // Seul le PDG ou le DG peut imprimer
    if (isset($_SESSION['user']) && in_array($_SESSION['user']['niveau_acces'], ['PDG', 'DG'])) {
        require_once 'app/views/direction/print_card.php';
    } else {
        header('Location: index.php?action=dashboard');
    }
    break;
    
    // Dans votre switch(action)
case 'enregistrer_pointage':
    header('Content-Type: application/json');
    $id_agent = $_POST['id_utilisateur'] ?? null;
    $today = date('Y-m-d');
    $now = date('H:i:s');

    if ($id_agent) {
        $db = Database::getConnection();

        // 1. Vérifier si l'agent existe dans la table utilisateurs
        $stmt = $db->prepare("SELECT nom, prenom FROM utilisateurs WHERE id_utilisateur = ?");
        $stmt->execute([$id_agent]);
        $agent = $stmt->fetch();

        if ($agent) {
            // 2. Vérifier s'il y a déjà un enregistrement pour cet agent aujourd'hui
            $check = $db->prepare("SELECT id_presence, heure_arrivee, heure_depart FROM presences WHERE id_utilisateur = ? AND date_pointage = ?");
            $check->execute([$id_agent, $today]);
            $presence = $check->fetch();

            if (!$presence) {
                // --- CAS A : PREMIER SCAN DU JOUR (ENTRÉE) ---
                // On insère une nouvelle ligne avec l'heure d'arrivée
                $ins = $db->prepare("INSERT INTO presences (id_utilisateur, date_pointage, heure_arrivee, statut) VALUES (?, ?, ?, 'Present')");
                $ins->execute([$id_agent, $today, $now]);
                
                echo json_encode([
                    'success' => true, 
                    'message' => 'ENTRÉE ENREGISTRÉE', 
                    'type' => 'entree',
                    'agent' => $agent['nom'] . ' ' . $agent['prenom'],
                    'heure' => $now
                ]);

            } elseif ($presence['heure_depart'] == NULL || $presence['heure_depart'] == '00:00:00') {
                // --- CAS B : DEUXIÈME SCAN DU JOUR (SORTIE) ---
                // On met à jour la ligne existante en remplissant l'heure de départ
                $upd = $db->prepare("UPDATE presences SET heure_depart = ? WHERE id_presence = ?");
                $upd->execute([$now, $presence['id_presence']]);
                
                echo json_encode([
                    'success' => true, 
                    'message' => 'SORTIE ENREGISTRÉE', 
                    'type' => 'sortie',
                    'agent' => $agent['nom'] . ' ' . $agent['prenom'],
                    'heure' => $now
                ]);

            } else {
                // --- CAS C : SCAN SUPPLÉMENTAIRE ---
                // L'agent a déjà pointé son entrée ET sa sortie aujourd'hui
                echo json_encode([
                    'success' => false, 
                    'message' => 'Service déjà terminé pour aujourd\'hui', 
                    'agent' => $agent['nom'] . ' ' . $agent['prenom']
                ]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Code QR non reconnu', 'agent' => '-']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur de lecture du code', 'agent' => '-']);
    }
    exit;
    case 'get_full_monitoring_data':
    header('Content-Type: application/json');
    $db = Database::getConnection();
    
    // On fixe la date sur la date système actuelle
    $today = date('Y-m-d'); 

    // Requête pour les agents présents AUJOURD'HUI
    $agents_stmt = $db->prepare("
        SELECT p.*, u.nom, u.prenom, d.nom_departement as departement 
        FROM presences p 
        JOIN utilisateurs u ON p.id_utilisateur = u.id_utilisateur 
        LEFT JOIN departements d ON u.id_departement = d.id_departement
        WHERE p.date_pointage = ? 
        ORDER BY p.heure_arrivee DESC
    ");
    $agents_stmt->execute([$today]);
    $agents = $agents_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calcul des KPI basés sur la date système
    $total_agents = $db->query("SELECT COUNT(*) FROM utilisateurs WHERE role != 'PDG'")->fetchColumn();
    $presents = count($agents);
    $retards = 0;
    foreach($agents as $a) { if($a['statut'] == 'Retard') $retards++; }

    echo json_encode([
        'stats' => [
            'presents' => $presents . '/' . $total_agents,
            'total_alerts' => $retards,
            'taux_ponct' => ($presents > 0) ? round((($presents - $retards) / $presents) * 100) : 100
        ],
        'agents' => $agents
    ]);
    exit;
case 'liste_agents':
    // Vérification de sécurité pour DG et PDG
    if (isset($_SESSION['user']) && in_array($_SESSION['user']['niveau_acces'], ['PDG', 'DG'])) {
        require_once 'app/views/direction/liste_agents.php';
    } else {
        // Rediriger si l'utilisateur n'a pas le droit
        header('Location: index.php?action=dashboard');
    }
    break;

    case 'dashboard':
        // 1. On récupère le niveau d'accès (ex: PDG, DG, CLIENT)
        $role_brut = $_SESSION['user']['niveau_acces']; 
        
        // 2. On convertit en minuscules pour correspondre au nom du fichier
        $role_clean = strtolower($role_brut); 
        
        // 3. Chemin vers le fichier spécifique
        $file_path = "app/views/dashboard/" . $role_clean . ".php";

        // 4. Vérification si le fichier existe avant de l'inclure
        if (file_exists($file_path)) {
            require_once $file_path;
        } else {
            echo "Erreur : Le dashboard pour le rôle [ $role_brut ] n'a pas encore été créé dans $file_path";
        }
        break;

    // Dans index.php, la section logout doit être :
case 'logout':
    $_SESSION = array(); // Vide toutes les variables de session
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy(); // Détruit la session sur le serveur
    header('Location: index.php?action=login');
    exit();
}