<?php
require_once __DIR__ . '/Conducible.php';

abstract class Vehiculo implements Conducible
{
    protected string $marca;
    protected string $modelo;
    protected int $anio;
    protected float $precio;

    private static int $contadorVehiculos = 0;

    public function __construct(string $marca, string $modelo, int $anio, float $precio)
    {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->anio = $anio;
        $this->precio = $precio;
        self::$contadorVehiculos++;
    }

    abstract public function getTipo(): string;
    abstract public function getIcono(): string;
    abstract public function getColor(): string;
    abstract public function consumoPor100km(): float;

    public function calcularCombustible(float $km): float
    {
        return ($km / 100) * $this->consumoPor100km();
    }

    public function getMarca(): string
    {
        return $this->marca;
    }

    public function getModelo(): string
    {
        return $this->modelo;
    }

    public function getAnio(): int
    {
        return $this->anio;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function getPrecioFormateado(): string
    {
        return '$' . number_format($this->precio, 0, ',', '.');
    }

    public static function getContador(): int
    {
        return self::$contadorVehiculos;
    }

    public function __toString(): string
    {
        return '[' . $this->getTipo() . '] ' . $this->marca . ' ' . $this->modelo . ' ' . $this->anio;
    }
}
