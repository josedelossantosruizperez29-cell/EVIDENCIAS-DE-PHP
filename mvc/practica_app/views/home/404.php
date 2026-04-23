<!-- VIEW: home/404.php -->
<!-- TODO 27: Crea una página 404 amigable.
     Debe incluir:
       - Un ícono o emoji grande (ej: 📚 o 🔍)
       - El código "404" en grande
       - Un mensaje explicando que el libro o página no existe
       - Un botón para volver al inicio (index.php)
-->

<div class="text-center py-5">
    <div style="font-size:6rem; margin-bottom:20px">🔍</div>
    <h1 class="display-1 fw-bold text-danger">404</h1>
    <h2 class="mb-3">Página no encontrada</h2>
    <p class="text-muted mb-4" style="font-size:1.1rem">
        Lo sentimos, el libro o página que buscas no existe en LibroStore.
    </p>
    <div class="d-flex gap-3 justify-content-center flex-wrap">
        <a href="index.php" class="btn btn-lg btn-primary">
            <i class="fas fa-home me-2"></i>Volver al Inicio
        </a>
        <a href="index.php?c=libro&a=index" class="btn btn-lg btn-success">
            <i class="fas fa-book me-2"></i>Ver Catálogo
        </a>
    </div>
</div>
