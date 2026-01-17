<?php require_once 'app/views/layout/header.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 ?>

<div class="wrapper d-flex">
    <?php require_once 'app/views/layout/sidebar.php'; ?>

    <main class="flex-grow-1 bg-light">
        <div class="p-4">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <div class="mb-4">
        <button onclick="window.location.reload()" class="btn btn-primary btn-lg rounded-pill shadow-sm px-4">
            <i class="bi bi-qr-code-scan me-2"></i>Nouveau Scan
        </button>
    </div>
                        <h3 class="fw-bold text-primary mb-3">
                            <i class="bi bi-qr-code-scan me-2"></i>Pointage Présence
                        </h3>
                        <p class="text-muted">Présentez le QR Code de l'agent devant la caméra</p>

                        <div id="reader" class="mx-auto border-4 border-primary rounded-4 shadow-sm" style="max-width: 500px; overflow: hidden;"></div>

                        <div id="result-message" class="mt-4 p-3 rounded-3 d-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Stopper le scanner temporairement pour traiter
        html5QrcodeScanner.clear();
        
        // Envoyer l'ID de l'agent au serveur via AJAX
        fetch('index.php?action=enregistrer_pointage', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'id_utilisateur=' + decodedText
})
.then(response => response.text()) // On récupère d'abord du texte pour débugger
.then(text => {
    try {
        const data = JSON.parse(text); // On essaie de convertir en JSON
        const resDiv = document.getElementById('result-message');
        resDiv.classList.remove('d-none', 'alert-success', 'alert-danger');
        resDiv.classList.add(data.success ? 'alert-success' : 'alert-danger');
        resDiv.innerHTML = `<h5>${data.message}</h5> <strong>Agent:</strong> ${data.agent}`;
    } catch (e) {
        console.error("Erreur de réponse du serveur (pas du JSON) :", text);
        alert("Erreur serveur : Le PHP a renvoyé un message invalide.");
    }
});
    }

    let html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
</script>

<?php require_once 'app/views/layout/footer.php'; ?>