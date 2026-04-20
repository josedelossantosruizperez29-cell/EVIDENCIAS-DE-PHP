<?php
/**
 * config/db.php — Clase Database (práctica del estudiante)
 *
 * TODO 1: Completa la clase DB con los datos de tu entorno.
 *         Luego implementa el método estático conectar().
 *
 * AYUDA:
 *  - El DSN tiene este formato:
 *      'mysql:host=HOST;port=PUERTO;dbname=NOMBRE_BD;charset=utf8mb4'
 *  - Las opciones importantes de PDO son:
 *      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION
 *      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
 *      PDO::ATTR_EMULATE_PREPARES   => false
 *  - Si la conexión falla, PDO lanza una PDOException
 */

class DB
{
    // TODO 1a: Define las constantes de conexión
    private const HOST    = 'localhost';   // normalmente 'localhost'
    private const NOMBRE  = 'sena_contactos';   // nombre de tu BD: sena_contactos
    private const USUARIO = 'root';   // normalmente 'root'
    private const CLAVE   = '';   // en XAMPP suele estar vacío ''
    private const PUERTO  = '3306';  // puerto por defecto de MySQL

    /** @var PDO|null Instancia única (Singleton) */
    private static ?PDO $conexion = null;

    /**
     * TODO 1b: Implementa este método.
     *   - Si $conexion es null, crea una nueva instancia PDO con el DSN y las opciones
     *   - Si $conexion ya existe, devuélvela directamente
     *   - Retorna la instancia PDO
     */
    public static function conectar(): PDO
    {
        if (self::$conexion === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                self::HOST,
                self::PUERTO,
                self::NOMBRE
            );

            $opciones = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            self::$conexion = new PDO($dsn, self::USUARIO, self::CLAVE, $opciones);
        }

        return self::$conexion;
    }

    private function __construct() {}
    private function __clone()    {}
}
