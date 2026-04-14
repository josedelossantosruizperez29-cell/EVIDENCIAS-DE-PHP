<?php
/**
 * pages/detalle.php — Detalle de una clase (código comentado en vivo)
 *
 * Demuestra cómo inspeccionar un objeto en tiempo de ejecución con
 * ReflectionClass y muestra el código fuente de la clase seleccionada.
 */

require_once __DIR__ . '/../classes/Atacable.php';
require_once __DIR__ . '/../classes/Personaje.php';
require_once __DIR__ . '/../classes/Guerrero.php';
require_once __DIR__ . '/../classes/Mago.php';
require_once __DIR__ . '/../classes/Arquero.php';

$claseParam = $_GET['clase'] ?? 'guerrero';

$mapeo = [
    'guerrero' => ['clase' => 'Guerrero', 'obj' => new Guerrero('Demo'),   'archivo' => 'Guerrero.php'],
    'mago'     => ['clase' => 'Mago',     'obj' => new Mago('Demo'),       'archivo' => 'Mago.php'],
    'arquero'  => ['clase' => 'Arquero',  'obj' => new Arquero('Demo'),    'archivo' => 'Arquero.php'],
];

if (!isset($mapeo[$claseParam])) {
    header('Location: personajes.php');
    exit;
}

['clase' => $nombreClase, 'obj' => $obj, 'archivo' => $archivo] = $mapeo[$claseParam];

$titulo             = "Clase $nombreClase";
$nivel              = 2;
$archivoActual      = 'demo/pages/detalle.php';
$conceptoDemostrado = 'Reflexión de clases — métodos, propiedades, jerarquía';

// Reflexión (PHP puede inspeccionar sus propias clases)
$ref     = new ReflectionClass($obj);
$metodos = $ref->getMethods(ReflectionMethod::IS_PUBLIC);
$padre   = $ref->getParentClass();
$interfaces = $ref->getInterfaceNames();

// Código fuente de la clase
$codigoFuente = file_get_contents(__DIR__ . '/../classes/' . $archivo);

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Navegación de clases -->
<div class="d-flex gap-2 mb-4">
  <?php foreach ($mapeo as $slug => $info): ?>
  <a href="?clase=<?= $slug ?>"
     class="btn btn-sm <?= $slug === $claseParam ? 'btn-poo' : 'btn-outline-secondary' ?>">
    <?= htmlspecialchars($info['clase']) ?>
  </a>
  <?php endforeach; ?>
  <a href="../index.php" class="btn btn-sm btn-outline-secondary ms-auto">
    ← Inicio
  </a>
</div>

<div class="row g-4">
  <!-- Info de la clase -->
  <div class="col-lg-4">
    <div class="card p-4 mb-4" style="border-color:<?= $obj->getColor() ?>">
      <div class="text-center mb-3">
        <i class="<?= $obj->getIcono() ?> fa-3x" style="color:<?= $obj->getColor() ?>"></i>
      </div>
      <h3 class="fw-bold text-center mb-1"><?= htmlspecialchars($nombreClase) ?></h3>

      <hr style="border-color:#2d2060">

      <div style="font-size:.83rem">
        <div class="mb-2">
          <span style="color:#94a3b8">Clase padre:</span>
          <code class="i ms-1"><?= $padre ? $padre->getName() : 'ninguno' ?></code>
        </div>
        <div class="mb-2">
          <span style="color:#94a3b8">Interfaces:</span>
          <?php foreach ($interfaces as $iface): ?>
          <code class="i ms-1"><?= htmlspecialchars($iface) ?></code>
          <?php endforeach; ?>
        </div>
        <div class="mb-2">
          <span style="color:#94a3b8">¿Abstracta?</span>
          <span class="ms-1" style="color:<?= $ref->isAbstract() ? '#f59e0b' : '#56d157' ?>">
            <?= $ref->isAbstract() ? 'Sí' : 'No' ?>
          </span>
        </div>
        <div class="mb-2">
          <span style="color:#94a3b8">Métodos públicos:</span>
          <strong class="ms-1"><?= count($metodos) ?></strong>
        </div>
      </div>

      <hr style="border-color:#2d2060">

      <!-- Habilidad especial -->
      <div class="p-2 rounded" style="background:#0d0a1a; font-size:.8rem; color:#a78bfa">
        <i class="fas fa-star me-1"></i>
        <?= htmlspecialchars($obj->habilidadEspecial()) ?>
      </div>

      <!-- Stats visuales -->
      <div class="mt-3">
        <div class="d-flex justify-content-between mb-1" style="font-size:.78rem; color:#94a3b8">
          <span>❤️ Vida</span><span><?= $obj->getVidaMaxima() ?></span>
        </div>
        <div class="vida-bar mb-2">
          <div class="vida-fill" style="width:<?= $obj->getPorcentajeVida() ?>%; background:<?= $obj->getColor() ?>"></div>
        </div>
        <div class="d-flex justify-content-between mb-1" style="font-size:.78rem; color:#94a3b8">
          <span>⚔️ Fuerza base</span><span><?= $obj->getFuerza() ?></span>
        </div>
      </div>
    </div>

    <!-- Lista de métodos -->
    <div class="card p-4">
      <h6 class="fw-bold mb-3" style="color:#94a3b8; font-size:.8rem; text-transform:uppercase; letter-spacing:.06em">
        Métodos públicos (via Reflection)
      </h6>
      <?php foreach ($metodos as $m): ?>
      <div class="d-flex justify-content-between align-items-center mb-1" style="font-size:.78rem; border-bottom:1px solid #1a1033; padding-bottom:4px">
        <code class="i" style="font-size:.75rem"><?= htmlspecialchars($m->getName()) ?>()</code>
        <span style="color:<?= $m->getDeclaringClass()->getName() === $nombreClase ? $obj->getColor() : '#475569' ?>; font-size:.7rem">
          <?= $m->getDeclaringClass()->getName() ?>
        </span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Código fuente comentado -->
  <div class="col-lg-8">
    <div class="card p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">
          <i class="fas fa-code me-2" style="color:var(--poo)"></i>
          Código fuente: <code class="i"><?= htmlspecialchars($archivo) ?></code>
        </h5>
        <span style="color:#475569; font-size:.75rem">
          <?= count(explode("\n", $codigoFuente)) ?> líneas
        </span>
      </div>
      <pre style="max-height:600px; overflow-y:auto"><?= htmlspecialchars($codigoFuente) ?></pre>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
