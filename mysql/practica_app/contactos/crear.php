<?php
/**
 * contactos/crear.php — Formulario de creación e INSERT
 *
 * TODO 16: Recoge los datos del formulario (solo si es POST):
 *           nombre, email, telefono, categoria, notas
 *           Usa trim() para limpiar espacios.
 *
 * TODO 17: Valida los datos:
 *           - nombre: obligatorio, máx 100 caracteres
 *           - email: obligatorio, debe ser email válido (filter_var + FILTER_VALIDATE_EMAIL)
 *           - categoria: debe ser uno de los valores válidos del ENUM
 *           Guarda errores en el array $errores.
 *
 * TODO 18: Si no hay errores, ejecuta el INSERT:
 *           INSERT INTO contactos (nombre, email, telefono, categoria, notas)
 *           VALUES (:nombre, :email, :telefono, :categoria, :notas)
 *           Usa prepare() y execute() con parámetros nombrados.
 *           Después del INSERT exitoso, redirige a ver.php?id={lastInsertId()}&ok=1
 */

require_once __DIR__ . '/../config/db.php';

$titulo        = 'Agregar Contacto';
$nivel         = 2;
$archivoActual = 'practica_app/contactos/crear.php';

$categorias = ['Amigo', 'Familiar', 'Trabajo', 'Otro'];
$errores    = [];
$valores    = ['nombre'=>'', 'email'=>'', 'telefono'=>'', 'categoria'=>'', 'notas'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO 16: Recoger datos
    $valores['nombre']    = trim($_POST['nombre'] ?? '');
    $valores['email']     = trim($_POST['email'] ?? '');
    $valores['telefono']  = trim($_POST['telefono'] ?? '');
    $valores['categoria'] = trim($_POST['categoria'] ?? '');
    $valores['notas']     = trim($_POST['notas'] ?? '');

    // TODO 17: Validar
    if ($valores['nombre'] === '') {
        $errores[] = 'El nombre es obligatorio.';
    } elseif (mb_strlen($valores['nombre']) > 100) {
        $errores[] = 'El nombre no puede superar 100 caracteres.';
    }

    if ($valores['email'] === '') {
        $errores[] = 'El email es obligatorio.';
    } elseif (!filter_var($valores['email'], FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El email no es válido.';
    }

    if (!in_array($valores['categoria'], $categorias, true)) {
        $errores[] = 'Debes seleccionar una categoría válida.';
    }

    if (empty($errores)) {
        try {
            // TODO 18: INSERT con prepared statement
            $pdo = DB::conectar();
            $stmt = $pdo->prepare('INSERT INTO contactos (nombre, email, telefono, categoria, notas) VALUES (:nombre, :email, :telefono, :categoria, :notas)');
            $stmt->execute([
                'nombre'    => $valores['nombre'],
                'email'     => $valores['email'],
                'telefono'  => $valores['telefono'] !== '' ? $valores['telefono'] : null,
                'categoria' => $valores['categoria'],
                'notas'     => $valores['notas'] !== '' ? $valores['notas'] : null,
            ]);

            $nuevoId = (int) $pdo->lastInsertId();
            header('Location: ver.php?id=' . $nuevoId . '&ok=1');
            exit;
        } catch (PDOException $e) {
            $errores[] = 'Error al guardar en la base de datos.';
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<h1 class="fw-bold mb-3"><i class="fas fa-plus me-2" style="color:var(--color)"></i>Agregar Contacto</h1>

<?php if ($errores): ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach ($errores as $error): ?>
        <li><?= htmlspecialchars($error) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<div class="card">
  <div class="card-body p-4">
    <form method="post" action="">
      <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" maxlength="100" class="form-control" value="<?= htmlspecialchars($valores['nombre']) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($valores['email']) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($valores['telefono']) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Categoría</label>
        <select name="categoria" class="form-select">
          <option value="">Selecciona una opción</option>
          <?php foreach ($categorias as $categoria): ?>
            <option value="<?= htmlspecialchars($categoria) ?>" <?= $valores['categoria'] === $categoria ? 'selected' : '' ?>>
              <?= htmlspecialchars($categoria) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Notas</label>
        <textarea name="notas" class="form-control" rows="4"><?= htmlspecialchars($valores['notas']) ?></textarea>
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-db">Guardar contacto</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
