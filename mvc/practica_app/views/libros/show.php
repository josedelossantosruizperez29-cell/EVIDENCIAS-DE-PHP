<!-- VIEW: libros/show.php -->
<!-- Variable disponible: $libro (array con todos los datos del libro) -->
<!-- REGLA DE ORO: Solo HTML + la variable $libro. Cero SQL. -->

<!-- TODO 31: Botón "← Volver al catálogo" que apunte a ?c=libro&a=index -->
<a href="index.php?c=libro&a=index" class="btn btn-outline-secondary mb-4">
    <i class="fas fa-arrow-left me-2"></i>Volver al catálogo
</a>

<div class="row g-4">
    <!-- TODO 32: Columna izquierda — portada visual.
         Crea un div con fondo usando $libro['color'] (con opacidad baja).
         Muestra un ícono grande fa-book con el color del libro. -->
    <div class="col-md-4">
        <!-- TODO 32: tu tarjeta visual aquí -->
        <div class="rounded-4 p-5 text-center" style="background: <?= e($libro['color']) ?>22; border: 2px solid <?= e($libro['color']) ?>">
            <i class="fas fa-book" style="font-size: 8rem; color: <?= e($libro['color']) ?>"></i>
            <p class="mt-3 text-muted small">Edición 2024</p>
        </div>
    </div>

    <!-- TODO 33: Columna derecha — información completa.
         Muestra (todo escapado con e()):
           - El género como badge con el color del libro
           - El título como h1
           - El autor con un ícono de usuario
           - El año con un ícono de calendario
           - La descripción completa
           - El precio formateado con Libro::formatearPrecio()
         Usa e() en TODOS los valores. -->
    <div class="col-md-8">
        <!-- TODO 33: tu información aquí -->
        <div class="mb-3">
            <span class="badge fs-6" style="background: <?= e($libro['color']) ?>">
                <?= e($libro['genero']) ?>
            </span>
        </div>
        
        <h1 class="fw-bold mb-2"><?= e($libro['titulo']) ?></h1>
        
        <p class="lead text-muted mb-4">
            <i class="fas fa-user me-2"></i><?= e($libro['autor']) ?><br>
            <i class="fas fa-calendar me-2"></i>Publicado en <?= e($libro['anio']) ?>
        </p>
        
        <p class="mb-4" style="line-height: 1.8; font-size: 1.05rem">
            <?= e($libro['descripcion']) ?>
        </p>
        
        <div class="d-flex align-items-center gap-3">
            <span class="text-success fw-bold" style="font-size: 2rem">
                <?= Libro::formatearPrecio($libro['precio']) ?>
            </span>
            <button class="btn btn-lg btn-success" disabled>
                <i class="fas fa-shopping-cart me-2"></i>Agregar al carrito
            </button>
        </div>
    </div>
</div>

<hr class="mt-5">

<!-- TODO 34: Caja educativa del flujo MVC (como en la demo).
     Muestra en una caja oscura con fuente monoespaciada el flujo
     de esta petición específica, con el id real del libro:
       1. Navegador: GET index.php?c=libro&a=show&id={id}
       2. Router: instancia LibroController, llama show()
       3. Controller: $id = {id}; $libro = Libro::buscar({id});
       4. Model: busca en array, retorna "{titulo}"
       5. View: View::render('libros/show', $datos) → este HTML ✓ -->
<div class="bg-dark text-white rounded-4 p-4 mt-4" style="font-family:monospace;font-size:.83rem">
    <!-- TODO 34: tu flujo aquí -->
    <strong style="color:#89b4fa">Flujo MVC en esta petición:</strong><br><br>
    <span style="color:#a6e3a1">→ Navegador:</span> GET index.php?c=libro&a=show&id=<?= e($libro['id']) ?><br>
    <span style="color:#a6e3a1">→ Router:</span> Instancia LibroController y llama show()<br>
    <span style="color:#a6e3a1">→ Controller:</span> Lee $_GET['id'] = <?= e($libro['id']) ?>, llama Libro::buscar(<?= e($libro['id']) ?>)<br>
    <span style="color:#a6e3a1">→ Model:</span> Busca en el array y retorna "<?= e($libro['titulo']) ?>"<br>
    <span style="color:#a6e3a1">→ View:</span> View::render('libros/show', $datos) → este HTML ✓
</div>
