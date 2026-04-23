<!-- VIEW: juegos/lista.php -->
<!-- Variables disponibles: $titulo, $juegos, $generos, $generoActivo -->

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="fw-bold mb-0"><?= e($titulo) ?></h1>
    <span class="badge bg-secondary"><?= count($juegos) ?> juego<?= count($juegos) !== 1 ? 's' : '' ?></span>
</div>

<!-- Filtros por género (el Controller tiene la acción 'genero') -->
<div class="mb-4 d-flex gap-2 flex-wrap">
    <a href="index.php?c=juego&a=index"
       class="btn btn-sm <?= empty($generoActivo ?? '') ? 'btn-dark' : 'btn-outline-dark' ?>">
        Todos
    </a>
    <?php foreach ($generos as $g): ?>
    <a href="index.php?c=juego&a=genero&g=<?= urlencode($g) ?>"
       class="btn btn-sm <?= ($generoActivo ?? '') === $g ? 'btn-success' : 'btn-outline-success' ?>">
        <?= e($g) ?>
    </a>
    <?php endforeach; ?>
</div>

<!-- Tarjetas de juegos -->
<?php if (empty($juegos)): ?>
    <div class="alert alert-warning">No hay juegos en este género.</div>
<?php else: ?>
<div class="row g-4">
    <?php foreach ($juegos as $juego): ?>
    <div class="col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-top: 4px solid <?= e($juego['imagen_color']) ?> !important">
            <div class="card-body">
                <!-- Encabezado con color del juego -->
                <div class="rounded-3 mb-3 d-flex align-items-center justify-content-center"
                     style="height:80px;background:<?= e($juego['imagen_color']) ?>20">
                    <i class="fas fa-gamepad fa-2x" style="color:<?= e($juego['imagen_color']) ?>"></i>
                </div>

                <span class="badge bg-secondary mb-2"><?= e($juego['genero']) ?></span>
                <h5 class="card-title fw-bold"><?= e($juego['titulo']) ?></h5>
                <p class="text-muted small"><?= e($juego['plataforma']) ?> · <?= e($juego['anio']) ?></p>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <span class="text-warning">★</span>
                        <strong><?= e($juego['calificacion']) ?></strong>
                        <span class="text-muted small">/10</span>
                    </div>
                    <strong style="color:<?= e($juego['imagen_color']) ?>">
                        <?= Juego::formatearPrecio($juego['precio']) ?>
                    </strong>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pb-3">
                <a href="index.php?c=juego&a=show&id=<?= e($juego['id']) ?>"
                   class="btn btn-sm w-100 text-white"
                   style="background:<?= e($juego['imagen_color']) ?>">
                    Ver detalle →
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
