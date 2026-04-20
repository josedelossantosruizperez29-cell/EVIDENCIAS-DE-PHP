<?php
/**
 * contactos/index.php — Lista todos los contactos
 *
 * TODO 6: Carga config/db.php con require_once (ruta correcta: __DIR__ . '/../config/db.php')
 * TODO 7: Obtén el filtro de categoría desde $_GET['cat'] (usa '' si no existe)
 * TODO 8: En un bloque try/catch:
 *           a) Conecta con DB::conectar()
 *           b) Obtén la lista de categorías únicas:
 *                SELECT DISTINCT categoria FROM contactos ORDER BY categoria
 *                Usa fetchAll(PDO::FETCH_COLUMN) para tener un array simple
 *           c) Si hay filtro de categoría:
 *                SELECT * FROM contactos WHERE categoria = ? ORDER BY nombre
 *                Usa prepare() y execute([$categoriaFiltro])
 *              Si no hay filtro:
 *                SELECT * FROM contactos ORDER BY nombre
 *                Puedes usar query()
 *           d) Usa fetchAll() para traer todos los contactos a $contactos
 *           e) Si hay PDOException, guarda en $error
 */

// TODO 6:
require_once __DIR__ . '/../config/db.php';
$titulo        = 'Mis Contactos';
$nivel         = 2;
$archivoActual = 'practica_app/contactos/index.php';

// TODO 7:
$categoriaFiltro = $_GET['cat'] ?? '';
$error           = null;
$contactos       = [];
$categorias      = [];

// TODO 8:
try {
    $pdo = DB::conectar();
    $categorias = $pdo->query('SELECT DISTINCT categoria FROM contactos ORDER BY categoria')->fetchAll(PDO::FETCH_COLUMN);

    if ($categoriaFiltro !== '') {
        $stmt = $pdo->prepare('SELECT * FROM contactos WHERE categoria = ? ORDER BY nombre');
        $stmt->execute([$categoriaFiltro]);
    } else {
        $stmt = $pdo->query('SELECT * FROM contactos ORDER BY nombre');
    }

    $contactos = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = $e->getMessage();
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
  <div>
    <h1 class="fw-bold mb-1"><i class="fas fa-address-book me-2" style="color:var(--color)"></i>Mis Contactos</h1>
    <p class="text-muted mb-0">Lista completa de contactos almacenados en la base de datos.</p>
  </div>
  <a href="crear.php" class="btn btn-db">
    <i class="fas fa-plus me-1"></i> Agregar contacto
  </a>
</div>

<div class="mb-4 d-flex flex-wrap gap-2">
  <a href="index.php" class="btn btn-sm <?= $categoriaFiltro === '' ? 'btn-dark' : 'btn-outline-dark' ?>">Todos</a>
  <?php foreach ($categorias as $categoria): ?>
    <?php $activo = $categoriaFiltro === $categoria; ?>
    <a href="?cat=<?= urlencode($categoria) ?>" class="btn btn-sm <?= $activo ? 'btn-dark' : 'btn-outline-dark' ?>">
      <?= htmlspecialchars($categoria) ?>
    </a>
  <?php endforeach; ?>
</div>

<?php if ($error): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php elseif (empty($contactos)): ?>
  <div class="alert alert-warning mb-0">No hay contactos registrados.</div>
<?php else: ?>

<div class="row g-4">
  <?php foreach ($contactos as $contacto): ?>
    <div class="col-sm-6 col-lg-4">
      <div class="card h-100">
        <div class="card-body">
          <span class="badge bg-primary mb-3"><?= htmlspecialchars($contacto['categoria']) ?></span>
          <h5 class="card-title mb-2"><?= htmlspecialchars($contacto['nombre']) ?></h5>
          <p class="mb-1"><i class="fas fa-envelope me-1"></i> <?= htmlspecialchars($contacto['email']) ?></p>
          <p class="mb-3">
            <i class="fas fa-phone me-1"></i>
            <?php if (!empty($contacto['telefono'])): ?>
              <?= htmlspecialchars($contacto['telefono']) ?>
            <?php else: ?>
              <span class="text-muted">Sin teléfono</span>
            <?php endif; ?>
          </p>
          <div class="d-flex flex-wrap gap-2">
            <a href="ver.php?id=<?= (int) $contacto['id'] ?>" class="btn btn-sm btn-db">
              <i class="fas fa-eye me-1"></i> Ver
            </a>
            <a href="editar.php?id=<?= (int) $contacto['id'] ?>" class="btn btn-sm btn-outline-primary">
              <i class="fas fa-pen"></i>
            </a>
            <a href="eliminar.php?id=<?= (int) $contacto['id'] ?>" class="btn btn-sm btn-outline-danger">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
