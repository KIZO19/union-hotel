<?php
$db = Database::getConnection();
$id = $_GET['id'] ?? 0;

// On récupère les infos de l'agent
$stmt = $db->prepare("SELECT * FROM vue_globale_agents  WHERE id_utilisateur = ?");
$stmt->execute([$id]);
$agent = $stmt->fetch();

if (!$agent) {
    die("Erreur : Agent introuvable.");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carte de Service - <?= $agent['identite_complete'] ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
   <style>
    /* 1. FORCE L'IMPRESSION DES COULEURS (GLOBAL) */
    @media print {
        .no-print { display: none !important; }
        
        body { 
            -webkit-print-color-adjust: exact !important; 
            print-color-adjust: exact !important;
            background-color: white !important;
        }

        /* Supprime les en-têtes/pieds de page du navigateur (date, URL) */
        @page {
            margin: 0.5cm;
        }
    }

    /* 2. FORCE L'IMPRESSION SUR LES ELEMENTS SPECIFIQUES */
    .card-service, .header-blue, .footer-orange, .title-banner, .btn-print-card {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    body { background-color: #f0f2f5; font-family: 'Arial', sans-serif; }

    .print-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 30px;
        padding: 20px;
    }

    .card-service {
        width: 450px;
        height: 280px;
        background: white !important; /* Important pour l'impression */
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        border: 1px solid #ccc;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* --- RECTO --- */
    .header-blue {
        background: #1a4388 !important; 
        color: white !important;
        text-align: center;
        padding: 10px;
        height: 80px;
    }
    .header-blue h6 { margin: 0; font-size: 10px; text-transform: uppercase; }
    .header-blue h5 { margin: 2px 0; font-weight: bold; font-size: 14px; }
    
    .title-banner {
        background: white !important;
        color: #1a4388 !important;
        font-weight: 900;
        letter-spacing: 2px;
        font-size: 16px;
        margin-top: 5px;
        padding: 2px 0;
    }

    .body-card { display: flex; padding: 5px; position: relative; }
    
    .watermark {
        position: absolute;
        top: 50%; left: 50%; transform: translate(-50%, -50%);
        font-size: 40px; 
        color: rgba(0,0,0,0.05) !important; /* Légèrement plus foncé pour l'impression */
        font-weight: bold; z-index: 0; white-space: nowrap;
    }

    .photo-frame {
        width: 110px; height: 130px;
        border: 2px solid #555; border-radius: 8px;
        background: #eee !important; z-index: 1;
        display: flex; align-items: center; justify-content: center;
    }

    .info-table { margin-left: 15px; font-size: 12px; z-index: 1; flex-grow: 1; }
    .info-table td { padding: 1px 0; }
    .label { font-weight: bold; width: 80px; }

    .footer-orange {
        position: absolute; bottom: 0; width: 100%;
        height: 35px; 
        background: linear-gradient(to right, #1a4388 70%, #f39c12 30%) !important;
        color: white !important; 
        font-size: 10px; display: flex; align-items: center; padding-left: 10px;
    }

    /* --- VERSO --- */
    .verso-content {
        padding: 20px;
        text-align: center;
        font-size: 11px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
    }
    .qr-large { width: 100px; height: 100px; margin: 0 auto 10px; }
    .signature-area { margin-top: 20px; border-top: 1px dashed #000; display: inline-block; width: 150px; }

    /* Bouton d'impression */
    .btn-print-card {
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #1a4388 0%, #0d2d5e 100%) !important;
        color: white !important;
        border: none;
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(26, 67, 136, 0.3);
        cursor: pointer;
    }
</style>

<div class="print-container">
   <div class="no-print d-flex justify-content-center my-4">
    <button class="btn-print-card" onclick="window.print()">
        <span class="icon-wrapper">
            <i class="bi bi-printer-fill"></i>
        </span>
        <span class="text-wrapper">Imprimer la Carte Recto-Verso</span>
    </button>
</div>

    <div class="card-service">
    <div class="header-blue">
        <h6>République Démocratique du Congo</h6>
        <h5>UNION HÔTEL - GOMA</h5>
        <div class="title-banner">CARTE DE SERVICE</div>
    </div>

    <div class="body-card">
        <div class="watermark text-uppercase"><?= htmlspecialchars($agent['departement'] ?? 'UNION HOTEL') ?></div>
        
        <div class="photo-frame">
            <i class="bi bi-person-fill" style="font-size: 70px; color: #ccc;"></i>
        </div>

        <table class="info-table">
            <tr><td class="label">Nom</td><td>: <?= strtoupper($agent['nom']) ?></td></tr>
            <tr><td class="label">Postnom</td><td>: <?= strtoupper($agent['prenom']) ?></td></tr>
            <tr><td class="label">Prénom</td><td>: <?= $agent['prenom'] ?></td></tr>
            
            <tr>
                <td class="label">Fonction</td>
                <td class="fw-bold text-primary">: <?= strtoupper($agent['niveau_acces'] ?? 'AGENT') ?></td>
            </tr>
            
            <tr><td class="label">Matricule</td><td>: <?= str_pad($agent['id_utilisateur'], 5, '0', STR_PAD_LEFT) ?></td></tr>
            <tr><td class="label">Sexe</td><td>: <?= ($agent['sexe'] == 'M') ? 'MASCULIN' : 'FEMININ' ?></td></tr>
            <tr><td class="label">Naissance</td><td>: <?= !empty($agent['date_naissance']) ? date('d/m/Y', strtotime($agent['date_naissance'])) : 'N/C' ?></td></tr>
            <tr><td class="label">Adresse</td><td>: <?= substr($agent['adresse'] ?? 'GOMA', 0, 30) ?></td></tr>
        </table>
    </div>

    <div class="footer-orange">
        <div style="flex-grow: 1;">Délivré <?= date('j/m/Y') ?></div>
        <div style="padding-right: 15px; font-weight: bold; font-style: italic;">U.H.</div>
    </div>
</div>

    <div class="card-service">
        <div class="verso-content">
            <p>Cette carte est strictement personnelle. En cas de perte, prière de contacter la direction de l'Union Hôtel.</p>
            
            <div class="qr-large">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?= $agent['id_utilisateur'] ?>" alt="QR">
            </div>
            
            <p>Scannez ce code pour enregistrer votre présence.</p>
            
            <div class="d-flex justify-content-around mt-3">
                <div class="text-center">
                    <div class="signature-area"></div><br>
                    <span>Signature de l'agent</span>
                </div>
                <div class="text-center">
                    <div class="signature-area"></div><br>
                    <span>La Direction</span>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>