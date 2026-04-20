<?php
/**
 * contactos/editar.php — Editar un contacto
 *
 * TODO 20: Valida el id (GET o POST). Si inválido, redirige a index.php.
 *
 * TODO 21: Carga el contacto desde la BD con SELECT ... WHERE id = ?
 *           Si no existe, redirige a index.php.
 *
 * TODO 22: Si es POST:
 *           a) Recoge y valida los datos igual que en crear.php
 *           b) Ejecuta el UPDATE:
 *                UPDATE contactos
 *                SET nombre=:nombre, email=:email, telefono=:telefono,
 *                    categoria=:categoria, notas=:notas
 *                WHERE id=:id
 *           c) Redirige a ver.php?id={id}&ok=edit
 */

require_once __DIR__ . '/../config/db.php';

// TODO 20: Valida $id
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
}
if (!$id || $id < 1) {
    header('Location: index.php');
    exit;
}

$titulo        = 'Editar Contacto';
$nivel         = 2;
$archivoActual = 'practica_app/contactos/editar.php';

$categorias = ['Amigo', 'Familiar', 'Trabajo', 'Otro'];
$errores    = [];
$contacto   = null;
$valores    = ['nombre'=>'', 'email'=>'', 'telefono'=>'', 'categoria'=>'', 'notas'=>''];

// TODO 21 y 22:
try {
    $pdo = DB::conectar();

    $stmt = $pdo->prepare('SELECT * FROM contactos WHERE id = ?');
    $stmt->execute([$id]);
    $contacto = $stmt->fetch();

    if (!$contacto) {
        header('Location: index.php');
        exit;
    }

    $valores = [
        'nombre'    => $contacto['nombre'],
        'email'     => $contacto['email'],
        'telefono'  => $contacto['telefono'] ?? '',
        'categoria' => $contacto['categoria'],
        'notas'     => $contacto['notas'] ?? '',
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $valores['nombre']    = trim($_POST['nombre'] ?? '');
        $valores['email']     = trim($_POST['email'] ?? '');
        $valores['telefono']  = trim($_POST['telefono'] ?? '');
        $valores['categoria'] = trim($_POST['categoria'] ?? '');
        $valores['notas']     = trim($_POST['notas'] ?? '');

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
            $stmt = $pdo->prepare('UPDATE contactos SET nombre=:nombre, email=:email, telefono=:telefono, categoria=:categoria, notas=:notas WHERE id=:id');
            $stmt->execute([
                'nombre'    => $valores['nombre'],
                'email'     => $valores['email'],
                'telefono'  => $valores['telefono'] !== '' ? $valores['telefono'] : null,
                'categoria' => $valores['categoria'],
                'notas'     => $valores['notas'] !== '' ? $valores['notas'] : null,
                'id'        => $id,
            ]);

            header('Location: ver.php?id=' . $id . '&ok=edit');
            exit;
        }
    }
} catch (PDOException $e) {
    $errores[] = 'Error de base de datos.';
}

require_once __DIR__ . '/../includes/header.php';
?>

<h1 class="fw-bold mb-3"><i class="fas fa-pen me-2" style="color:var(--color)"></i>Editar Contacto</h1>

<?php if ($errores): ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach ($errores as $error): ?>
        <li><?= htmlspecialchars($error) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<?php if ($contacto): ?>
<div class="card">
  <div class="card-body p-4">
    <form method="post" action="editar.php?id=<?= (int) $id ?>">
      <input type="hidden" name="id" value="<?= (int) $id ?>">

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
        <button type="submit" class="btn btn-db">Guardar cambios</button>
        <a href="ver.php?id=<?= (int) $id ?>" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
