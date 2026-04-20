<?php
/**
 * config/db.php — Clase de conexión con PDO
 *
 * Patrón Singleton: garantiza UNA SOLA instancia PDO por petición.
 * Esto evita abrir muchas conexiones simultáneas a MySQL.
 *
 * ¿Qué es PDO?
 *   PHP Data Objects — interfaz genérica para bases de datos.
 *   Ventajas frente a mysqli_*:
 *     ✓ Compatible con MySQL, PostgreSQL, SQLite, etc.
 *     ✓ Prepared Statements nativos (protege de SQL Injection)
 *     ✓ API orientada a objetos, más limpia
 *     ✓ Manejo de errores con excepciones
 */

class DB
{
    // ── Configuración de conexión ──────────────────────────────
    private const HOST   = 'localhost';
    private const NOMBRE = 'sena_tienda';   // nombre de la BD
    private const USUARIO = 'root';          // cambiar en producción
    private const CLAVE   = '';              // cambiar en producción
    private const PUERTO  = '3306';

    /** Instancia única de PDO */
    private static ?PDO $conexion = null;

    /**
     * Devuelve la conexión PDO.
     * Si no existe, la crea; si ya existe, la reutiliza.
     *
     * @throws PDOException si falla la conexión
     */
    public static function conectar(): PDO
    {
        if (self::$conexion === null) {
            // DSN = Data Source Name: indica driver, host, bd y charset
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                self::HOST,
                self::PUERTO,
                self::NOMBRE
            );

            // Opciones importantes de PDO
            $opciones = [
                // Lanza PDOException en caso de error (en vez de silenciarlo)
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,

                // Las filas se devuelven como arrays asociativos por defecto
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

                // Prepared Statements reales (no emulados) → más seguro
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            // El constructor de PDO puede lanzar PDOException
            self::$conexion = new PDO($dsn, self::USUARIO, self::CLAVE, $opciones);
        }

        return self::$conexion;
    }

    // Evita crear instancias con "new DB()"
    private function __construct() {}

    // Evita clonar la instancia
    private function __clone() {}
}
