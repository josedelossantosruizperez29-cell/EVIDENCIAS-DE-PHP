<?php
// ============================================================
// MODEL — Libro
// ============================================================
// REGLA DE ORO: Este archivo NO genera HTML, NO hace echo,
// NO conoce $_GET ni $_POST.
// Su único trabajo: gestionar los datos de los libros.
// ============================================================

class Libro
{
    // TODO 11: Define el array estático $catalogo con al menos 5 libros.
    // Cada libro debe tener estas claves:
    //   'id'          → entero único
    //   'titulo'      → string
    //   'autor'       → string
    //   'genero'      → string  (ej: 'Novela', 'Ciencia', 'Historia', 'Tecnología')
    //   'anio'        → entero
    //   'precio'      → entero (en pesos colombianos)
    //   'descripcion' → string
    //   'color'       → string hex (ej: '#16a085') — para el estilo de la tarjeta
    //
    // Sugerencias de libros:
    //   Cien años de soledad (García Márquez), Cosmos (Sagan),
    //   Sapiens (Harari), Clean Code (Martin), El principito (Saint-Exupéry)
    private static array $catalogo = [
        // TODO 11: agrega tus 5+ libros aquí
        [
            'id' => 1,
            'titulo' => 'Cien años de soledad',
            'autor' => 'Gabriel García Márquez',
            'genero' => 'Novela',
            'anio' => 1967,
            'precio' => 85000,
            'descripcion' => 'La historia de la familia Buendía a través de siete generaciones en el pueblo de Macondo. Una obra maestra de la literatura latinoamericana que mezcla realismo mágico con profundas reflexiones sobre la condición humana.',
            'color' => '#e74c3c'
        ],
        [
            'id' => 2,
            'titulo' => 'Cosmos',
            'autor' => 'Carl Sagan',
            'genero' => 'Ciencia',
            'anio' => 1980,
            'precio' => 72000,
            'descripcion' => 'Un viaje extraordinario por el universo que explora la ciencia, la historia, la filosofía y la esencia misma de la existencia humana. Una invitación a maravillarse con los misterios del cosmos.',
            'color' => '#3498db'
        ],
        [
            'id' => 3,
            'titulo' => 'Sapiens',
            'autor' => 'Yuval Noah Harari',
            'genero' => 'Historia',
            'anio' => 2011,
            'precio' => 95000,
            'descripcion' => 'De los primeros Homo sapiens hasta la actualidad. Harari nos cuenta cómo los humanos conquistaron el mundo mediante tres revoluciones: la cognitiva, la agrícola y la científica.',
            'color' => '#f39c12'
        ],
        [
            'id' => 4,
            'titulo' => 'Clean Code',
            'autor' => 'Robert C. Martin',
            'genero' => 'Tecnología',
            'anio' => 2008,
            'precio' => 110000,
            'descripcion' => 'Una guía práctica para escribir código limpio y mantenible. Essential para programadores que deseen mejorar su craft y crear software de calidad profesional.',
            'color' => '#16a085'
        ],
        [
            'id' => 5,
            'titulo' => 'El Principito',
            'autor' => 'Antoine de Saint-Exupéry',
            'genero' => 'Novela',
            'anio' => 1943,
            'precio' => 45000,
            'descripcion' => 'La historia de un pequeño príncipe que viaja por diferentes planetas. Una alegoría poética sobre la vida, el amor y lo importante que verdaderamente cuenta en la existencia.',
            'color' => '#9b59b6'
        ],
        [
            'id' => 6,
            'titulo' => 'El Quijote',
            'autor' => 'Miguel de Cervantes',
            'genero' => 'Novela',
            'anio' => 1605,
            'precio' => 125000,
            'descripcion' => 'Las aventuras de un hidalgo que perdió la razón leyendo libros de caballerías. Considerada la primera novela moderna y una de las obras maestras de la literatura universal.',
            'color' => '#2c3e50'
        ]
    ];

    // TODO 12: Implementa todos() — retorna todo el array $catalogo
    public static function todos(): array
    {
        return self::$catalogo;
    }

    // TODO 13: Implementa buscar($id) — retorna el libro con ese id,
    //          o null si no existe.
    //          Recorre $catalogo con foreach y compara $libro['id'] === $id
    public static function buscar(int $id): ?array
    {
        foreach (self::$catalogo as $libro) {
            if ($libro['id'] === $id) {
                return $libro;
            }
        }
        return null;
    }

    // TODO 14: Implementa porGenero($genero) — retorna solo los libros
    //          cuyo 'genero' coincida con $genero.
    //          Pista: array_filter() + array_values()
    public static function porGenero(string $genero): array
    {
        $filtrados = array_filter(self::$catalogo, function ($libro) use ($genero) {
            return $libro['genero'] === $genero;
        });
        return array_values($filtrados);
    }

    // TODO 15: Implementa generos() — retorna la lista de géneros únicos.
    //          Pista: array_unique() + array_column()
    public static function generos(): array
    {
        $generos = array_column(self::$catalogo, 'genero');
        return array_unique($generos);
    }

    // Helper: formatea precio como "$ 45.000"
    public static function formatearPrecio(int $precio): string
    {
        return '$ ' . number_format($precio, 0, ',', '.');
    }
}
