<?php
$titulo = 'Flota de Vehículos';

require_once __DIR__ . '/classes/Conducible.php';
require_once __DIR__ . '/classes/Vehiculo.php';
require_once __DIR__ . '/classes/Auto.php';
require_once __DIR__ . '/classes/Moto.php';
require_once __DIR__ . '/classes/Camion.php';

$flota = [
    new Auto('Toyota', 'Corolla', 2022, 75000000),
    new Auto('Ford', 'Mustang', 2023, 180000000, 2),
    new Moto('Honda', 'CB500', 2021, 25000000, 500),
    new Moto('Yamaha', 'R1', 2023, 60000000, 1000),
    new Camion('Kenworth', 'T680', 2020, 450000000, 30.0, 5),
    new Camion('Volvo', 'FH16', 2024, 520000000, 28.5, 4),
];

$autos = 0;
$motos = 0;
$camiones = 0;

foreach ($flota as $vehiculo) {
    if ($vehiculo instanceof Auto) {
        $autos++;
    } elseif ($vehiculo instanceof Moto) {
        $motos++;
    } elseif ($vehiculo instanceof Camion) {
        $camiones++;
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="p-4 p-md-5 mb-4 bg-white rounded-4 shadow-sm">
  <div class="row align-items-center g-4">
    <div class="col-lg-8">
      <h1 class="display-6 fw-bold mb-2">Sistema de Flota Vehicular</h1>
      <p class="mb-0 text-muted">Ejercicio de POO con interface, clase abstracta, herencia y polimorfismo.</p>
    </div>
    <div class="col-lg-4">
      <div class="row g-2 text-center">
        <div class="col-4"><div class="p-3 bg-light rounded-3"><div class="fw-bold fs-4"><?= count($flota) ?></div><small>Total</small></div></div>
        <div class="col-4"><div class="p-3 bg-light rounded-3"><div class="fw-bold fs-4"><?= Vehiculo::getContador() ?></div><small>Creados</small></div></div>
        <div class="col-4"><div class="p-3 bg-light rounded-3"><div class="fw-bold fs-4"><?= $autos + $motos + $camiones ?></div><small>Check</small></div></div>
      </div>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-md-4"><div class="card p-3"><div class="fw-bold">Autos</div><div class="fs-3"><?= $autos ?></div></div></div>
  <div class="col-md-4"><div class="card p-3"><div class="fw-bold">Motos</div><div class="fs-3"><?= $motos ?></div></div></div>
  <div class="col-md-4"><div class="card p-3"><div class="fw-bold">Camiones</div><div class="fs-3"><?= $camiones ?></div></div></div>
</div>

<div class="d-flex gap-2 flex-wrap">
  <a href="pages/flota.php" class="btn btn-primary btn-lg">Ver flota completa</a>
  <a href="pages/flota.php?tipo=auto" class="btn btn-outline-primary">Autos</a>
  <a href="pages/flota.php?tipo=moto" class="btn btn-outline-warning">Motos</a>
  <a href="pages/flota.php?tipo=camion" class="btn btn-outline-danger">Camiones</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
