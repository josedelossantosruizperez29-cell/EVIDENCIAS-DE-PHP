<?php
interface Conducible
{
    public function arrancar(): string;
    public function frenar(): string;
    public function calcularCombustible(float $km): float;
}
