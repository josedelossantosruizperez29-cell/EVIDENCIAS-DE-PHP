<?php
/**
 * demo/index.php — Página de inicio de la Arena RPG
 *
 * Demuestra:
 *  - Instanciar objetos de clases hijas (new Guerrero, new Mago, new Arquero)
 *  - Uso de métodos heredados y propios
 *  - Propiedad estática: Personaje::getContador()
 *  - Magic method __toString (echo $personaje)
 *  - Polimorfismo: mismo método, diferente resultado por clase
 */

// ── Cargar todas las clases ───────────────────────────────────
// En un proyecto real usarías Composer/autoload
require_once __DIR__ . '/classes/Atacable.php';
require_once __DIR__ . '/classes/Personaje.php';
require_once __DIR__ . '/classes/Guerrero.php';
require_once __DIR__ . '/classes/Mago.php';
require_once __DIR__ . '/classes/Arquero.php';

$titulo              = 'Arena RPG';
$nivel               = 1;
$archivoActual       = 'demo/index.php';
$conceptoDemostrado  = 'Instanciar objetos, static, __toString';

// ── Crear objetos (instanciar clases) ─────────────────────────
$guerrero = new Guerrero('Aragorn');
$mago     = new Mago('Gandalf');
$arquero  = new Arquero('Legolas');

// getContador() es ESTÁTICO → se llama en la clase, no en el objeto
$totalPersonajes = Personaje::getContador();

// Los personajes en un array (todos son tipo Personaje por herencia)
$personajes = [$guerrero, $mago, $arquero];

require_once __DIR__ . '/includes/header.php';
?>

<!-- ENCABEZADO -->
<div class="row align-items-center mb-5">
  <div class="col-lg-8">
    <h1 class="fw-bold display-5 mb-2">
      <i class="fas fa-dragon me-2" style="color:var(--poo2)"></i>
      Arena de Combate RPG
    </h1>
    <p class="mb-0" style="color:#94a3b8">
      Tres clases PHP representan a los personajes.
      Todas heredan de <code class="i">Personaje</code> (clase abstracta) e implementan
      <code class="i">Atacable</code> (interface) — pero cada una ataca de forma distinta.
    </p>
  </div>
  <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
    <div class="card p-3 d-inline-block text-center">
      <div class="display-5 fw-bold" style="color:var(--poo2)"><?= $totalPersonajes ?></div>
      <div style="color:#94a3b8; font-size:.85rem">Personajes creados</div>
      <div style="font-family:monospace; font-size:.75rem; color:#a78bfa" class="mt-1">
        Personaje::getContador() → <?= $totalPersonajes ?>
      </div>
    </div>
  </div>
</div>

<!-- TARJETAS DE PERSONAJES -->
<div class="row g-4 mb-5">
  <?php foreach ($personajes as $p): ?>
  <div class="col-md-4">
    <div class="card p-4 h-100" style="border-top: 3px solid <?= $p->getColor() ?>">
      <!-- Clase e ícono -->
      <div class="d-flex justify-content-between align-items-start mb-3">
        <span class="badge-clase" style="background:<?= $p->getColor() ?>22; color:<?= $p->getColor() ?>; border:1px solid <?= $p->getColor() ?>55">
          <i class="<?= $p->getIcono() ?> me-1"></i>
          <?= htmlspecialchars($p->getClase()) ?>
        </span>
        <i class="<?= $p->getIcono() ?> fa-2x" style="color:<?= $p->getColor() ?>; opacity:.5"></i>
      </div>

      <!-- Nombre (getters del encapsulamiento) -->
      <h4 class="fw-bold mb-3"><?= htmlspecialchars($p->getNombre()) ?></h4>

      <!-- Barra de vida -->
      <div class="mb-1 d-flex justify-content-between" style="font-size:.8rem; color:#94a3b8">
        <span><i class="fas fa-heart me-1" style="color:#e74c3c"></i>Vida</span>
        <span><?= $p->getVida() ?>/<?= $p->getVidaMaxima() ?></span>
      </div>
      <div class="vida-bar mb-3">
        <div class="vida-fill" style="width:<?= $p->getPorcentajeVida() ?>%; background:<?= $p->getColor() ?>"></div>
      </div>

      <!-- Recursos especiales por clase -->
      <?php if ($p instanceof Mago): ?>
      <div class="mb-1 d-flex justify-content-between" style="font-size:.8rem; color:#94a3b8">
        <span><i class="fas fa-flask me-1" style="color:#3b82f6"></i>Maná</span>
        <span><?= $p->getMana() ?>/<?= $p->getManaMaximo() ?></span>
      </div>
      <div class="mana-bar mb-3">
        <div class="mana-fill" style="width:<?= $p->getPorcentajeMana() ?>%"></div>
      </div>
      <?php elseif ($p instanceof Arquero): ?>
      <div class="mb-3" style="font-size:.8rem; color:#94a3b8">
        <i class="fas fa-bullseye me-1" style="color:#27ae60"></i>
        Flechas: <strong style="color:#e2e8f0"><?= $p->getFlechas() ?></strong>
      </div>
      <?php elseif ($p instanceof Guerrero): ?>
      <div class="mb-3" style="font-size:.8rem; color:#94a3b8">
        <i class="fas fa-shield-halved me-1" style="color:#e74c3c"></i>
        Escudos: <strong style="color:#e2e8f0"><?= $p->getEscudos() ?></strong>
      </div>
      <?php endif; ?>

      <!-- Habilidad especial -->
      <div class="p-2 rounded mb-3" style="background:#0d0a1a; font-size:.78rem; color:#a78bfa">
        <i class="fas fa-star me-1"></i>
        <?= htmlspecialchars($p->habilidadEspecial()) ?>
      </div>

      <!-- __toString en acción -->
      <div class="alert-code p-2 rounded" style="font-size:.75rem; color:#6b7280">
        <span style="color:#6b7280">echo $<?= strtolower($p->getClase()) ?>; →</span>
        <br><span style="color:#56d157"><?= htmlspecialchars((string)$p) ?></span>
      </div>

      <a href="pages/detalle.php?clase=<?= strtolower($p->getClase()) ?>"
         class="btn btn-poo btn-sm mt-3 w-100">
        <i class="fas fa-eye me-1"></i> Ver detalle de clase
      </a>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<!-- DIAGRAMA DE HERENCIA -->
