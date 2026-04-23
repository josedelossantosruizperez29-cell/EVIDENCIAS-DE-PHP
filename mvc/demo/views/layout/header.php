<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($titulo ?? 'Demo MVC') ?> · MVC Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f0f4f3; font-family: 'Segoe UI', sans-serif; }
        .navbar-brand .mvc-tag { font-size: .65rem; background: #16a085; padding: 2px 7px; border-radius: 4px; vertical-align: middle; margin-left: 6px; }
        /* Etiqueta de capa MVC que aparece en cada request */
        .layer-badge {
            position: fixed; bottom: 16px; right: 16px;
            background: #1e1e2e; color: #cdd6f4;
            border-radius: 12px; padding: 10px 16px;
            font-family: monospace; font-size: .78rem;
            box-shadow: 0 4px 16px rgba(0,0,0,.3);
            z-index: 9999; max-width: 300px;
        }
        .layer-badge .lb-row { display: flex; gap: 8px; align-items: center; margin-bottom: 3px; }
        .layer-badge .lb-row:last-child { margin-bottom: 0; }
        .lb-c { color: #f38ba8; }
        .lb-m { color: #89b4fa; }
        .lb-v { color: #cba6f7; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            🎮 GameCatalog
            <span class="mvc-tag text-white">MVC Demo</span>
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-home me-1"></i>Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?c=juego&a=index">
                        <i class="fas fa-gamepad me-1"></i>Catálogo
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="../teoria.html" target="_blank">
                        <i class="fas fa-book me-1"></i>Ver teoría
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
