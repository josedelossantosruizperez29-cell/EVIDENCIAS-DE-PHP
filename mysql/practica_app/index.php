<?php
/**
 * index.php — Página de bienvenida con estadísticas
 *
 * TODO 2: Carga el archivo config/db.php con require_once.
 * TODO 3: Usando un bloque try/catch:
 *           a) Llama a DB::conectar() para obtener $pdo
 *           b) Usa $pdo->query(...)->fetchColumn() para contar el total de contactos
 *           c) Usa otro query para contar cuántos tienen teléfono (WHERE telefono IS NOT NULL)
 *           d) Si hay PDOException, guarda el mensaje en $error
 */

// TODO 2:
require_once __DIR__ . '/config/db.php';
$titulo = 'Inicio';
$nivel  = 1;

$error   = null;
$total   = 0;
$conTel  = 0;

// TODO 3:
try {
    $pdo = DB::conectar();
    $total  = (int) $pdo->query('SELECT COUNT(*) FROM contactos')->fetchColumn();
    $conTel = (int) $pdo->query('SELECT COUNT(*) FROM contactos WHERE telefono IS NOT NULL')->fetchColumn();
} catch (PDOException $e) {
    $error = $e->getMessage();
}

$archivoActual = 'practica_app/index.php';
require_once __DIR__ . '/includes/header.php';
?>

<?php if ($error): ?>
<div class="alert alert-danger">
  <strong>Error de conexión:</strong> <?= htmlspecialchars($error) ?>
  <hr>
  <p class="mb-0 small">Verifica que MySQL esté activo y que hayas ejecutado <code>sql/setup.sql</code>.</p>
</div>
<?php else: ?>

<div class="row align-items-center mb-4">
  <div class="col">
    <h1 class="fw-bold mb-1">
      <i class="fas fa-address-book me-2" style="color:var(--color)"></i>
      Mi Agenda de Contactos
    </h1>
    <p class="text-muted mb-0">Consulta y administra tus contactos guardados en MySQL.</p>
  </div>
  <div class="col-auto">
    <a href="contactos/index.php" class="btn btn-dark">
      <i class="fas fa-users me-1"></i> Ver todos los contactos
    </a>
  </div>
</div>

<div class="row g-3">
  <div class="col-md-4">
    <div class="card p-4 text-center h-100">
      <div class="display-6 fw-bold" style="color:var(--color)"><?= $total ?></div>
      <div class="text-muted">Total de contactos</div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card p-4 text-center h-100">
      <div class="display-6 fw-bold" style="color:var(--color)"><?= $conTel ?></div>
      <div class="text-muted">Contactos con teléfono</div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card p-4 text-center h-100">
      <div class="display-6 fw-bold" style="color:var(--color)">
        <i class="fas fa-shield-halved"></i>
      </div>
      <div class="text-muted">PHP + PDO + MySQL</div>
    </div>
  </div>
</div>

<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
