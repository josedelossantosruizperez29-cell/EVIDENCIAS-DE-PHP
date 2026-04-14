<?php
/**
 * pages/combate.php — Simulación de combate por turnos
 *
 * Demuestra:
 *  - Polimorfismo REAL: mismo método atacar(), comportamiento diferente
 *  - Estado mutable de los objetos (vida, maná, flechas cambian)
 *  - Uso de métodos heredados + métodos propios
 *  - Bucle de combate orientado a objetos
 */

require_once __DIR__ . '/../classes/Atacable.php';
require_once __DIR__ . '/../classes/Personaje.php';
require_once __DIR__ . '/../classes/Guerrero.php';
require_once __DIR__ . '/../classes/Mago.php';
require_once __DIR__ . '/../classes/Arquero.php';

$titulo             = 'Combate';
$nivel              = 2;
$archivoActual      = 'demo/pages/combate.php';
$conceptoDemostrado = 'Polimorfismo real — atacar() diferente en cada clase';

// ── Crear los combatientes ────────────────────────────────────
// Selección desde GET o combate por defecto
$claseA = $_GET['a'] ?? 'guerrero';
$claseB = $_GET['b'] ?? 'mago';

$clasesDisponibles = [
    'guerrero' => fn() => new Guerrero('Aragorn'),
    'mago'     => fn() => new Mago('Gandalf'),
    'arquero'  => fn() => new Arquero('Legolas'),
];

// Factories para crear el personaje seleccionado
$personajeA = isset($clasesDisponibles[$claseA]) ? ($clasesDisponibles[$claseA])() : new Guerrero('Aragorn');
$personajeB = isset($clasesDisponibles[$claseB]) ? ($clasesDisponibles[$claseB])() : new Mago('Gandalf');

// ── Simular el combate ────────────────────────────────────────
$log = [];      // historial de turnos
$turno = 1;
$maxTurnos = 20;

$tempA = clone $personajeA;  // clone: copia profunda del objeto
$tempB = clone $personajeB;

while ($tempA->estaVivo() && $tempB->estaVivo() && $turno <= $maxTurnos) {
    // Turno A ataca B
    $danioA = $tempA->atacar($tempB);
    $log[] = [
        'turno'     => $turno,
        'atacante'  => $tempA->getNombre(),
        'clase_a'   => $tempA->getClase(),
        'color_a'   => $tempA->getColor(),
        'icono_a'   => $tempA->getIcono(),
        'objetivo'  => $tempB->getNombre(),
        'danio'     => $danioA,
        'vida_obj'  => $tempB->getVida(),
        'max_obj'   => $tempB->getVidaMaxima(),
        'vivo_obj'  => $tempB->estaVivo(),
    ];

    if (!$tempB->estaVivo()) break;

    // Turno B ataca A
    $danioB = $tempB->atacar($tempA);
    $log[] = [
        'turno'     => $turno,
        'atacante'  => $tempB->getNombre(),
        'clase_a'   => $tempB->getClase(),
        'color_a'   => $tempB->getColor(),
        'icono_a'   => $tempB->getIcono(),
        'objetivo'  => $tempA->getNombre(),
        'danio'     => $danioB,
        'vida_obj'  => $tempA->getVida(),
        'max_obj'   => $tempA->getVidaMaxima(),
        'vivo_obj'  => $tempA->estaVivo(),
    ];

    $turno++;
}

// Determinar ganador
if ($tempA->estaVivo() && !$tempB->estaVivo()) {
    $ganador = $tempA;
} elseif ($tempB->estaVivo() && !$tempA->estaVivo()) {
    $ganador = $tempB;
} else {
    $ganador = null; // empate por turno máximo
}

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Selector de combate -->
<div class="card p-4 mb-4">
  <h5 class="fw-bold mb-3">
    <i class="fas fa-swords me-2" style="color:var(--poo2)"></i>
    Simular combate
  </h5>
  <form method="GET" action="combate.php" class="row g-3 align-items-end">
    <div class="col-sm-4">
      <label class="form-label" style="color:#94a3b8; font-size:.85rem">Combatiente A</label>
      <select name="a" class="form-select" style="background:#1a1033; color:#e2e8f0; border-color:#2d2060">
        <option value="guerrero" <?= $claseA==='guerrero'?'selected':'' ?>>⚔️ Guerrero</option>
        <option value="mago"     <?= $claseA==='mago'    ?'selected':'' ?>>🧙 Mago</option>
        <option value="arquero"  <?= $claseA==='arquero' ?'selected':'' ?>>🏹 Arquero</option>
      </select>
    </div>
    <div class="col-sm-1 text-center" style="color:var(--poo2); font-size:1.5rem; font-weight:700">VS</div>
    <div class="col-sm-4">
      <label class="form-label" style="color:#94a3b8; font-size:.85rem">Combatiente B</label>
      <select name="b" class="form-select" style="background:#1a1033; color:#e2e8f0; border-color:#2d2060">
        <option value="guerrero" <?= $claseB==='guerrero'?'selected':'' ?>>⚔️ Guerrero</option>
        <option value="mago"     <?= $claseB==='mago'    ?'selected':'' ?>>🧙 Mago</option>
        <option value="arquero"  <?= $claseB==='arquero' ?'selected':'' ?>>🏹 Arquero</option>
      </select>
    </div>
    <div class="col-sm-3">
      <button type="submit" class="btn btn-poo w-100">
        <i class="fas fa-play me-1"></i> Combatir
      </button>
    </div>
  </form>
