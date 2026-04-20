<?php
/**
 * productos/crear.php — Formulario de creación e INSERT
 *
 * Demuestra:
 *  - Patrón POST/Redirect/GET para evitar reenvíos del formulario
 *  - Validación del lado del servidor
 *  - INSERT con prepared statement y parámetros nombrados
 *  - lastInsertId() para obtener el ID recién creado
 *  - Preservar valores del formulario en caso de error
 */

require_once __DIR__ . '/../config/db.php';

$titulo        = 'Agregar Producto';
$nivel         = 2;
$archivoActual = 'demo/productos/crear.php';

$categorias = ['Computadores','Periféricos','Monitores','Audio','Tablets','Almacenamiento','Accesorios','Mobiliario'];
$errores    = [];
$valores    = ['nombre'=>'','descripcion'=>'','precio'=>'','categoria'=>'','stock'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ── 1. Recoger y limpiar los datos del formulario ─────────
    $nombre      = trim($_POST['nombre']      ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio      = $_POST['precio']   ?? '';
    $categoria   = trim($_POST['categoria']   ?? '');
    $stock       = $_POST['stock']    ?? '';

    // Guardar para repoblar el formulario si hay errores
    $valores = compact('nombre','descripcion','precio','categoria','stock');

    // ── 2. Validar ────────────────────────────────────────────
    if (empty($nombre)) {
        $errores[] = 'El nombre es obligatorio.';
    } elseif (strlen($nombre) > 100) {
        $errores[] = 'El nombre no puede superar 100 caracteres.';
    }

    if (!is_numeric($precio) || $precio < 0) {
        $errores[] = 'El precio debe ser un número positivo.';
    }

    if (!in_array($categoria, $categorias, true)) {
        $errores[] = 'Selecciona una categoría válida.';
    }

    if (!ctype_digit((string)$stock) || $stock < 0) {
        $errores[] = 'El stock debe ser un número entero positivo.';
    }

    // ── 3. Si no hay errores, INSERT ──────────────────────────
    if (empty($errores)) {
        try {
            $pdo = DB::conectar();

            // Prepared statement con parámetros nombrados (:nombre, :precio, ...)
            $sql = 'INSERT INTO productos (nombre, descripcion, precio, categoria, stock)
                    VALUES (:nombre, :descripcion, :precio, :categoria, :stock)';

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nombre'      => $nombre,
                ':descripcion' => $descripcion,
                ':precio'      => (float)$precio,
                ':categoria'   => $categoria,
                ':stock'       => (int)$stock,
            ]);

            // lastInsertId() devuelve el ID auto_increment generado
            $nuevoId = $pdo->lastInsertId();

            // ── Patrón POST/Redirect/GET ──────────────────────
            // Redirigir después del INSERT evita que F5 reenvíe el formulario
            header("Location: ver.php?id={$nuevoId}&ok=1");
            exit;

        } catch (PDOException $e) {
            $errores[] = 'Error al guardar en la base de datos.';
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="row justify-content-center">
  <div class="col-lg-7">

    <!-- Migas de pan -->
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../index.php">Inicio</a></li>
        <li class="breadcrumb-item"><a href="index.php">Productos</a></li>
        <li class="breadcrumb-item active">Agregar</li>
      </ol>
    </nav>

    <div class="card p-4">
      <h3 class="fw-bold mb-4">
        <i class="fas fa-plus-circle me-2" style="color:var(--db)"></i>
        Agregar producto
      </h3>

      <!-- Errores -->
      <?php if (!empty($errores)): ?>
      <div class="alert alert-danger">
        <ul class="mb-0">
          <?php foreach ($errores as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>

      <!-- Formulario -->
      <form method="POST" action="crear.php" novalidate>

        <div class="mb-3">
          <label for="nombre" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="nombre" name="nombre"
                 value="<?= htmlspecialchars($valores['nombre']) ?>" required maxlength="100">
        </div>

        <div class="mb-3">
          <label for="descripcion" class="form-label fw-semibold">Descripción</label>
          <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($valores['descripcion']) ?></textarea>
        </div>

        <div class="row g-3">
          <div class="col-sm-6">
            <label for="precio" class="form-label fw-semibold">Precio (COP) <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="precio" name="precio"
                   value="<?= htmlspecialchars($valores['precio']) ?>"
                   min="0" step="1000" required>
          </div>
          <div class="col-sm-6">
            <label for="stock" class="form-label fw-semibold">Stock <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="stock" name="stock"
                   value="<?= htmlspecialchars($valores['stock']) ?>"
                   min="0" required>
          </div>
        </div>

        <div class="mb-3 mt-3">
          <label for="categoria" class="form-label fw-semibold">Categoría <span class="text-danger">*</span></label>
          <select class="form-select" id="categoria" name="categoria" required>
            <option value="">— Selecciona —</option>
            <?php foreach ($categorias as $cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>"
                    <?= $valores['categoria'] === $cat ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat) ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-db flex-grow-1">
            <i class="fas fa-save me-1"></i> Guardar producto
          </button>
          <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
        </div>
      </form>
    </div>

    <!-- Caja educativa -->
    <div class="mt-4 alert-code p-3 rounded">
      <div class="text-secondary mb-1" style="font-size:.75rem">SQL que se ejecutará al guardar:</div>
      <code style="color:#f97583">INSERT INTO productos (nombre, descripcion, precio, categoria, stock)<br>
VALUES (<span style="color:#f0a356">:nombre</span>, <span style="color:#f0a356">:descripcion</span>, <span style="color:#f0a356">:precio</span>, <span style="color:#f0a356">:categoria</span>, <span style="color:#f0a356">:stock</span>)</code>
      <br><br>
      <code style="color:#aaa">// Los :placeholders son reemplazados por PDO de forma segura</code>
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
