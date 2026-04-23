<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- TODO 21: El <title> debe mostrar $titulo y el nombre de la tienda
         Resultado esperado: "Cien años de soledad · LibroStore"
         Usa e() para escapar $titulo. Si no existe, usa 'Inicio' con ?? -->
    <title><?= e($titulo ?? 'Inicio') ?> · LibroStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f0f4f3; font-family: 'Segoe UI', sans-serif; }
        /* TODO 22: Agrega al menos 2 estilos propios para personalizar la app */
        .navbar-brand { letter-spacing: 1px; font-size: 1.3rem; }
        .card { border-top: 4px solid; transition: transform 0.2s, box-shadow 0.2s; }
        .card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow sticky-top">
    <div class="container">
        <!-- TODO 23: Muestra el emoji 📚 y el nombre "LibroStore" como brand -->
        <a class="navbar-brand fw-bold" href="index.php">
            📚 LibroStore
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Inicio</a>
                </li>
                <!-- TODO 24: Agrega un enlace "Catálogo" que apunte a ?c=libro&a=index -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php?c=libro&a=index">Catálogo</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