</div>

<!-- Resultado del combate -->
<?php if ($ganador): ?>
<div class="card p-4 mb-4 text-center" style="border-color:<?= $ganador->getColor() ?>; background:<?= $ganador->getColor() ?>11">
  <div style="font-size:2.5rem">🏆</div>
  <h3 class="fw-bold mt-2" style="color:<?= $ganador->getColor() ?>">
    ¡<?= htmlspecialchars($ganador->getNombre()) ?> ganó!
  </h3>
  <p style="color:#94a3b8">
    <?= htmlspecialchars($ganador->getClase()) ?> · Vida restante:
    <?= $ganador === $tempA ? $tempA->getVida() : $tempB->getVida() ?>/<?= $ganador->getVidaMaxima() ?>
    · Duración: <?= $turno - 1 ?> turno<?= $turno > 2 ? 's' : '' ?>
  </p>
  <div class="alert-code p-2 d-inline-block rounded" style="font-size:.78rem">
    echo $ganador; → <span style="color:#56d157"><?= htmlspecialchars((string)$ganador) ?></span>
    <small style="color:#64748b"> ← __toString() automático</small>
  </div>
</div>
<?php else: ?>
<div class="alert alert-warning">¡Empate! Ambos sobrevivieron <?= $maxTurnos ?> turnos.</div>
<?php endif; ?>

<!-- Log del combate -->
<div class="card p-4">
  <h5 class="fw-bold mb-3">
    <i class="fas fa-scroll me-2" style="color:var(--poo)"></i>
    Log del combate (<?= count($log) ?> eventos)
  </h5>
  <div style="max-height:400px; overflow-y:auto">
    <?php foreach ($log as $evento): ?>
    <div class="d-flex align-items-center gap-2 mb-2 p-2 rounded"
         style="background:#0d0a1a; border-left:3px solid <?= htmlspecialchars($evento['color_a']) ?>">
      <span style="color:#475569; font-size:.72rem; min-width:55px">T<?= $evento['turno'] ?></span>
      <i class="<?= htmlspecialchars($evento['icono_a']) ?>" style="color:<?= htmlspecialchars($evento['color_a']) ?>"></i>
      <span style="font-weight:600; font-size:.88rem"><?= htmlspecialchars($evento['atacante']) ?></span>
      <span style="color:#94a3b8; font-size:.82rem">ataca a</span>
      <span style="font-size:.88rem"><?= htmlspecialchars($evento['objetivo']) ?></span>
      <span class="ms-auto fw-bold" style="color:#f59e0b">-<?= $evento['danio'] ?> HP</span>
      <div class="vida-bar" style="width:60px">
        <div class="vida-fill" style="width:<?= round(($evento['vida_obj']/$evento['max_obj'])*100) ?>%;
             background:<?= $evento['vivo_obj'] ? '#27ae60' : '#e74c3c' ?>"></div>
      </div>
      <?php if (!$evento['vivo_obj']): ?>
      <span style="color:#e74c3c; font-size:.75rem">💀 KO</span>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Explicación del polimorfismo -->
<div class="card p-4 mt-4">
  <h6 class="fw-bold mb-2" style="color:var(--poo2)">
    <i class="fas fa-lightbulb me-1"></i>
    ¿Por qué esto es POLIMORFISMO?
  </h6>
  <p style="color:#94a3b8; font-size:.88rem">
    El bucle de combate llama <code class="i">$atacante->atacar($objetivo)</code> sin saber
    si es un Guerrero, Mago o Arquero. Cada clase decide <em>cómo</em> atacar internamente.
    Mismo método, comportamiento diferente según la clase real del objeto.
  </p>
  <pre style="font-size:.8rem">
<span style="color:#8b949e">// El bucle no sabe ni le importa qué clase son:</span>
<span style="color:#ff7b72">while</span> ($tempA-><span style="color:#d2a8ff">estaVivo</span>() && $tempB-><span style="color:#d2a8ff">estaVivo</span>()) {
    $danio = $tempA-><span style="color:#d2a8ff">atacar</span>($tempB);  <span style="color:#8b949e">// puede ser Guerrero, Mago o Arquero</span>
    $danio = $tempB-><span style="color:#d2a8ff">atacar</span>($tempA);  <span style="color:#8b949e">// PHP decide en tiempo de ejecución</span>
}</pre>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