<div class="card p-4 mb-4">
  <h5 class="fw-bold mb-3">
    <i class="fas fa-diagram-project me-2" style="color:var(--poo)"></i>
    Jerarquía de clases de esta demo
  </h5>
  <div style="font-family:monospace; font-size:.83rem; background:#0d0a1a; border-radius:8px; padding:1.2rem; line-height:2">
    <span style="color:#64748b">«interface»</span>
    <span style="color:#a78bfa; font-weight:700"> Atacable</span>
    <span style="color:#64748b"> { atacar(), recibirDanio() }</span>
    <br>
    <span style="color:#94a3b8">       ↑ implements</span>
    <br>
    <span style="color:#64748b">«abstract»</span>
    <span style="color:#f59e0b; font-weight:700"> Personaje</span>
    <span style="color:#64748b"> { nombre, vida, fuerza, getContador()*, __toString() }</span>
    <br>
    <span style="color:#94a3b8">    ┌──────↑──────┐──────┐</span>
    <br>
    <span style="color:#e74c3c; font-weight:700">Guerrero</span>
    <span style="color:#94a3b8">       </span>
    <span style="color:#3b82f6; font-weight:700">Mago</span>
    <span style="color:#94a3b8">         </span>
    <span style="color:#27ae60; font-weight:700">Arquero</span>
    <br>
    <span style="color:#64748b">+escudos       +mana          +flechas</span>
    <br>
    <span style="color:#64748b; font-size:.75rem">* método estático → Personaje::getContador()</span>
  </div>
</div>

<!-- POLIMORFISMO: mismo método, resultados distintos -->
<div class="card p-4">
  <h5 class="fw-bold mb-3">
    <i class="fas fa-shuffle me-2" style="color:var(--poo2)"></i>
    Polimorfismo en acción — <code class="i">atacar()</code> es diferente en cada clase
  </h5>
  <div class="row g-3">
    <?php
    // Crear un blanco para demostrar los ataques
    $blanco = new Guerrero('Maniquí');

    foreach ($personajes as $atacante):
        $blanco2 = new Guerrero('Blanco');  // blanco fresco para cada uno
        $danio = $atacante->atacar($blanco2);
    ?>
    <div class="col-md-4">
      <div class="alert-code p-3 rounded">
        <div style="color:#64748b; font-size:.72rem; margin-bottom:.4rem">
          $<?= strtolower($atacante->getClase()) ?>->atacar($blanco)
        </div>
        <div style="color:<?= $atacante->getColor() ?>; font-size:1.2rem; font-weight:700">
          -<?= $danio ?> HP
        </div>
        <div style="color:#64748b; font-size:.75rem; margin-top:.3rem">
          <?php
            if ($atacante instanceof Mago) echo 'Hechizo de fuego';
            elseif ($atacante instanceof Arquero) echo 'Disparo (posible crítico)';
            else echo 'Golpe físico directo';
          ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <div class="mt-3 text-center">
    <a href="pages/combate.php" class="btn btn-poo">
      <i class="fas fa-swords me-1"></i> Simular combate completo
    </a>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
