<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($titulo) ? htmlspecialchars($titulo) . ' — ' : '' ?>Flota · Práctica POO</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    :root { --color: #0f172a; }
    body { background: #f0f2f5; }
    .navbar { background: var(--color) !important; }
    .card { border: none; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
    code.i { background: #1e2a35; color: #79c0ff; padding: 2px 6px; border-radius: 4px; font-size:.88em; }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/practica_app/index.php">Transporte Andes</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navFlota">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navFlota">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item"><a class="nav-link" href="/practica_app/index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="/practica_app/pages/flota.php">Flota</a></li>
        <li class="nav-item"><a class="nav-link" href="/practica_app/pages/flota.php?tipo=auto">Autos</a></li>
        <li class="nav-item"><a class="nav-link" href="/practica_app/pages/flota.php?tipo=moto">Motos</a></li>
        <li class="nav-item"><a class="nav-link" href="/practica_app/pages/flota.php?tipo=camion">Camiones</a></li>
        <li class="nav-item ms-lg-2">
          <span class="badge bg-warning text-dark px-3 py-2">POO Demo</span>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="container my-4">
