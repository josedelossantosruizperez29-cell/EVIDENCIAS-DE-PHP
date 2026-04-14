<?php
/**
 * pages/personajes.php — Muestra todos los personajes con sus stats
 *
 * Demuestra:
 *  - instanceof para detectar el tipo real de un objeto
 *  - Polimorfismo: mismo array, diferentes métodos disponibles
 *  - get_class() para obtener el nombre de la clase en tiempo de ejecución
 */

require_once __DIR__ . '/../classes/Atacable.php';
require_once __DIR__ . '/../classes/Personaje.php';
require_once __DIR__ . '/../classes/Guerrero.php';
require_once __DIR__ . '/../classes/Mago.php';
require_once __DIR__ . '/../classes/Arquero.php';

$titulo             = 'Personajes';
$nivel              = 2;
$archivoActual      = 'demo/pages/personajes.php';
$conceptoDemostrado = 'Herencia, instanceof, get_class()';

// Diferentes personajes — todos caben en el mismo array (son Personaje)
$personajes = [
    new Guerrero('Aragorn'),
    new Mago('Gandalf'),
    new Arquero('Legolas'),
    new Guerrero('Boromir'),
    new Mago('Saruman'),
    new Arquero('Tauriel'),
];

require_once __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="fw-bold mb-0">
      <i class="fas fa-users me-2" style="color:var(--poo)"></i>
      Personajes registrados
    </h2>
    <p style="color:#94a3b8; font-size:.87rem" class="mt-1">
      <?= count($personajes) ?> personajes · todos son instancias de clases que extienden
      <code class="i">Personaje</code>
    </p>
  </div>
  <div class="text-end">
    <div style="font-family:monospace; font-size:.78rem; color:#a78bfa">
      Personaje::getContador() → <?= Personaje::getContador() ?>
    </div>
  </div>
</div>

<div class="table-responsive">
  <table class="table" style="color:#e2e8f0; border-color:#2d2060">
    <thead style="background:#1a1033; color:#94a3b8; font-size:.82rem; text-transform:uppercase; letter-spacing:.04em">
      <tr>
        <th>Personaje</th>
        <th>Clase</th>
        <th>Vida</th>
        <th>Fuerza</th>
        <th>Recurso extra</th>
        <th>get_class()</th>
        <th>instanceof</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($personajes as $p): ?>
      <tr style="border-color:#2d2060; border-left: 3px solid <?= $p->getColor() ?>">
        <td class="fw-bold"><?= htmlspecialchars($p->getNombre()) ?></td>
        <td>
          <span style="color:<?= $p->getColor() ?>; font-size:.85rem">
            <i class="<?= $p->getIcono() ?> me-1"></i>
            <?= htmlspecialchars($p->getClase()) ?>
          </span>
        </td>
        <td>
          <div class="vida-bar" style="width:80px; display:inline-block; vertical-align:middle; margin-right:6px">
            <div class="vida-fill" style="width:<?= $p->getPorcentajeVida() ?>%; background:<?= $p->getColor() ?>"></div>
          </div>
          <small style="color:#94a3b8"><?= $p->getVida() ?>/<?= $p->getVidaMaxima() ?></small>
        </td>
        <td style="color:#f59e0b"><?= $p->getFuerza() ?></td>
        <td style="font-size:.82rem; color:#94a3b8">
          <?php if ($p instanceof Mago):    echo "💧 Maná: {$p->getMana()}"; ?>
          <?php elseif ($p instanceof Arquero): echo "🏹 Flechas: {$p->getFlechas()}"; ?>
          <?php elseif ($p instanceof Guerrero): echo "🛡 Escudos: {$p->getEscudos()}"; ?>
          <?php endif; ?>
        </td>
        <td>
          <code class="i" style="font-size:.75rem"><?= get_class($p) ?></code>
        </td>
        <td style="font-size:.75rem">
          <span style="color:<?= ($p instanceof Guerrero) ? '#56d157' : '#475569' ?>">Guerrero</span>
          <span class="mx-1 text-muted">|</span>
          <span style="color:<?= ($p instanceof Mago) ? '#56d157' : '#475569' ?>">Mago</span>
          <span class="mx-1 text-muted">|</span>
          <span style="color:<?= ($p instanceof Arquero) ? '#56d157' : '#475569' ?>">Arquero</span>
        </td>
        <td>
          <a href="detalle.php?clase=<?= strtolower($p->getClase()) ?>" class="btn btn-sm btn-poo">
            Ver
          </a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- Caja educativa -->
<div class="card p-4 mt-4">
  <h6 class="fw-bold mb-3" style="color:var(--poo2)">
    <i class="fas fa-lightbulb me-1"></i> Conceptos demostrados en esta página
  </h6>
  <div class="row g-3" style="font-size:.83rem">
    <div class="col-md-4">
      <div class="p-3 rounded" style="background:#0d0a1a; border:1px solid #2d2060">
        <div style="color:#a78bfa; font-weight:700" class="mb-1">get_class($objeto)</div>
        <div style="color:#94a3b8">Devuelve el nombre real de la clase en tiempo de ejecución.</div>
        <div style="font-family:monospace; color:#56d157; margin-top:.5rem">get_class($guerrero) → "Guerrero"</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="p-3 rounded" style="background:#0d0a1a; border:1px solid #2d2060">
        <div style="color:#a78bfa; font-weight:700" class="mb-1">$obj instanceof Clase</div>
        <div style="color:#94a3b8">Verifica si un objeto es instancia de una clase (o su hija).</div>
        <div style="font-family:monospace; color:#56d157; margin-top:.5rem">$mago instanceof Personaje → true</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="p-3 rounded" style="background:#0d0a1a; border:1px solid #2d2060">
        <div style="color:#a78bfa; font-weight:700" class="mb-1">Array polimórfico</div>
        <div style="color:#94a3b8">Todos son <code class="i">Personaje</code>, pero cada uno responde diferente a los mismos métodos.</div>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
