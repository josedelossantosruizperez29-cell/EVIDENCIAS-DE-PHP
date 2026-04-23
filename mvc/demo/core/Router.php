<?php
// ============================================================
// ROUTER — Lee la URL y decide qué Controller ejecutar
// ============================================================
// URL pattern: index.php?c=juego&a=show&id=2
//   c = controller (juego → JuegoController)
//   a = action     (show  → método show())
// ============================================================

class Router
{
    public function despachar(): void
    {
        // Leer el nombre del controlador desde la URL
        $nombre = ucfirst(strtolower($_GET['c'] ?? 'home'));
        $clase  = $nombre . 'Controller';
        $accion = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['a'] ?? 'index');

        $archivo = __DIR__ . '/../controllers/' . $clase . '.php';

        // Si el controller no existe, usar HomeController::notFound
        if (!file_exists($archivo)) {
            $clase   = 'HomeController';
            $accion  = 'notFound';
            $archivo = __DIR__ . '/../controllers/' . $clase . '.php';
        }

        require_once $archivo;
        $controller = new $clase();

        // Verificar que el método existe en el controller
        if (!method_exists($controller, $accion)) {
            $accion = 'notFound';
        }

        // ↓ Llamar al método correspondiente
        $controller->$accion();
    }
}
