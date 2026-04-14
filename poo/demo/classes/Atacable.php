<?php
/**
 * Atacable.php — Interface
 *
 * Una INTERFACE define un CONTRATO:
 * "Cualquier clase que implemente esta interface DEBE tener estos métodos."
 *
 * Las interfaces solo declaran la FIRMA del método (nombre + parámetros + retorno).
 * Quien implementa decide el CÓMO.
 */

interface Atacable
{
    /**
     * Realiza un ataque sobre el objetivo y devuelve el daño causado.
     * Cada clase lo implementa de forma distinta → POLIMORFISMO
     */
    public function atacar(Personaje $objetivo): int;

    /**
     * Recibe un golpe y reduce la vida del personaje.
     */
    public function recibirDanio(int $danio): void;
}
