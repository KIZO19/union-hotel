<?php include 'app/views/layout/header.php'; ?>

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-building-fill-check" style="font-size: 2.5rem;"></i>
                        </div>
                        <h3 class="fw-bold">UNION HÔTEL</h3>
                        <p class="text-muted small">Gestion Intégrée v1.0</p>
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div><?= $error ?></div>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="index.php?action=login">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Identifiant (Login)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                <input type="text" name="login" class="form-control" placeholder="Entrez votre login" required autofocus>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                        </button>
                    </form>
                </div>
            </div>
            <div class="text-center mt-4 text-muted small">
                &copy; 2026 Union Hôtel - Système de Gestion MVC
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>