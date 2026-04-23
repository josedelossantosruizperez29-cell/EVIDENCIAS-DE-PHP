<!-- VIEW: home/index.php -->
<!-- TODO 26: Crea la página de bienvenida de LibroStore.
     Debe incluir:
       - Un título principal usando $titulo (escapado con e())
       - Una descripción breve de la tienda
       - Un botón o enlace que lleve al catálogo: ?c=libro&a=index
       - Un bloque de código (estilo terminal) que muestre el flujo
         MVC de esta petición, como en la demo:
           Navegador → index.php?c=home&a=index
           Router    → HomeController::index()
           Controller→ View::render('home/index', [...])
           View      → HTML al navegador ✓
-->

<div class="row align-items-center g-4">
    <div class="col-md-6">
        <h1 class="display-4 fw-bold"><?= e($titulo) ?></h1>
        <p class="lead text-muted">
            Descubre una colección cuidadosamente seleccionada de libros de distintos géneros. 
            Desde clásicos de la literatura hasta obras de tecnología y ciencia.
        </p>
        <a href="index.php?c=libro&a=index" class="btn btn-lg btn-success">
            <i class="fas fa-book me-2"></i>Explorar Catálogo
        </a>
    </div>
    <div class="col-md-6 text-center">
        <div style="font-size:5rem">📚</div>
    </div>
</div>

<hr class="my-5">

<div class="bg-dark text-white rounded-4 p-4" style="font-family:monospace;font-size:.85rem">
    <strong style="color:#89b4fa">Flujo MVC en esta petición:</strong><br><br>
    <span style="color:#a6e3a1">→ Navegador:</span> index.php?c=home&a=index<br>
    <span style="color:#a6e3a1">→ Router:</span> Instancia HomeController y llama index()<br>
    <span style="color:#a6e3a1">→ Controller:</span> Recibe datos y llama View::render('home/index')<br>
    <span style="color:#a6e3a1">→ View:</span> Este HTML es generado y mostrado ✓
</div>
