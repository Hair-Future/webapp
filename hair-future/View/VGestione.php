<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 04/11/17
 * Time: 19.06
 */

class VGestione extends VJson
{
    public function inviaOrario($orario)
    {
        $dati = $orario->convertiInArray();
        $this->invia($dati);
    }

    /**
     * riceve un array di array chiave/valore dove le chiavi sono:
     *
     * giorno
     * aperturaMattina
     * chiusuraMattina
     * aperturaPomeriggio
     * chiusuraPomeriggio
     *
     * @return mixed
     */
    public function riceviOrario()
    {
        $dati = $this->ricevi();
        return $dati['dati'];
    }

    public function riceviInizioPeriodo()
    {
        $dati = $this->ricevi();
        return $dati['dati']['dataInizio'];
    }

    public function riceviDurataPeriodo()
    {
        $dati = $this->ricevi();
        return $dati['dati']['numeroGiorni'];
    }

    public function riceviEffettuati()
    {
        $dati = $this->ricevi();
        return $dati['dati']['appuntamentoEffettuato'];
    }
}