<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 04/11/17
 * Time: 17.29
 */

class VFrontController extends VJson
{
    public function riceviController()
    {
        $dati = $this->ricevi();
        return $dati['richiesta']['controller'];
    }

    public function riceviMetodo()
    {
        $dati = $this->ricevi();
        return $dati['richiesta']['metodo'];
    }
}