<?php
require_once __DIR__ . '/../classes/Conducible.php';
require_once __DIR__ . '/../classes/Vehiculo.php';
require_once __DIR__ . '/../classes/Auto.php';
require_once __DIR__ . '/../classes/Moto.php';
require_once __DIR__ . '/../classes/Camion.php';

$titulo = 'Flota completa';

function tipoSlug(Vehiculo $vehiculo): string
{
    return match ($vehiculo::class) {
        Auto::class => 'auto',
        Moto::class => 'moto',
        Camion::class => 'camion',
        default => 'vehiculo',
    };
}

$flota = [
    new Auto('Toyota', 'Corolla', 2022, 75000000),
    new Auto('Ford', 'Mustang', 2023, 180000000, 2),
    new Moto('Honda', 'CB500', 2021, 25000000, 500),
    new Moto('Yamaha', 'R1', 2023, 60000000, 1000),
    new Camion('Kenworth', 'T680', 2020, 450000000, 30.0, 5),
    new Camion('Volvo', 'FH16', 2024, 520000000, 28.5, 4),
];

$filtro = strtolower($_GET['tipo'] ?? '');
$flotaFiltrada = array_values(array_filter($flota, function (Vehiculo $vehiculo) use ($filtro) {
    return $filtro === '' || tipoSlug($vehiculo) === $filtro;
}));

require_once __DIR__ . '/../includes/header.php';
?>

<div class="mb-4">
  <h1 class="fw-bold mb-2">Flota completa</h1>
  <p class="text-muted mb-0">Todas las tarjetas usan los mismos métodos, sin importar la clase concreta.</p>
</div>

<div class="d-flex gap-2 flex-wrap mb-4">
  <a class="btn btn-outline-dark" href="flota.php">Todos</a>
  <a class="btn btn-outline-primary" href="flota.php?tipo=auto">Autos</a>
  <a class="btn btn-outline-warning" href="flota.php?tipo=moto">Motos</a>
  <a class="btn btn-outline-danger" href="flota.php?tipo=camion">Camiones</a>
</div>

<div class="row g-4">
<?php foreach ($flotaFiltrada as $vehiculo): ?>
  <?php
    $tipo = htmlspecialchars($vehiculo->getTipo());
    $marca = htmlspecialchars($vehiculo->getMarca());
    $modelo = htmlspecialchars($vehiculo->getModelo());
    $anio = (int) $vehiculo->getAnio();
    $precio = htmlspecialchars($vehiculo->getPrecioFormateado());
    $icono = htmlspecialchars($vehiculo->getIcono());
    $color = htmlspecialchars($vehiculo->getColor());
    $slug = htmlspecialchars(tipoSlug($vehiculo));
  ?>
  <div class="col-md-6 col-lg-4">
    <div class="card h-100 border-0" style="border-top: 5px solid <?= $color ?>;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <div class="text-uppercase small text-muted"><?= $tipo ?></div>
            <h5 class="card-title mb-0"><?= $marca ?> <?= $modelo ?></h5>
          </div>
          <i class="<?= $icono ?> fa-2x" style="color: <?= $color ?>;"></i>
        </div>

        <ul class="list-unstyled mb-3 small">
          <li><strong>Año:</strong> <?= $anio ?></li>
          <li><strong>Precio:</strong> <?= $precio ?></li>
          <li><strong>Consumo x 100 km:</strong> <?= number_format($vehiculo->consumoPor100km(), 1, ',', '.') ?> L</li>
          <li><strong>Combustible 300 km:</strong> <?= number_format($vehiculo->calcularCombustible(300), 1, ',', '.') ?> L</li>
        </ul>

        <p class="mb-3"><?= htmlspecialchars($vehiculo->arrancar()) ?></p>
        <a href="detalle.php?tipo=<?= $slug ?>" class="btn btn-sm btn-dark">Detalle</a>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

<?php if (!$flotaFiltrada): ?>
  <div class="alert alert-warning mt-4">No hay vehículos para ese filtro.</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
