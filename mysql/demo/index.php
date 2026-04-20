<?php
/**
 * index.php — Página de bienvenida con estadísticas de la BD
 *
 * Demuestra:
 *  - Cómo cargar la clase DB
 *  - fetchColumn() para obtener un valor escalar (el COUNT)
 *  - query() para consultas sin parámetros de usuario
 */

require_once __DIR__ . '/config/db.php';

$titulo       = 'Inicio';
$nivel        = 1;
$archivoActual = 'demo/index.php';

// ── Intentar conectar y obtener estadísticas ───────────────
$error      = null;
$totalProds = 0;
$categorias = 0;
$sinStock   = 0;

try {
    $pdo = DB::conectar();

    // fetchColumn() devuelve solo la primera columna de la primera fila
    $totalProds = $pdo->query('SELECT COUNT(*) FROM productos')->fetchColumn();
    $categorias = $pdo->query('SELECT COUNT(DISTINCT categoria) FROM productos')->fetchColumn();
    $sinStock   = $pdo->query('SELECT COUNT(*) FROM productos WHERE stock = 0')->fetchColumn();

} catch (PDOException $e) {
    // En producción NUNCA muestres el mensaje completo del error
    $error = 'No se pudo conectar a la base de datos. ¿Está MySQL activo?';
    // Para desarrollo, podemos agregar: $error .= ' (' . $e->getMessage() . ')';
}

require_once __DIR__ . '/includes/header.php';
?>

<?php if ($error): ?>
<div class="alert alert-danger d-flex gap-2 align-items-start">
  <i class="fas fa-circle-xmark mt-1 fs-5"></i>
  <div>
    <strong>Error de conexión:</strong> <?= htmlspecialchars($error) ?>
    <hr class="my-2">
    <p class="mb-0 small">
      Revisa que MySQL esté activo (XAMPP → Start MySQL) y que hayas
      ejecutado el script <code>sql/setup.sql</code>.
    </p>
  </div>
</div>
<?php else: ?>

<!-- ENCABEZADO -->
<div class="row align-items-center mb-4">
  <div class="col">
    <h1 class="fw-bold mb-1">
      <i class="fas fa-store me-2" style="color:var(--db2)"></i>
      Tienda de Gadgets
    </h1>
    <p class="text-muted mb-0">Demo PHP + MySQL — datos reales desde la base de datos</p>
  </div>
  <div class="col-auto">
    <a href="productos/crear.php" class="btn btn-db">
      <i class="fas fa-plus me-1"></i> Agregar producto
    </a>
  </div>
</div>

<!-- TARJETAS DE STATS -->
<div class="row g-3 mb-5">
  <div class="col-sm-4">
    <div class="card p-4 text-center">
      <div style="font-size:2.5rem; color:var(--db)">
        <i class="fas fa-box-open"></i>
      </div>
      <div class="display-6 fw-bold mt-2"><?= $totalProds ?></div>
      <div class="text-muted">Productos en BD</div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card p-4 text-center">
      <div style="font-size:2.5rem; color:var(--db2)">
        <i class="fas fa-tags"></i>
      </div>
      <div class="display-6 fw-bold mt-2"><?= $categorias ?></div>
      <div class="text-muted">Categorías</div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card p-4 text-center">
      <div style="font-size:2.5rem; color:#e74c3c">
        <i class="fas fa-triangle-exclamation"></i>
      </div>
      <div class="display-6 fw-bold mt-2"><?= $sinStock ?></div>
      <div class="text-muted">Sin stock</div>
    </div>
  </div>
</div>

<!-- CÓMO FUNCIONA: código explicado -->
<div class="row g-4">
  <div class="col-lg-6">
    <div class="card p-4 h-100">
      <h5 class="fw-bold mb-3">
        <i class="fas fa-plug me-2" style="color:var(--db)"></i>
        Cómo se obtuvo este número
      </h5>
      <div class="alert-code p-3">
<pre class="mb-0">// 1. Cargar la clase de conexión
require_once 'config/db.php';

try {
    // 2. Obtener la instancia PDO (Singleton)
    $pdo = DB::conectar();

    // 3. Consulta sin parámetros → query()
    //    fetchColumn() devuelve solo el primer valor
    $total = $pdo
        ->query('SELECT COUNT(*) FROM productos')
        ->fetchColumn();

    echo "Total: $total";          // → <?= $totalProds ?>

} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}</pre>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card p-4 h-100">
      <h5 class="fw-bold mb-3">
        <i class="fas fa-map me-2" style="color:var(--db2)"></i>
        Flujo completo de esta petición
      </h5>
      <div style="font-family:monospace; font-size:.82rem; background:#0d1117; color:#e6edf3; border-radius:8px; padding:1rem">
        <div class="mb-1"><span style="color:#79c0ff">1. Navegador</span> GET demo/index.php</div>
        <div class="mb-1"><span style="color:#79c0ff">2. PHP</span> require config/db.php</div>
        <div class="mb-1"><span style="color:#79c0ff">3. DB::conectar()</span> → new PDO(dsn, user, pass)</div>
        <div class="mb-1"><span style="color:#79c0ff">4. MySQL</span> ejecuta SELECT COUNT(*)</div>
        <div class="mb-1"><span style="color:#79c0ff">5. PDO</span> devuelve "<?= $totalProds ?>"</div>
        <div class="mb-1"><span style="color:#79c0ff">6. PHP</span> construye el HTML</div>
        <div><span style="color:#56d157">7. Navegador</span> muestra esta página ✓</div>
      </div>
      <div class="mt-3">
        <a href="productos/index.php" class="btn btn-db w-100">
          <i class="fas fa-list me-1"></i> Ver todos los productos
        </a>
      </div>
    </div>
  </div>
</div>

<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
