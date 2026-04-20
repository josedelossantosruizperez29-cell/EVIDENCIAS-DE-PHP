<?php
/**
 * contactos/eliminar.php — Eliminar un contacto
 *
 * TODO 24: Valida el id (GET o POST). Si inválido, redirige a index.php.
 *
 * TODO 25: Carga el contacto para mostrar su nombre en la confirmación.
 *
 * TODO 26: Si es POST y existe $_POST['confirmar']:
 *           a) Ejecuta: DELETE FROM contactos WHERE id = ?
 *           b) Verifica con rowCount() que realmente se eliminó
 *           c) Redirige a index.php?ok=delete
 */

require_once __DIR__ . '/../config/db.php';

// TODO 24: Valida $id
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
}
if (!$id || $id < 1) {
    header('Location: index.php');
    exit;
}

$titulo        = 'Eliminar Contacto';
$nivel         = 2;
$archivoActual = 'practica_app/contactos/eliminar.php';
$error         = null;
$contacto      = null;

// TODO 25 y 26:
try {
    $pdo = DB::conectar();

    $stmt = $pdo->prepare('SELECT * FROM contactos WHERE id = ?');
    $stmt->execute([$id]);
    $contacto = $stmt->fetch();

    if (!$contacto) {
        header('Location: index.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])) {
        $stmt = $pdo->prepare('DELETE FROM contactos WHERE id = ?');
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            header('Location: index.php?ok=delete');
            exit;
        }

        $error = 'No se pudo eliminar el contacto.';
    }
} catch (PDOException $e) {
    $error = 'Error de base de datos.';
}

require_once __DIR__ . '/../includes/header.php';
?>

<?php if ($error): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php elseif ($contacto): ?>

<div class="card border-danger">
  <div class="card-body p-4">
    <h1 class="fw-bold mb-3 text-danger">Eliminar contacto</h1>
    <p class="mb-2">Vas a eliminar a <strong><?= htmlspecialchars($contacto['nombre']) ?></strong>.</p>
    <p class="text-muted">Esta acción no se puede deshacer.</p>

    <form method="post" action="eliminar.php?id=<?= (int) $id ?>" class="d-flex gap-2">
      <input type="hidden" name="id" value="<?= (int) $id ?>">
      <input type="hidden" name="confirmar" value="1">
      <button type="submit" class="btn btn-danger">Sí, eliminar</button>
      <a href="ver.php?id=<?= (int) $id ?>" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</div>

<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
