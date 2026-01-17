<style>
    .id-card-container {
        width: 350px;
        height: 220px;
        background: white;
        border-radius: 15px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: 1px solid #ddd;
        font-family: 'Segoe UI', sans-serif;
    }

    .card-header-stripe {
        height: 15px;
        background: #0d6efd; /* Bleu Union Hôtel */
    }

    .card-body {
        display: flex;
        padding: 15px;
    }

    .photo-zone {
        width: 100px;
        height: 120px;
        background: #f0f0f0;
        border: 2px solid #0d6efd;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-zone {
        flex-grow: 1;
        padding-left: 15px;
    }

    .hotel-name {
        font-size: 14px;
        font-weight: bold;
        color: #1a1d20;
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    .agent-name {
        font-size: 18px;
        font-weight: 800;
        color: #000;
        margin-bottom: 2px;
    }

    .agent-role {
        font-size: 12px;
        color: #0d6efd;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .qr-zone {
        position: absolute;
        bottom: 15px;
        right: 15px;
        width: 60px;
        height: 60px;
        background: white;
        padding: 5px;
        border: 1px solid #eee;
    }

    .footer-text {
        position: absolute;
        bottom: 15px;
        left: 15px;
        font-size: 10px;
        color: #888;
    }
</style>

<div class="id-card-container">
    <div class="card-header-stripe"></div>
    <div class="card-body">
        <div class="photo-zone">
            <i class="bi bi-person-fill text-muted" style="font-size: 50px;"></i>
        </div>
        <div class="info-zone">
            <div class="hotel-name">Union Hôtel Pro</div>
            <div class="agent-name"><?= $agent['nom'] ?> <?= $agent['prenom'] ?></div>
            <div class="agent-role"><?= $agent['niveau_acces'] ?></div>
            <div class="small text-muted">Dépt: <strong><?= $agent['departement'] ?></strong></div>
        </div>
    </div>
    <div class="footer-text">
        Matricule: #UH-<?= str_pad($agent['id_utilisateur'], 4, '0', STR_PAD_LEFT) ?><br>
        Délivré par: Direction Générale
    </div>
    <div class="qr-zone">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= $agent['id_utilisateur'] ?>" width="50">
    </div>
</div>