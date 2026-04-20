<?php
/**
 * productos/index.php — Lista todos los productos
 *
 * Demuestra:
 *  - SELECT con filtro opcional (WHERE categoria = ?)
 *  - prepare() + execute() con parámetros
 *  - fetchAll() devuelve todas las filas como array
 *  - Paginación básica con LIMIT / OFFSET
 */

require_once __DIR__ . '/../config/db.php';

$titulo        = 'Catálogo de Productos';
$nivel         = 2;
$archivoActual = 'demo/productos/index.php';

// ── Parámetros de filtro y paginación ────────────────────────
$categoriaFiltro = $_GET['cat'] ?? '';
$pagina          = max(1, (int)($_GET['p'] ?? 1));
$porPagina       = 6;
$offset          = ($pagina - 1) * $porPagina;

$error    = null;
$productos = [];
$total    = 0;
$categorias = [];

try {
    $pdo = DB::conectar();

    // ── Obtener categorías para los botones de filtro ─────────
    // query() es OK porque no hay parámetros del usuario
    $categorias = $pdo
        ->query('SELECT DISTINCT categoria FROM productos ORDER BY categoria')
        ->fetchAll(PDO::FETCH_COLUMN);  // array simple de strings

    // ── Contar total (para paginación) ────────────────────────
    if ($categoriaFiltro) {
        // Con filtro: usamos prepare() + execute() con parámetro
        $stmtCount = $pdo->prepare('SELECT COUNT(*) FROM productos WHERE categoria = ?');
        $stmtCount->execute([$categoriaFiltro]);
    } else {
        $stmtCount = $pdo->query('SELECT COUNT(*) FROM productos');
    }
    $total   = $stmtCount->fetchColumn();
    $paginas = (int)ceil($total / $porPagina);

    // ── Traer los productos de esta página ────────────────────
    if ($categoriaFiltro) {
        // Parámetros posicionales: el ? se reemplaza por el valor de forma SEGURA
        $stmt = $pdo->prepare(
            'SELECT * FROM productos
              WHERE categoria = ?
              ORDER BY nombre
              LIMIT ? OFFSET ?'
        );
        // bindValue es necesario para LIMIT/OFFSET porque son enteros
        $stmt->bindValue(1, $categoriaFiltro, PDO::PARAM_STR);
        $stmt->bindValue(2, $porPagina,       PDO::PARAM_INT);
        $stmt->bindValue(3, $offset,          PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $stmt = $pdo->prepare('SELECT * FROM productos ORDER BY nombre LIMIT ? OFFSET ?');
        $stmt->bindValue(1, $porPagina, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset,    PDO::PARAM_INT);
        $stmt->execute();
    }

    $productos = $stmt->fetchAll();  // array de arrays asociativos

} catch (PDOException $e) {
    $error = 'Error al consultar la base de datos.';
}

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Título y botón -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h2 class="fw-bold mb-0">
      <i class="fas fa-box-open me-2" style="color:var(--db)"></i>
      <?= htmlspecialchars($titulo) ?>
    </h2>
    <p class="text-muted mb-0 small">
      <?= $total ?> producto<?= $total !== 1 ? 's' : '' ?> encontrado<?= $total !== 1 ? 's' : '' ?>
    </p>
  </div>
  <a href="crear.php" class="btn btn-db">
    <i class="fas fa-plus me-1"></i> Agregar
  </a>
</div>

<?php if ($error): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php else: ?>

<!-- Filtros por categoría -->
<div class="mb-4 d-flex gap-2 flex-wrap">
  <a href="index.php"
     class="btn btn-sm <?= $categoriaFiltro === '' ? 'btn-dark' : 'btn-outline-secondary' ?>">
    Todos (<?= $total ?>)
  </a>
  <?php foreach ($categorias as $cat): ?>
  <a href="?cat=<?= urlencode($cat) ?>"
     class="btn btn-sm <?= $categoriaFiltro === $cat ? 'btn-dark' : 'btn-outline-secondary' ?>">
    <?= htmlspecialchars($cat) ?>
  </a>
  <?php endforeach; ?>
</div>

<?php if (empty($productos)): ?>
  <div class="alert alert-warning">No hay productos en esta categoría.</div>
<?php else: ?>

<!-- Grid de productos -->
<div class="row g-4">
  <?php foreach ($productos as $p): ?>
  <div class="col-sm-6 col-lg-4">
    <div class="card h-100">
      <!-- Banner de categoría -->
      <div class="card-header d-flex justify-content-between align-items-center py-2"
           style="background:#1e2a35; border-bottom:none">
        <span class="badge badge-cat bg-secondary"><?= htmlspecialchars($p['categoria']) ?></span>
        <span class="badge <?= $p['stock'] > 0 ? 'bg-success' : 'bg-danger' ?>">
          <?= $p['stock'] > 0 ? 'Stock: ' . (int)$p['stock'] : 'Agotado' ?>
        </span>
      </div>
      <div class="card-body d-flex flex-column">
        <h5 class="card-title fw-bold"><?= htmlspecialchars($p['nombre']) ?></h5>
        <p class="card-text text-muted flex-grow-1" style="font-size:.88rem">
          <?= htmlspecialchars(mb_strimwidth($p['descripcion'] ?? '', 0, 90, '…')) ?>
        </p>
        <div class="precio mt-2">$<?= number_format($p['precio'], 0, ',', '.') ?></div>
      </div>
      <div class="card-footer bg-white border-top-0 d-flex gap-2">
        <a href="ver.php?id=<?= (int)$p['id'] ?>" class="btn btn-db btn-sm flex-grow-1">
          <i class="fas fa-eye me-1"></i> Ver
        </a>
        <a href="editar.php?id=<?= (int)$p['id'] ?>" class="btn btn-outline-secondary btn-sm">
          <i class="fas fa-pen"></i>
        </a>
        <a href="eliminar.php?id=<?= (int)$p['id'] ?>" class="btn btn-outline-danger btn-sm">
          <i class="fas fa-trash"></i>
        </a>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<!-- Paginación -->
<?php if ($paginas > 1): ?>
<nav class="mt-4">
  <ul class="pagination justify-content-center">
    <?php for ($i = 1; $i <= $paginas; $i++): ?>
    <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
      <a class="page-link"
         href="?cat=<?= urlencode($categoriaFiltro) ?>&p=<?= $i ?>">
        <?= $i ?>
      </a>
    </li>
    <?php endfor; ?>
  </ul>
</nav>
<?php endif; ?>

<?php endif; ?>
<?php endif; ?>

<!-- Caja educativa: SQL ejecutado -->
<div class="mt-4 alert-code p-3 rounded">
  <div class="text-secondary mb-1" style="font-size:.75rem">SQL ejecutado en esta petición:</div>
<?php if ($categoriaFiltro): ?>
  <code style="color:#f97583">SELECT * FROM productos WHERE categoria = <span style="color:#f0a356">'<?= htmlspecialchars($categoriaFiltro) ?>'</span> ORDER BY nombre LIMIT <?= $porPagina ?> OFFSET <?= $offset ?></code>
<?php else: ?>
  <code style="color:#f97583">SELECT * FROM productos ORDER BY nombre LIMIT <?= $porPagina ?> OFFSET <?= $offset ?></code>
<?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
