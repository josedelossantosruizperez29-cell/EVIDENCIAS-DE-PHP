<?php
// ============================================================
// ROUTER — Lee la URL y despacha al Controller correcto
// ============================================================
// Patrón de URL:  index.php?c=libro&a=show&id=2
//   $_GET['c']  →  nombre del controller  (libro → LibroController)
//   $_GET['a']  →  nombre del método      (show  → show())
// ============================================================

class Router
{
    public function despachar(): void
    {
        // TODO 4: Lee $_GET['c'], si no existe usa 'home' como valor por defecto.
        //         Construye el nombre de la clase: ucfirst($nombre) . 'Controller'
        //         Ejemplo: 'libro' → 'LibroController'
        $c = $_GET['c'] ?? 'home';
        $clase = ucfirst($c) . 'Controller';

        // TODO 5: Lee $_GET['a'], si no existe usa 'index' como valor por defecto.
        //         Limpia el valor con: preg_replace('/[^a-zA-Z0-9_]/', '', $valor)
        $a = $_GET['a'] ?? 'index';
        $accion = preg_replace('/[^a-zA-Z0-9_]/', '', $a);

        // TODO 6: Construye la ruta al archivo del controller usando __DIR__
        //         Está en: ../controllers/{$clase}.php
        $archivo = __DIR__ . '/../controllers/' . $clase . '.php';

        // TODO 7: Si el archivo NO existe, usa 'HomeController' y acción 'notFound'
        //         Actualiza $clase, $accion y $archivo
        if (!file_exists($archivo)) {
            $clase = 'HomeController';
            $accion = 'notFound';
            $archivo = __DIR__ . '/../controllers/HomeController.php';
        }

        // TODO 8: Carga el archivo del controller con require_once
        require_once $archivo;

        // TODO 9: Crea una instancia de la clase ($clase) y llama al método ($accion)
        //         Pista: $obj = new $clase(); luego $obj->$accion();
        $obj = new $clase();
        $obj->$accion();
    }
}
