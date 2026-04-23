<!-- VIEW: juegos/show.php -->
<!-- Variables disponibles: $titulo, $juego -->

<a href="index.php?c=juego&a=index" class="btn btn-outline-secondary btn-sm mb-4">
    ← Volver al catálogo
</a>

<div class="row g-4">
    <!-- Portada -->
    <div class="col-md-4">
        <div class="rounded-4 d-flex align-items-center justify-content-center shadow"
             style="height:260px;background:<?= e($juego['imagen_color']) ?>20;border:3px solid <?= e($juego['imagen_color']) ?>">
            <i class="fas fa-gamepad" style="font-size:5rem;color:<?= e($juego['imagen_color']) ?>"></i>
        </div>
    </div>

    <!-- Datos del juego -->
    <div class="col-md-8">
        <span class="badge mb-2" style="background:<?= e($juego['imagen_color']) ?>;color:#fff">
            <?= e($juego['genero']) ?>
        </span>
        <h1 class="fw-bold"><?= e($juego['titulo']) ?></h1>

        <div class="d-flex gap-3 mb-3 flex-wrap">
            <span class="text-muted"><i class="fas fa-desktop me-1"></i><?= e($juego['plataforma']) ?></span>
            <span class="text-muted"><i class="fas fa-calendar me-1"></i><?= e($juego['anio']) ?></span>
            <span><i class="fas fa-star text-warning me-1"></i>
                <strong><?= e($juego['calificacion']) ?></strong>/10
            </span>
        </div>

        <p class="lead"><?= e($juego['descripcion']) ?></p>

        <div class="mt-4 p-3 rounded-3" style="background:<?= e($juego['imagen_color']) ?>15">
            <p class="mb-0">
                <strong class="fs-4" style="color:<?= e($juego['imagen_color']) ?>">
                    <?= Juego::formatearPrecio($juego['precio']) ?>
                </strong>
                <span class="text-muted ms-2">COP</span>
            </p>
        </div>
    </div>
</div>

<hr class="mt-5">

<!-- Caja educativa: ¿qué pasó detrás de escena? -->
<div class="bg-dark text-white rounded-4 p-4 mt-4" style="font-family:monospace;font-size:.83rem">
    <p class="text-muted mb-3 small">// ¿Qué ocurrió en esta petición?</p>

    <p class="mb-1">
        <span style="color:#6c7086">1. Navegador:</span>
        <span style="color:#a6e3a1">GET index.php?c=juego&amp;a=show&amp;id=<?= e($juego['id']) ?></span>
    </p>
    <p class="mb-1">
        <span style="color:#6c7086">2. Router:</span>
        <span style="color:#cba6f7">instancia JuegoController, llama show()</span>
    </p>
    <p class="mb-1">
        <span style="color:#6c7086">3. Controller:</span>
        <span style="color:#f38ba8">$id = <?= e($juego['id']) ?>; $juego = Juego::buscar(<?= e($juego['id']) ?>);</span>
    </p>
    <p class="mb-1">
        <span style="color:#6c7086">4. Model:</span>
        <span style="color:#89b4fa">busca en el array, retorna el juego "<?= e($juego['titulo']) ?>"</span>
    </p>
    <p class="mb-0">
        <span style="color:#6c7086">5. View:</span>
        <span style="color:#fab387">View::render('juegos/show', $juego) → este HTML ✓</span>
    </p>
</div>
