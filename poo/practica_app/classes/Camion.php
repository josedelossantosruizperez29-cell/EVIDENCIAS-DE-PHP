<?php
require_once __DIR__ . '/Vehiculo.php';

class Camion extends Vehiculo
{
    private float $capacidadTon;
    private int $ejes;

    public function __construct(string $marca, string $modelo, int $anio, float $precio, float $capacidadTon = 5.0, int $ejes = 2)
    {
        parent::__construct($marca, $modelo, $anio, $precio);
        $this->capacidadTon = $capacidadTon;
        $this->ejes = $ejes;
    }

    public function getTipo(): string
    {
        return 'Camión';
    }

    public function getIcono(): string
    {
        return 'fas fa-truck';
    }

    public function getColor(): string
    {
        return '#e74c3c';
    }

    public function consumoPor100km(): float
    {
        return 28.0;
    }

    public function arrancar(): string
    {
        return 'El Camión ' . $this->marca . ' arranca con sistema de aire comprimido.';
    }

    public function frenar(): string
    {
        return 'El Camión ' . $this->marca . ' frena con frenos neumáticos de ' . $this->ejes . ' ejes.';
    }

    public function getCapacidadTon(): float
    {
        return $this->capacidadTon;
    }

    public function getEjes(): int
    {
        return $this->ejes;
    }
}
