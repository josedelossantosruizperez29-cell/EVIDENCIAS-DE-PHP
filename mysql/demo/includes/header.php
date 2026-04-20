<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($titulo) ? htmlspecialchars($titulo) . ' — ' : '' ?>Tienda Gadgets · Demo MySQL</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    :root { --db: #00758f; --db2: #f29111; }
    body { background: #f8f9fa; }
    .navbar { background: #0d1117 !important; border-bottom: 2px solid var(--db); }
    .navbar-brand .badge-layer { background: var(--db); font-size: .65rem; padding: 2px 7px; border-radius: 4px; }
    .card { border: none; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
    .btn-db  { background: var(--db);  color: #fff; border: none; }
    .btn-db:hover  { background: #005f7a; color: #fff; }
    .badge-cat { font-size: .72rem; }
    .precio { font-size: 1.3rem; font-weight: 700; color: var(--db); }
    code { background: #1e2a35; color: #79c0ff; padding: 2px 6px; border-radius: 4px; font-size: .85em; }
    .alert-code { background: #1e2a35; color: #e6edf3; border-radius: 8px; font-family: monospace; font-size: .82rem; }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="<?= str_repeat('../', $nivel ?? 1) ?>index.php">
      <i class="fas fa-store" style="color:var(--db2)"></i>
      Tienda Gadgets
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
          <a class="nav-link" href="<?= str_repeat('../', $nivel ?? 1) ?>productos/index.php">
            <i class="fas fa-list me-1"></i>Productos
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= str_repeat('../', $nivel ?? 1) ?>productos/crear.php">
            <i class="fas fa-plus me-1"></i>Agregar
          </a>
        </li>
        <li class="nav-item ms-2">
          <a class="nav-link text-secondary" href="../../index.html" style="font-size:.8rem">
            <i class="fas fa-arrow-left me-1"></i>Módulo MySQL
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- INDICADOR DE CAPA (educativo) -->
<div style="background:#0d1117; border-bottom:1px solid #30363d; font-size:.72rem; padding:4px 0">
  <div class="container d-flex gap-3 align-items-center">
    <span class="text-secondary">Archivo activo:</span>
    <code style="color:#79c0ff"><?= htmlspecialchars($archivoActual ?? '?') ?></code>
    <span class="text-secondary ms-2">Conexión:</span>
    <code style="color:#56d157">PDO → MySQL (sena_tienda)</code>
  </div>
</div>

<main class="container my-4">
