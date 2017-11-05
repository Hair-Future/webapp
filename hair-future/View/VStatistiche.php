<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 05/11/17
 * Time: 16.48
 */

class VStatistiche extends VJson
{
    public function riceviInizioIntervallo()
    {
        $dati = $this->ricevi();
        return $dati['dati']['dataInizio'];
    }

    public function riceviFineIntervallo()
    {
        $dati = $this->ricevi();
        return $dati['dati']['dataFine'];
    }
}