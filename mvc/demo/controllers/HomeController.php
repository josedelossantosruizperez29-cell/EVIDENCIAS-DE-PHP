<?php
// ============================================================
// CONTROLLER — Home
// ============================================================
// REGLA: Solo coordina. No genera HTML, no consulta BD.
// ============================================================

class HomeController
{
    public function index(): void
    {
        // Pasa datos básicos a la vista
        View::render('home/index', [
            'titulo'  => 'Bienvenido al Catálogo MVC',
        ]);
    }

    public function notFound(): void
    {
        http_response_code(404);
        View::render('home/404', [
            'titulo' => 'Página no encontrada',
        ]);
    }
}
