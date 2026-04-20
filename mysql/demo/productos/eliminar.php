<?php
/**
 * productos/eliminar.php — Eliminar un producto con confirmación
 *
 * Demuestra:
 *  - Cargarlo primero con SELECT (para mostrar su nombre)
 *  - Formulario de confirmación (¿Estás seguro?)
 *  - DELETE con prepared statement
 *  - Redirigir con mensaje de éxito
 */

require_once __DIR__ . '/../config/db.php';

$id = filter_input(INPUT_GET,  'id', FILTER_VALIDATE_INT)
   ?? filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header('Location: index.php');
    exit;
}

$titulo        = 'Eliminar Producto';
$nivel         = 2;
$archivoActual = 'demo/productos/eliminar.php';
$error         = null;
$producto      = null;

try {
    $pdo = DB::conectar();

    // Cargar el producto para mostrar su nombre en la confirmación
    $stmt = $pdo->prepare('SELECT id, nombre, categoria FROM productos WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    $producto = $stmt->fetch();

    if (!$producto) {
        header('Location: index.php');
        exit;
    }

    // ── Procesar la confirmación ──────────────────────────────
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])) {

        // DELETE con prepared statement
        $stmt = $pdo->prepare('DELETE FROM productos WHERE id = ?');
        $stmt->execute([$id]);

        // rowCount() devuelve el número de filas afectadas
        if ($stmt->rowCount() > 0) {
            header('Location: index.php?ok=delete');
            exit;
        } else {
            $error = 'No se encontró el producto para eliminar.';
        }
    }

} catch (PDOException $e) {
    $error = 'Error de base de datos al eliminar.';
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="row justify-content-center">
  <div class="col-lg-6">

    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../index.php">Inicio</a></li>
        <li class="breadcrumb-item"><a href="index.php">Productos</a></li>
        <li class="breadcrumb-item active">Eliminar</li>
      </ol>
    </nav>

    <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php else: ?>

    <div class="card border-danger p-4 text-center">
      <div style="font-size:3rem">⚠️</div>
      <h3 class="fw-bold mt-2 text-danger">¿Eliminar este producto?</h3>
      <p class="text-muted mb-1">Estás a punto de eliminar permanentemente:</p>
      <div class="p-3 my-3 rounded" style="background:#2a1a1a">
        <div class="fw-bold fs-5"><?= htmlspecialchars($producto['nombre']) ?></div>
        <div class="text-muted small">Categoría: <?= htmlspecialchars($producto['categoria']) ?> · ID: #<?= (int)$producto['id'] ?></div>
      </div>
      <p class="text-danger small">
        <i class="fas fa-triangle-exclamation me-1"></i>
        Esta acción no se puede deshacer.
      </p>

      <form method="POST" action="eliminar.php?id=<?= $id ?>">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="d-flex gap-3 justify-content-center mt-2">
          <button type="submit" name="confirmar" value="1" class="btn btn-danger px-4">
            <i class="fas fa-trash me-1"></i> Sí, eliminar
          </button>
          <a href="ver.php?id=<?= $id ?>" class="btn btn-outline-secondary px-4">
            Cancelar
          </a>
        </div>
      </form>
    </div>

    <!-- Educativo: SQL -->
    <div class="mt-4 alert-code p-3 rounded">
      <div class="text-secondary mb-1" style="font-size:.75rem">SQL que se ejecutará si confirmas:</div>
      <code style="color:#f97583">DELETE FROM productos WHERE id = <span style="color:#f0a356"><?= $id ?></span></code>
      <br><br>
      <code style="color:#aaa">// rowCount() después del execute() devolvería: 1</code>
    </div>

    <?php endif; ?>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
