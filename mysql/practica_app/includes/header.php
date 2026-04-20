<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($titulo) ? htmlspecialchars($titulo) . ' — ' : '' ?>Agenda · Práctica MySQL</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    :root { --color: #00758f; }
    body { background: #f0f2f5; }
    .navbar { background: #0d1117 !important; border-bottom: 2px solid var(--color); }
    .card { border: none; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
    .btn-db { background: var(--color); color: #fff; border: none; }
    .btn-db:hover { background: #005f7a; color: #fff; }
    .badge-layer { background: var(--color); font-size: .65rem; padding: 2px 7px; border-radius: 4px; }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="<?= str_repeat('../', $nivel ?? 1) ?>index.php">
      <i class="fas fa-address-book" style="color:#56d157"></i>
      Mi Agenda
      <span class="badge-layer ms-1">Demo MySQL</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto gap-1">
        <li class="nav-item">
          <a class="nav-link" href="<?= str_repeat('../', $nivel ?? 1) ?>index.php">
            <i class="fas fa-home me-1"></i>Inicio
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= str_repeat('../', $nivel ?? 1) ?>contactos/index.php">
            <i class="fas fa-list me-1"></i>Contactos
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= str_repeat('../', $nivel ?? 1) ?>contactos/crear.php">
            <i class="fas fa-plus me-1"></i>Agregar
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="container my-4">
