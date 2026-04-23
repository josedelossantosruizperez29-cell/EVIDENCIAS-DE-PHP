<!-- VIEW: home/index.php -->
<!-- Solo HTML + variables del Controller. Cero lógica de negocio. -->

<div class="row align-items-center py-4">
    <div class="col-lg-6">
        <h1 class="display-5 fw-bold"><?= e($titulo) ?></h1>
        <p class="lead text-muted">
            Esta aplicación demuestra el patrón <strong>MVC</strong> implementado en PHP puro,
            sin frameworks. Cada petición pasa por el <em>Front Controller</em>,
            el <em>Router</em> decide qué <em>Controller</em> ejecutar,
            el Controller pide datos al <em>Model</em> y se los pasa a la <em>View</em>.
        </p>
        <a href="index.php?c=juego&a=index" class="btn btn-success btn-lg px-4 shadow-sm">
            <i class="fas fa-gamepad me-2"></i>Ver catálogo de juegos
        </a>
    </div>
    <div class="col-lg-6 mt-4 mt-lg-0">
        <!-- Diagrama del flujo MVC en esta misma request -->
        <div class="bg-dark text-white rounded-4 p-4" style="font-family:monospace;font-size:.85rem">
            <p class="text-muted mb-2 small">// Flujo de esta petición:</p>
            <p class="mb-1"><span style="color:#f38ba8">Navegador</span>  →  <span style="color:#a6e3a1">index.php?c=home&amp;a=index</span></p>
            <p class="mb-1"><span style="color:#a6e3a1">Router</span>     →  <span style="color:#cba6f7">HomeController::index()</span></p>
            <p class="mb-1"><span style="color:#cba6f7">Controller</span> →  <span style="color:#89b4fa">View::render('home/index', [...])</span></p>
            <p class="mb-0"><span style="color:#89b4fa">View</span>       →  <span style="color:#fab387">HTML al navegador ✓</span></p>
        </div>
    </div>
</div>

<hr>

<!-- Descripción de los 3 componentes con enlaces a los archivos -->
<h3 class="mt-4 mb-3 fw-bold">Archivos de esta demo</h3>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-top:4px solid #c0392b !important">
            <div class="card-body">
                <h6 class="text-danger fw-bold"><i class="fas fa-sitemap me-2"></i>Controllers</h6>
                <ul class="list-unstyled small mb-0">
                    <li class="py-1 border-bottom"><code>HomeController.php</code> <span class="text-muted">← estás aquí</span></li>
                    <li class="py-1"><a href="index.php?c=juego&a=index" class="text-decoration-none"><code>JuegoController.php</code></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-top:4px solid #2980b9 !important">
            <div class="card-body">
                <h6 class="text-primary fw-bold"><i class="fas fa-database me-2"></i>Models</h6>
                <ul class="list-unstyled small mb-0">
                    <li class="py-1"><code>Juego.php</code> — <code>todos()</code>, <code>buscar($id)</code>, <code>porGenero($g)</code></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-top:4px solid #8e44ad !important">
            <div class="card-body">
                <h6 style="color:#8e44ad" class="fw-bold"><i class="fas fa-code me-2"></i>Views</h6>
                <ul class="list-unstyled small mb-0">
                    <li class="py-1 border-bottom"><code>home/index.php</code> <span class="text-muted">← esta vista</span></li>
                    <li class="py-1 border-bottom"><a href="index.php?c=juego&a=index" class="text-decoration-none"><code>juegos/lista.php</code></a></li>
                    <li class="py-1"><code>juegos/show.php</code></li>
                </ul>
            </div>
        </div>
    </div>
</div>
