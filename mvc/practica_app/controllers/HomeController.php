<?php
// ============================================================
// CONTROLLER — Home
// ============================================================
// REGLA DE ORO: Solo coordina. Cero HTML, cero SQL.
// ============================================================

class HomeController
{
    // TODO 16: Implementa index().
    //   - Llama a View::render('home/index', [...])
    //   - Pasa al menos: 'titulo' => 'Bienvenido a LibroStore'
    public function index(): void
    {
        View::render('home/index', [
            'titulo' => 'Bienvenido a LibroStore'
        ]);
    }

    // TODO 17: Implementa notFound().
    //   - Envía el código HTTP 404 con http_response_code(404)
    //   - Llama a View::render('home/404', ['titulo' => 'Página no encontrada'])
    public function notFound(): void
    {
        http_response_code(404);
        View::render('home/404', ['titulo' => 'Página no encontrada']);
    }
}
