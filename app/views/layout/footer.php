
</div> <footer class="bg-white border-top py-3">
        <div class="container-fluid text-center">
            <span class="text-muted small">
                &copy; 2025-<?php echo date('Y'); ?> <strong>Union Hôtel</strong>. Conçu et developpé par <strong><a href="https://kizo19.github.io/" target="_blank">Joseph Kizô</a></strong>
            </span>
        </div>
    </footer>
</div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const btn = document.getElementById('sidebarCollapse');
        const sidebar = document.querySelector('.sidebar');
        
        if(btn) {
            btn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        }

        // Fermer la sidebar si on clique en dehors (sur mobile)
        document.addEventListener('click', function(event) {
            const isClickInside = sidebar.contains(event.target) || btn.contains(event.target);
            if (!isClickInside && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
    });
</script>
</body>
</html>
    
    
