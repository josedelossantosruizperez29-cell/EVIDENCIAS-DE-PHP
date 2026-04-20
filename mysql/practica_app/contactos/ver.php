<?php
/**
 * contactos/ver.php — Ver un contacto
 *
 * TODO 13: Valida el parámetro id de la URL con filter_input().
 *           Si es inválido (no es entero o < 1), redirige a index.php.
 * TODO 14: En un bloque try/catch:
 *           a) Conecta con DB::conectar()
 *           b) Prepara y ejecuta: SELECT * FROM contactos WHERE id = :id LIMIT 1
 *           c) Usa fetch() para traer la fila a $contacto
 *           d) Si $contacto es false (no existe), redirige a index.php
 *           e) Captura PDOException → $error
 */

require_once __DIR__ . '/../config/db.php';

// TODO 13: Valida $id
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    header('Location: index.php');
    exit;
}

$titulo        = 'Ver Contacto';
$nivel         = 2;
$archivoActual = 'practica_app/contactos/ver.php';
$error         = null;
$contacto      = null;

// TODO 14: Consulta y fetch()
try {
    $pdo = DB::conectar();
    $stmt = $pdo->prepare('SELECT * FROM contactos WHERE id = :id LIMIT 1');
    $stmt->execute(['id' => $id]);
    $contacto = $stmt->fetch();

    if (!$contacto) {
        header('Location: index.php');
        exit;
    }
} catch (PDOException $e) {
    $error = $e->getMessage();
}

require_once __DIR__ . '/../includes/header.php';
?>

<?php if ($error): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php elseif ($contacto): ?>

<div class="card">
  <div class="card-body p-4">
    <h2 class="fw-bold mb-3"><?= htmlspecialchars($contacto['nombre']) ?></h2>

    <p class="mb-2">
      <strong>Email:</strong>
      <a href="mailto:<?= htmlspecialchars($contacto['email']) ?>"><?= htmlspecialchars($contacto['email']) ?></a>
    </p>
    <p class="mb-2">
      <strong>Teléfono:</strong>
      <?= !empty($contacto['telefono']) ? htmlspecialchars($contacto['telefono']) : 'No registrado' ?>
    </p>
    <p class="mb-2">
      <strong>Categoría:</strong>
      <span class="badge bg-primary"><?= htmlspecialchars($contacto['categoria']) ?></span>
    </p>
    <p class="mb-2">
      <strong>Notas:</strong><br>
      <?= nl2br(htmlspecialchars($contacto['notas'] ?? 'Sin notas')) ?>
    </p>
    <p class="mb-4 text-muted">
      <strong>Fecha de creación:</strong> <?= htmlspecialchars($contacto['creado_en']) ?>
    </p>

    <div class="d-flex flex-wrap gap-2">
      <a href="editar.php?id=<?= (int) $contacto['id'] ?>" class="btn btn-db">
        <i class="fas fa-pen me-1"></i> Editar
      </a>
      <a href="eliminar.php?id=<?= (int) $contacto['id'] ?>" class="btn btn-outline-danger">
        <i class="fas fa-trash me-1"></i> Eliminar
      </a>
      <a href="index.php" class="btn btn-secondary">
        ← Volver
      </a>
    </div>
  </div>
</div>

<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
