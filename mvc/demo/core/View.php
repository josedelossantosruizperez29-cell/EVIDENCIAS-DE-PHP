<?php
// ============================================================
// VIEW HELPER — Carga el layout + la vista con sus datos
// ============================================================
// Uso desde un Controller:
//   View::render('juegos/lista', ['juegos' => $juegos]);
// ============================================================

class View
{
    /**
     * Renderiza: header + vista + footer
     *
     * @param string $vista  Ruta dentro de views/ (sin .php)
     *                       Ejemplos: 'home/index', 'juegos/lista', 'juegos/show'
     * @param array  $datos  Variables que estarán disponibles en la vista
     */
    public static function render(string $vista, array $datos = []): void
    {
        // extract() convierte ['titulo' => 'Hola'] en $titulo = 'Hola'
        // Así la vista puede usar $titulo directamente.
        extract($datos);

        $layoutDir = __DIR__ . '/../views/layout/';
        $vistaDir  = __DIR__ . '/../views/' . $vista . '.php';

        require_once $layoutDir . 'header.php';
        require_once $vistaDir;
        require_once $layoutDir . 'footer.php';
    }

    /** Escapa texto para mostrarlo seguro en HTML */
    public static function esc(mixed $valor): string
    {
        return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
    }
}

// Atajo global para no escribir View::esc() todo el tiempo en las vistas
function e(mixed $v): string { return View::esc($v); }
