<?php
/**
 * Arquero.php — Clase concreta que extiende Personaje
 *
 * El Arquero tiene FLECHAS como recurso y un 25% de probabilidad de CRÍTICO.
 * Muestra: propiedad adicional, lógica de probabilidad, getter específico.
 */

class Arquero extends Personaje
{
    private int $flechas;

    public function __construct(string $nombre)
    {
        parent::__construct(
            nombre:     $nombre,
            vidaMaxima: 100,   // resistencia media
            vida:       100,
            fuerza:     30,
            color:      '#27ae60'  // verde
        );
        $this->flechas = 15;
    }

    // ── Implementación abstracta ──────────────────────────────────

    /**
     * POLIMORFISMO: daño normal o daño crítico (25% de probabilidad).
     * Si no tiene flechas, solo puede dar un puñetazo débil.
     */
    public function atacar(Personaje $objetivo): int
    {
        if ($this->flechas > 0) {
            $this->flechas--;
            $critico = rand(1, 100) <= 25;  // 25% de probabilidad crítica
            $multiplicador = $critico ? 2.0 : 1.0;
            $danio = (int)(($this->fuerza * $multiplicador) + rand(0, 8));
        } else {
            // Sin flechas: golpe cuerpo a cuerpo torpe
            $danio = (int)($this->fuerza * 0.3);
        }

        $objetivo->recibirDanio($danio);
        return $danio;
    }

    public function habilidadEspecial(): string
    {
        return 'Disparo Certero (25% crítico, duplica el daño)';
    }

    public function getClase(): string { return 'Arquero'; }
    public function getIcono(): string { return 'fas fa-bow-arrow'; }

    // ── Getters propios ───────────────────────────────────────────
    public function getFlechas(): int { return $this->flechas; }

    /** Recoge flechas del suelo */
    public function recargarFlechas(int $cantidad = 5): void
    {
        $this->flechas += $cantidad;
    }
}
