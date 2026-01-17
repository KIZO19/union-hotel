<?php
// On récupère les infos de l'utilisateur depuis la session
$user = $_SESSION['user'];
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Mon Profil Agent</h4>
                </div>
                <div class="card-body text-center">
                    <img src="public/images/avatars/default.png" class="rounded-circle mb-3" style="width: 120px;">
                    
                    <h3><?php echo $user['nom'] . ' ' . $user['prenom']; ?></h3>
                    <p class="text-muted"><?php echo $user['niveau_acces']; ?></p>
                    <hr>
                    
                    <ul class="list-group list-group-flush text-start">
                        <li class="list-group-item"><strong>Email :</strong> <?php echo $user['email'] ?? 'Non renseigné'; ?></li>
                        <li class="list-group-item"><strong>ID Agent :</strong> #<?php echo $user['id_utilisateur']; ?></li>
                        <li class="list-group-item"><strong>Statut :</strong> <span class="badge bg-success">Actif</span></li>
                    </ul>

                    <div class="mt-4">
                        <a href="index.php?action=dashboard" class="btn btn-outline-secondary">Retour</a>
                        <button class="btn btn-primary">Modifier mes infos</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>