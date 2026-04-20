<?php
/**
 * productos/ver.php — Detalle de un producto
 *
 * Demuestra:
 *  - Validar y castear el parámetro GET
 *  - SELECT WHERE id = ? con prepare() + execute()
 *  - fetch() devuelve una sola fila (o false si no existe)
 *  - Redirigir con header() si el ID no existe
 */

require_once __DIR__ . '/../config/db.php';

// ── Validar el parámetro ──────────────────────────────────────
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header('Location: index.php');
    exit;
}

$titulo        = 'Detalle de Producto';
$nivel         = 2;
$archivoActual = 'demo/productos/ver.php';
$error         = null;
$producto      = null;

try {
    $pdo = DB::conectar();

    // ── Prepared Statement con parámetro nombrado ─────────────
    $stmt = $pdo->prepare('SELECT * FROM productos WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $id]);

    $producto = $stmt->fetch();

    if (!$producto) {
        header('Location: index.php');
        exit;
    }

} catch (PDOException $e) {
    $error = 'Error al consultar la base de datos.';
}

require_once __DIR__ . '/../includes/header.php';
?>

<?php if (isset($_GET['ok'])): ?>
<div class="alert alert-success d-flex gap-2 align-items-center mb-3">
  <i class="fas fa-check-circle"></i>
  <?= $_GET['ok'] === 'edit' ? 'Producto actualizado correctamente.' : 'Producto creado correctamente.' ?>
</div>
<?php endif; ?>

<?php if ($error): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php elseif ($producto): ?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="../index.php">Inicio</a></li>
    <li class="breadcrumb-item"><a href="index.php">Productos</a></li>
    <li class="breadcrumb-item active"><?= htmlspecialchars($producto['nombre']) ?></li>
  </ol>
</nav>

<div class="row g-4">
  <div class="col-md-4">
    <div class="card p-5 text-center h-100"
         style="background:linear-gradient(135deg,#1e2a35,#0d1117)">
      <i class="fas fa-box-open" style="font-size:5rem; color:var(--db)"></i>
      <div class="mt-3">
        <span class="badge bg-secondary"><?= htmlspecialchars($producto['categoria']) ?></span>
      </div>
      <div class="mt-2 text-secondary small">ID en base de datos: #<?= (int)$producto['id'] ?></div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="card p-4 h-100">
      <h2 class="fw-bold mb-1"><?= htmlspecialchars($producto['nombre']) ?></h2>
      <p class="text-muted mb-3"><?= htmlspecialchars($producto['descripcion'] ?? '') ?></p>
      <hr>
      <div class="row g-3">
        <div class="col-6">
          <div class="text-muted small">Precio</div>
          <div class="precio">$<?= number_format($producto['precio'], 0, ',', '.') ?></div>
        </div>
        <div class="col-6">
          <div class="text-muted small">Stock disponible</div>
          <div class="fw-bold <?= $producto['stock'] > 0 ? 'text-success' : 'text-danger' ?>">
            <?= (int)$producto['stock'] ?> unidades
          </div>
        </div>
        <div class="col-6">
          <div class="text-muted small">Categoría</div>
          <div class="fw-bold"><?= htmlspecialchars($producto['categoria']) ?></div>
        </div>
        <div class="col-6">
          <div class="text-muted small">Estado</div>
          <span class="badge <?= $producto['activo'] ? 'bg-success' : 'bg-secondary' ?>">
            <?= $producto['activo'] ? 'Activo' : 'Inactivo' ?>
          </span>
        </div>
        <div class="col-12">
          <div class="text-muted small">Registrado en BD</div>
          <div class="small"><?= htmlspecialchars($producto['creado_en']) ?></div>
        </div>
      </div>
      <div class="d-flex gap-2 mt-4">
        <a href="editar.php?id=<?= (int)$producto['id'] ?>" class="btn btn-db">
          <i class="fas fa-pen me-1"></i> Editar
        </a>
        <a href="eliminar.php?id=<?= (int)$producto['id'] ?>" class="btn btn-outline-danger">
          <i class="fas fa-trash me-1"></i> Eliminar
        </a>
        <a href="index.php" class="btn btn-outline-secondary ms-auto">
          <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
      </div>
    </div>
  </div>
</div>

<div class="mt-4 alert-code p-3 rounded">
  <div class="text-secondary mb-1" style="font-size:.75rem">SQL ejecutado:</div>
  <code style="color:#f97583">SELECT * FROM productos WHERE id = <span style="color:#f0a356">:id</span> LIMIT 1</code>
  <br><code style="color:#aaa">-- :id fue reemplazado de forma segura por: <?= (int)$id ?></code>
</div>

<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
