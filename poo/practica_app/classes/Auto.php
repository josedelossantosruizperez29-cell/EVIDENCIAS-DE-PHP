<?php
require_once __DIR__ . '/Vehiculo.php';

class Auto extends Vehiculo
{
    private int $puertas;

    public function __construct(string $marca, string $modelo, int $anio, float $precio, int $puertas = 4)
    {
        parent::__construct($marca, $modelo, $anio, $precio);
        $this->puertas = $puertas;
    }

    public function getTipo(): string
    {
        return 'Auto';
    }

    public function getIcono(): string
    {
        return 'fas fa-car';
    }

    public function getColor(): string
    {
        return '#3b82f6';
    }

    public function consumoPor100km(): float
    {
        return 8.5;
    }

    public function arrancar(): string
    {
        return 'El Auto ' . $this->marca . ' ' . $this->modelo . ' arranca con la llave.';
    }

    public function frenar(): string
    {
        return 'El Auto ' . $this->marca . ' frena con discos de freno.';
    }

    public function getPuertas(): int
    {
        return $this->puertas;
    }
}
