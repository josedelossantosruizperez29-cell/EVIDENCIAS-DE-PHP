<?php
require_once __DIR__ . '/Vehiculo.php';

class Moto extends Vehiculo
{
    private int $cilindrada;

    public function __construct(string $marca, string $modelo, int $anio, float $precio, int $cilindrada = 150)
    {
        parent::__construct($marca, $modelo, $anio, $precio);
        $this->cilindrada = $cilindrada;
    }

    public function getTipo(): string
    {
        return 'Moto';
    }

    public function getIcono(): string
    {
        return 'fas fa-motorcycle';
    }

    public function getColor(): string
    {
        return '#f59e0b';
    }

    public function consumoPor100km(): float
    {
        return 4.0;
    }

    public function arrancar(): string
    {
        return 'La Moto ' . $this->marca . ' arranca con patada o botón.';
    }

    public function frenar(): string
    {
        return 'La Moto ' . $this->marca . ' frena con frenos de tambor/disco.';
    }

    public function getCilindrada(): int
    {
        return $this->cilindrada;
    }
}
