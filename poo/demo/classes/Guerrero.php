<?php
/**
 * Guerrero.php — Clase concreta que EXTIENDE Personaje
 *
 * Hereda TODO de Personaje e implementa los métodos abstractos.
 * Agrega su propia propiedad: $escudos (bloqueos disponibles).
 *
 * POLIMORFISMO: atacar() aquí hace algo diferente al Mago y al Arquero.
 */

class Guerrero extends Personaje
{
    // Propiedad propia del Guerrero (no está en la clase padre)
    private int $escudos;

    public function __construct(string $nombre)
    {
        // Llama al constructor del PADRE con los valores base del Guerrero
        parent::__construct(
            nombre:     $nombre,
            vidaMaxima: 150,
            vida:       150,
            fuerza:     30,
            color:      '#e74c3c'   // rojo
        );
        $this->escudos = 3;
    }

    // ── Implementación de los métodos abstractos ──────────────────

    /** POLIMORFISMO: ataque físico fuerte, sin costo de recursos */
    public function atacar(Personaje $objetivo): int
    {
        // Daño = fuerza base + variación aleatoria
        $danio = $this->fuerza + rand(0, 10);
        $objetivo->recibirDanio($danio);
        return $danio;
    }

    public function habilidadEspecial(): string
    {
        return 'Golpe de Escudo (bloquea el 50% del siguiente ataque)';
    }

    public function getClase(): string { return 'Guerrero'; }
    public function getIcono(): string { return 'fas fa-shield-halved'; }

    // ── Getter propio ─────────────────────────────────────────────
    public function getEscudos(): int { return $this->escudos; }

    /** Usa un escudo para reducir el daño a la mitad */
    public function usarEscudo(): bool
    {
        if ($this->escudos > 0) {
            $this->escudos--;
            return true;
        }
        return false;
    }
}
