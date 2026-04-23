</div><!-- /container -->

<!-- TODO 25: Agrega el indicador de capa MVC (igual que en la demo).
     Muestra en una cajita fija (position:fixed) qué Controller,
     Model y View se está usando en esta petición.
     Pista: usa $_GET['c'] y $_GET['a'] para construir el texto. -->
<div style="position:fixed; bottom:20px; right:20px; background:#1e1e2e; color:#cdd6f4; padding:12px 16px; border-radius:8px; font-size:0.75rem; font-family:monospace; max-width:250px; box-shadow:0 4px 12px rgba(0,0,0,0.3); z-index:9999">
    <strong style="color:#89b4fa">MVC Flow</strong><br>
    <span style="color:#a6e3a1">Controller:</span> <?= htmlspecialchars(ucfirst($_GET['c'] ?? 'home') . 'Controller') ?><br>
    <span style="color:#f38ba8">Action:</span> <?= htmlspecialchars($_GET['a'] ?? 'index') ?><br>
    <span style="color:#f9e2af">View:</span> <?php 
        $c = $_GET['c'] ?? 'home';
        $a = $_GET['a'] ?? 'index';
        if ($c === 'libro' && $a === 'index') echo 'libros/lista';
        elseif ($c === 'libro' && $a === 'genero') echo 'libros/lista';
        elseif ($c === 'libro' && $a === 'show') echo 'libros/show';
        else echo $c . '/' . $a;
    ?>.php
</div>

<footer class="bg-dark text-white text-center py-3 mt-5">
    <p class="mb-0 small">
        LibroStore · ADSO PHP MVC 2026 &nbsp;|&nbsp;
        <a href="../enunciado.html" class="text-info text-decoration-none">Enunciado</a> &nbsp;|&nbsp;
        <a href="../teoria.html" class="text-info text-decoration-none">Teoría</a>
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
