<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($titulo) ? htmlspecialchars($titulo) . ' — ' : '' ?>Arena RPG · Demo POO</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    :root { --poo: #7c3aed; --poo2: #f59e0b; }
    body { background: #0f0c1a; color: #e2e8f0; font-family: 'Segoe UI', sans-serif; }
    .navbar { background: #1a1033 !important; border-bottom: 2px solid var(--poo); }
    .navbar-brand .badge-layer { background: var(--poo); font-size: .65rem; padding: 2px 7px; border-radius: 4px; }
    .card { background: #1a1033; border: 1px solid #2d2060; border-radius: 12px; }
    .card:hover { border-color: var(--poo); }
    .btn-poo { background: var(--poo); color: #fff; border: none; }
    .btn-poo:hover { background: #6d28d9; color: #fff; }
    .vida-bar  { height: 10px; border-radius: 5px; background: #2d2060; }
    .vida-fill { height: 100%; border-radius: 5px; transition: width .4s; }
    .mana-bar  { height: 6px;  border-radius: 5px; background: #1e293b; }
    .mana-fill { height: 100%; border-radius: 5px; background: #3b82f6; }
    .badge-clase { font-size: .7rem; padding: 3px 8px; border-radius: 20px; }
    code.i { background: #1e1040; color: #a78bfa; padding: 2px 6px; border-radius: 4px; font-size:.88em; }
    .alert-code { background: #0d0a1a; color: #e2e8f0; border-radius: 8px; font-family: monospace; font-size: .82rem; }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="<?= str_repeat('../', $nivel ?? 1) ?>index.php">
      <i class="fas fa-dragon" style="color:var(--poo2)"></i>
      Arena RPG
      <span class="badge-layer ms-1">Demo POO</span>
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
          <a class="nav-link" href="<?= str_repeat('../', $nivel ?? 1) ?>pages/personajes.php">
            <i class="fas fa-users me-1"></i>Personajes
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= str_repeat('../', $nivel ?? 1) ?>pages/combate.php">
            <i class="fas fa-swords me-1"></i>Combate
          </a>
        </li>
        <li class="nav-item ms-2">
          <a class="nav-link text-secondary" href="../../index.html" style="font-size:.8rem">
            <i class="fas fa-arrow-left me-1"></i>Módulo POO
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Indicador de archivo activo -->
<div style="background:#0d0a1a; border-bottom:1px solid #2d2060; font-size:.72rem; padding:4px 0">
  <div class="container d-flex gap-3 align-items-center">
    <span style="color:#6b7280">Archivo:</span>
    <code class="i"><?= htmlspecialchars($archivoActual ?? '?') ?></code>
    <span style="color:#6b7280 " class="ms-2">Concepto demostrado:</span>
    <code class="i" style="color:#a78bfa"><?= htmlspecialchars($conceptoDemostrado ?? 'POO en PHP') ?></code>
  </div>
</div>

<main class="container my-4">
