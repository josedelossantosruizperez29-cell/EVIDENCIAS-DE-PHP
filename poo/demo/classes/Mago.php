<?php
/**
 * Mago.php — Clase concreta que extiende Personaje
 *
 * El Mago tiene MANÁ como recurso adicional.
 * Cuando tiene maná hace daño triple (hechizo), si no, daño mínimo.
 *
 * Muestra cómo una clase hija puede agregar propiedades y métodos propios.
 */

class Mago extends Personaje
{
    // Propiedades propias del Mago
    private int $mana;
    private int $manaMaximo;

    public function __construct(string $nombre)
    {
        parent::__construct(
            nombre:     $nombre,
            vidaMaxima: 80,    // menos vida que el guerrero
            vida:       80,
            fuerza:     22,    // fuerza base baja, pero...
            color:      '#3498db'  // azul
        );
        $this->mana = $this->manaMaximo = 120;
    }

    // ── Implementación abstracta ──────────────────────────────────

    /**
     * POLIMORFISMO: si tiene maná, lanza un hechizo (×3 de daño y +aleatorio).
     * Si no tiene maná, ataque básico débil.
     */
    public function atacar(Personaje $objetivo): int
    {
        $costeMana = 20;

        if ($this->mana >= $costeMana) {
            $this->mana -= $costeMana;
            // Hechizo: mucho más poderoso
            $danio = ($this->fuerza * 3) + rand(0, 25);
        } else {
            // Sin maná: ataque básico miserable
            $danio = $this->fuerza + rand(0, 3);
        }

        $objetivo->recibirDanio($danio);
        return $danio;
    }

    public function habilidadEspecial(): string
    {
        return 'Bola de Fuego (daño ×3, cuesta 20 de maná)';
    }

    public function getClase(): string { return 'Mago'; }
    public function getIcono(): string { return 'fas fa-wand-magic-sparkles'; }

    // ── Getters propios ───────────────────────────────────────────
    public function getMana():      int { return $this->mana; }
    public function getManaMaximo():int { return $this->manaMaximo; }

    public function getPorcentajeMana(): float
    {
        return round(($this->mana / $this->manaMaximo) * 100, 1);
    }

    /** El Mago puede meditar para recuperar maná */
    public function meditar(): void
    {
        $recuperado = rand(15, 30);
        $this->mana = min($this->manaMaximo, $this->mana + $recuperado);
    }
}
