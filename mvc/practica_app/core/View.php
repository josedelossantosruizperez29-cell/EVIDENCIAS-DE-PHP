<?php
// ============================================================
// VIEW HELPER — Carga el layout + la vista con sus datos
// ============================================================
// TODO 10: Implementa el método estático render().
//
// Debe:
//   1. Recibir (string $vista, array $datos = [])
//   2. Hacer extract($datos) para que las variables de $datos
//      estén disponibles como variables sueltas en la vista.
//   3. Cargar con require_once:
//        - views/layout/header.php
//        - views/{$vista}.php
//        - views/layout/footer.php
//      Usa __DIR__ para construir las rutas.
// ============================================================

class View
{
    public static function render(string $vista, array $datos = []): void
    {
        // TODO 10: tu código aquí
        extract($datos);
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/' . $vista . '.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    /** Escapa texto para mostrarlo seguro en HTML */
    public static function esc(mixed $valor): string
    {
        return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
    }
}

// Atajo global — permite escribir e($var) en las vistas
function e(mixed $v): string { return View::esc($v); }
