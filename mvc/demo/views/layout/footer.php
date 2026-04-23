</div><!-- /container -->

<!-- ── Indicador MVC (solo para fines educativos) ── -->
<div class="layer-badge">
    <div class="lb-row"><span class="lb-c">● Controller:</span> <span><?= e(ucfirst($_GET['c'] ?? 'home') . 'Controller') ?></span></div>
    <div class="lb-row"><span class="lb-m">● Model:</span>      <span>Juego.php</span></div>
    <div class="lb-row"><span class="lb-v">● View:</span>       <span><?= e(($_GET['c'] ?? 'home') . '/' . ($_GET['a'] ?? 'index')) ?>.php</span></div>
</div>

<footer class="bg-dark text-white text-center py-3 mt-5">
    <p class="mb-0 small">
        Demo MVC · ADSO PHP 2026 &nbsp;|&nbsp;
        <a href="../teoria.html" class="text-info text-decoration-none">Ver teoría</a> &nbsp;|&nbsp;
        <a href="../index.html"  class="text-info text-decoration-none">Hub MVC</a>
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
