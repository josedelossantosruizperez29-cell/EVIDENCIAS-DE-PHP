<?php
/**
 * productos/editar.php — Editar un producto existente
 *
 * Demuestra:
 *  - SELECT para cargar los datos actuales
 *  - UPDATE con prepared statement
 *  - Reutilizar el mismo formulario de crear (formulario reutilizable)
 *  - Validación idéntica a crear.php (en producción, extraer a función)
 */

require_once __DIR__ . '/../config/db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)
   ?? filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header('Location: index.php');
    exit;
}

$titulo        = 'Editar Producto';
$nivel         = 2;
$archivoActual = 'demo/productos/editar.php';

$categorias = ['Computadores','Periféricos','Monitores','Audio','Tablets','Almacenamiento','Accesorios','Mobiliario'];
$errores    = [];
$producto   = null;

try {
    $pdo = DB::conectar();

    // ── Cargar el producto actual ─────────────────────────────
    $stmt = $pdo->prepare('SELECT * FROM productos WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    $producto = $stmt->fetch();

    if (!$producto) {
        header('Location: index.php');
        exit;
    }

    // ── Procesar el formulario de edición ─────────────────────
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nombre      = trim($_POST['nombre']      ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio      = $_POST['precio']   ?? '';
        $categoria   = trim($_POST['categoria']   ?? '');
        $stock       = $_POST['stock']    ?? '';

        // Repoblar $producto con los valores enviados (para el formulario)
        $producto = array_merge($producto, compact('nombre','descripcion','precio','categoria','stock'));

        // Validar
        if (empty($nombre))                                  $errores[] = 'El nombre es obligatorio.';
        if (!is_numeric($precio) || $precio < 0)             $errores[] = 'Precio inválido.';
        if (!in_array($categoria, $categorias, true))        $errores[] = 'Categoría inválida.';
        if (!ctype_digit((string)$stock) || $stock < 0)      $errores[] = 'Stock inválido.';

        if (empty($errores)) {
            // ── UPDATE con parámetros nombrados ───────────────
            $sql = 'UPDATE productos
                    SET nombre = :nombre,
                        descripcion = :descripcion,
                        precio = :precio,
                        categoria = :categoria,
                        stock = :stock
                    WHERE id = :id';

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nombre'      => $nombre,
                ':descripcion' => $descripcion,
                ':precio'      => (float)$precio,
                ':categoria'   => $categoria,
                ':stock'       => (int)$stock,
                ':id'          => $id,
            ]);

            // Patrón PRG: redirigir tras éxito
            header("Location: ver.php?id={$id}&ok=edit");
            exit;
        }
    }

} catch (PDOException $e) {
    $errores[] = 'Error de base de datos.';
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="row justify-content-center">
  <div class="col-lg-7">

    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../index.php">Inicio</a></li>
        <li class="breadcrumb-item"><a href="index.php">Productos</a></li>
        <li class="breadcrumb-item"><a href="ver.php?id=<?= $id ?>">
          <?= htmlspecialchars($producto['nombre'] ?? '') ?>
        </a></li>
        <li class="breadcrumb-item active">Editar</li>
      </ol>
    </nav>

    <div class="card p-4">
      <h3 class="fw-bold mb-4">
        <i class="fas fa-pen me-2" style="color:var(--db)"></i>
        Editar producto
        <span class="badge bg-secondary ms-2" style="font-size:.7rem">ID #<?= $id ?></span>
      </h3>

      <?php if (!empty($errores)): ?>
      <div class="alert alert-danger">
        <ul class="mb-0">
          <?php foreach ($errores as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>

      <form method="POST" action="editar.php?id=<?= $id ?>" novalidate>
        <input type="hidden" name="id" value="<?= $id ?>">

        <div class="mb-3">
          <label for="nombre" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="nombre" name="nombre"
                 value="<?= htmlspecialchars($producto['nombre'] ?? '') ?>" required maxlength="100">
        </div>

        <div class="mb-3">
          <label for="descripcion" class="form-label fw-semibold">Descripción</label>
          <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($producto['descripcion'] ?? '') ?></textarea>
        </div>

        <div class="row g-3">
          <div class="col-sm-6">
            <label for="precio" class="form-label fw-semibold">Precio (COP) <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="precio" name="precio"
                   value="<?= htmlspecialchars($producto['precio'] ?? '') ?>"
                   min="0" step="1000" required>
          </div>
          <div class="col-sm-6">
            <label for="stock" class="form-label fw-semibold">Stock <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="stock" name="stock"
                   value="<?= htmlspecialchars($producto['stock'] ?? '') ?>" min="0" required>
          </div>
        </div>

        <div class="mb-3 mt-3">
          <label for="categoria" class="form-label fw-semibold">Categoría <span class="text-danger">*</span></label>
          <select class="form-select" id="categoria" name="categoria" required>
            <?php foreach ($categorias as $cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>"
                    <?= ($producto['categoria'] ?? '') === $cat ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat) ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-db flex-grow-1">
            <i class="fas fa-save me-1"></i> Guardar cambios
          </button>
          <a href="ver.php?id=<?= $id ?>" class="btn btn-outline-secondary">Cancelar</a>
        </div>
      </form>
    </div>

    <!-- Educativo: SQL -->
    <div class="mt-4 alert-code p-3 rounded">
      <div class="text-secondary mb-1" style="font-size:.75rem">SQL que se ejecutará al guardar:</div>
      <code style="color:#f97583">UPDATE productos SET nombre=:nombre, descripcion=:descripcion,<br>
precio=:precio, categoria=:categoria, stock=:stock<br>
<span style="color:#aaa">WHERE id = <span style="color:#f0a356"><?= $id ?></span></span></code>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
