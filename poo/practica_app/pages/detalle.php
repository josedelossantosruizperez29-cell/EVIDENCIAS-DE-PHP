<?php
require_once __DIR__ . '/../classes/Conducible.php';
require_once __DIR__ . '/../classes/Vehiculo.php';
require_once __DIR__ . '/../classes/Auto.php';
require_once __DIR__ . '/../classes/Moto.php';
require_once __DIR__ . '/../classes/Camion.php';

$titulo = 'Detalle del vehículo';

$tipo = strtolower($_GET['tipo'] ?? '');

$vehiculo = match ($tipo) {
    'auto' => new Auto('Toyota', 'Corolla', 2022, 75000000, 4),
    'moto' => new Moto('Honda', 'CB500', 2021, 25000000, 500),
    'camion' => new Camion('Kenworth', 'T680', 2020, 450000000, 30.0, 5),
    default => null,
};

if (!$vehiculo) {
    header('Location: flota.php');
    exit;
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="row g-4">
  <div class="col-lg-8">
    <div class="card p-4">
      <div class="d-flex align-items-center gap-3 mb-3">
        <i class="<?= htmlspecialchars($vehiculo->getIcono()) ?> fa-3x" style="color: <?= htmlspecialchars($vehiculo->getColor()) ?>;"></i>
        <div>
          <h1 class="h3 mb-1"><?= htmlspecialchars($vehiculo->getTipo()) ?>: <?= htmlspecialchars($vehiculo->getMarca()) ?> <?= htmlspecialchars($vehiculo->getModelo()) ?></h1>
          <div class="text-muted"><?= htmlspecialchars((string) $vehiculo) ?></div>
        </div>
      </div>

      <div class="row g-3 mb-4">
        <div class="col-md-6"><div class="p-3 bg-light rounded-3"><strong>Año:</strong> <?= (int) $vehiculo->getAnio() ?></div></div>
        <div class="col-md-6"><div class="p-3 bg-light rounded-3"><strong>Precio:</strong> <?= htmlspecialchars($vehiculo->getPrecioFormateado()) ?></div></div>
        <div class="col-md-6"><div class="p-3 bg-light rounded-3"><strong>Consumo:</strong> <?= number_format($vehiculo->consumoPor100km(), 1, ',', '.') ?> L/100km</div></div>
        <div class="col-md-6"><div class="p-3 bg-light rounded-3"><strong>Contador total:</strong> <?= Vehiculo::getContador() ?></div></div>
      </div>

      <h2 class="h5">Arranque y frenado</h2>
      <p><?= htmlspecialchars($vehiculo->arrancar()) ?></p>
      <p><?= htmlspecialchars($vehiculo->frenar()) ?></p>

      <h2 class="h5 mt-4">Combustible por distancia</h2>
      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead>
            <tr>
              <th>Km</th>
              <th>Litros</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ([100, 300, 500, 1000] as $km): ?>
            <tr>
              <td><?= $km ?></td>
              <td><?= number_format($vehiculo->calcularCombustible($km), 1, ',', '.') ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="alert alert-secondary mt-3 mb-0">
        <strong>__toString():</strong> <?= htmlspecialchars((string) $vehiculo) ?>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card p-4 mb-4">
      <h2 class="h5">Datos específicos</h2>
      <?php if ($vehiculo instanceof Auto): ?>
        <p class="mb-1"><strong>Puertas:</strong> <?= $vehiculo->getPuertas() ?></p>
      <?php elseif ($vehiculo instanceof Moto): ?>
        <p class="mb-1"><strong>Cilindrada:</strong> <?= $vehiculo->getCilindrada() ?> cc</p>
      <?php elseif ($vehiculo instanceof Camion): ?>
        <p class="mb-1"><strong>Capacidad:</strong> <?= number_format($vehiculo->getCapacidadTon(), 1, ',', '.') ?> toneladas</p>
        <p class="mb-0"><strong>Ejes:</strong> <?= $vehiculo->getEjes() ?></p>
      <?php endif; ?>
    </div>

    <a href="flota.php" class="btn btn-dark w-100">Volver a la flota</a>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
