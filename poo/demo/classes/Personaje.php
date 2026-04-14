<?php
/**
 * Personaje.php — Clase ABSTRACTA base
 *
 * Una clase ABSTRACTA:
 *   ✓ Puede tener propiedades, métodos concretos y métodos abstractos
 *   ✗ NO se puede instanciar directamente (no puedes hacer: new Personaje())
 *   → Sirve como molde para las clases hijas (Guerrero, Mago, Arquero)
 *
 * Implementa la interface Atacable → HEREDA la obligación de sus métodos.
 */

abstract class Personaje implements Atacable
{
    // ── Propiedad ESTÁTICA (compartida por TODOS los personajes) ──
    // No pertenece a una instancia sino a la CLASE misma
    private static int $contadorPersonajes = 0;

    // ── Constructor con PROMOTION de PHP 8 ────────────────────────
    // "protected" en los parámetros crea las propiedades automáticamente
    public function __construct(
        protected string $nombre,
        protected int    $vidaMaxima,
        protected int    $vida,
        protected int    $fuerza,
        protected string $color   // color visual del personaje
    ) {
        self::$contadorPersonajes++;  // incrementa el contador de clase
    }

    // ── Métodos ABSTRACTOS: las hijas DEBEN implementarlos ────────
    abstract public function habilidadEspecial(): string;
    abstract public function getClase(): string;
    abstract public function getIcono(): string;

    // ── Métodos CONCRETOS (heredados por todas las hijas) ─────────

    public function estaVivo(): bool
    {
        return $this->vida > 0;
    }

    /** Implementación del contrato Atacable */
    public function recibirDanio(int $danio): void
    {
        $this->vida = max(0, $this->vida - $danio);
    }

    public function curar(int $cantidad): void
    {
        $this->vida = min($this->vidaMaxima, $this->vida + $cantidad);
    }

    public function getPorcentajeVida(): float
    {
        return round(($this->vida / $this->vidaMaxima) * 100, 1);
    }

    // ── Getters (ENCAPSULAMIENTO: las propiedades son protected) ──
    public function getNombre():    string { return $this->nombre; }
    public function getVida():      int    { return $this->vida; }
    public function getVidaMaxima():int    { return $this->vidaMaxima; }
    public function getFuerza():    int    { return $this->fuerza; }
    public function getColor():     string { return $this->color; }

    // ── Método ESTÁTICO: se llama en la clase, no en la instancia ─
    // Personaje::getContador() en lugar de $personaje->getContador()
    public static function getContador(): int
    {
        return self::$contadorPersonajes;
    }

    // ── Magic method __toString ────────────────────────────────────
    // Se invoca automáticamente cuando el objeto se usa como string
    // Ejemplo: echo $guerrero; → "[Guerrero] Aragorn (HP: 150/150)"
    public function __toString(): string
    {
        return sprintf(
            '[%s] %s (HP: %d/%d)',
            $this->getClase(),
            $this->nombre,
            $this->vida,
            $this->vidaMaxima
        );
    }
}
