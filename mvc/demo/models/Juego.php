<?php
// ============================================================
// MODEL — Juego
// Responsabilidad: gestionar los datos de los videojuegos.
// En este ejemplo los datos son un array estático.
// En un proyecto real aquí irían las consultas PDO.
// ============================================================
// REGLA: Este archivo NO genera HTML, NO imprime nada,
//        NO conoce ni $_GET ni $_POST.
// ============================================================

class Juego
{
    private static array $catalogo = [
        [
            'id'          => 1,
            'titulo'      => 'The Legend of Zelda: Breath of the Wild',
            'genero'      => 'Aventura',
            'plataforma'  => 'Nintendo Switch',
            'anio'        => 2017,
            'calificacion'=> 9.7,
            'precio'      => 220_000,
            'descripcion' => 'Explora el reino de Hyrule en un mundo abierto lleno de secretos, rompecabezas y combates épicos contra Ganon.',
            'imagen_color'=> '#4caf50',
        ],
        [
            'id'          => 2,
            'titulo'      => 'God of War Ragnarök',
            'genero'      => 'Acción',
            'plataforma'  => 'PlayStation 5',
            'anio'        => 2022,
            'calificacion'=> 9.4,
            'precio'      => 280_000,
            'descripcion' => 'Kratos y Atreus enfrentan el inicio del Ragnarök en los nueve reinos de la mitología nórdica.',
            'imagen_color'=> '#b71c1c',
        ],
        [
            'id'          => 3,
            'titulo'      => 'Minecraft',
            'genero'      => 'Sandbox',
            'plataforma'  => 'Multiplataforma',
            'anio'        => 2011,
            'calificacion'=> 9.1,
            'precio'      => 120_000,
            'descripcion' => 'Construye, explora y sobrevive en un mundo infinito generado por procedimientos de bloques.',
            'imagen_color'=> '#795548',
        ],
        [
            'id'          => 4,
            'titulo'      => 'Elden Ring',
            'genero'      => 'RPG',
            'plataforma'  => 'PC / PS5 / Xbox',
            'anio'        => 2022,
            'calificacion'=> 9.6,
            'precio'      => 260_000,
            'descripcion' => 'Un RPG de acción en mundo abierto creado por FromSoftware y George R.R. Martin.',
            'imagen_color'=> '#fbc02d',
        ],
        [
            'id'          => 5,
            'titulo'      => 'FIFA 25',
            'genero'      => 'Deportes',
            'plataforma'  => 'Multiplataforma',
            'anio'        => 2024,
            'calificacion'=> 7.8,
            'precio'      => 200_000,
            'descripcion' => 'La última entrega de la saga de fútbol de EA Sports con gráficos y modos mejorados.',
            'imagen_color'=> '#1565c0',
        ],
        [
            'id'          => 6,
            'titulo'      => 'Hollow Knight',
            'genero'      => 'Metroidvania',
            'plataforma'  => 'PC / Switch',
            'anio'        => 2017,
            'calificacion'=> 9.0,
            'precio'      => 45_000,
            'descripcion' => 'Un juego de aventura y exploración en un vasto reino de insectos subterráneo, atmosférico y desafiante.',
            'imagen_color'=> '#37474f',
        ],
    ];

    // ── Métodos públicos (la interfaz del Model) ───────────────

    /** Devuelve todos los juegos */
    public static function todos(): array
    {
        return self::$catalogo;
    }

    /** Busca un juego por id; retorna null si no existe */
    public static function buscar(int $id): ?array
    {
        foreach (self::$catalogo as $j) {
            if ($j['id'] === $id) return $j;
        }
        return null;
    }

    /** Devuelve los juegos de un género específico */
    public static function porGenero(string $genero): array
    {
        return array_values(
            array_filter(self::$catalogo, fn($j) => $j['genero'] === $genero)
        );
    }

    /** Lista de géneros únicos */
    public static function generos(): array
    {
        return array_unique(array_column(self::$catalogo, 'genero'));
    }

    /** Formatea el precio a pesos colombianos */
    public static function formatearPrecio(int $precio): string
    {
        return '$ ' . number_format($precio, 0, ',', '.');
    }
}
