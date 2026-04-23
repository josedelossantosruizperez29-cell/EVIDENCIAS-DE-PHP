<?php
// ============================================================
// CONTROLLER — Juego
// ============================================================
// Acciones disponibles:
//   index  → ?c=juego&a=index           lista todos
//   show   → ?c=juego&a=show&id=2       detalle de uno
//   genero → ?c=juego&a=genero&g=RPG    filtrar por género
// ============================================================

require_once __DIR__ . '/../models/Juego.php';

class JuegoController
{
    // ── Lista todos los juegos ─────────────────────────────
    public function index(): void
    {
        // 1. Pedir datos al Model
        $juegos  = Juego::todos();
        $generos = Juego::generos();

        // 2. Pasar a la View (solo datos, nada de HTML aquí)
        View::render('juegos/lista', [
            'titulo'  => 'Catálogo de Videojuegos',
            'juegos'  => $juegos,
            'generos' => $generos,
        ]);
    }

    // ── Detalle de un juego ────────────────────────────────
    public function show(): void
    {
        $id    = (int) ($_GET['id'] ?? 0);
        $juego = Juego::buscar($id);

        // Si no existe, redirigir a la página de error
        if ($juego === null) {
            header('Location: index.php?c=home&a=notFound');
            exit;
        }

        View::render('juegos/show', [
            'titulo' => e($juego['titulo']),
            'juego'  => $juego,
        ]);
    }

    // ── Filtrar por género ─────────────────────────────────
    public function genero(): void
    {
        $genero = $_GET['g'] ?? '';
        $juegos = $genero ? Juego::porGenero($genero) : Juego::todos();
        $generos = Juego::generos();

        View::render('juegos/lista', [
            'titulo'        => $genero ? "Género: $genero" : 'Todos los juegos',
            'juegos'        => $juegos,
            'generos'       => $generos,
            'generoActivo'  => $genero,
        ]);
    }
}
