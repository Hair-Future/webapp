<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 29/10/17
 * Time: 11.31
 */

class VPrenotazione extends VJson
{
    public function riceviListaCodiciServizi()
    {
        $dati = $this->ricevi();
        return $dati['dati']['lista'];
    }

    public function riceviPrimoGiornoCalendario()
    {
        $dati = $this->ricevi();
        return $dati['dati']['data'];
    }

    public function riceviNumeroGiorni()
    {
        $dati = $this->ricevi();
        return $dati['dati']['numeroGiorni'];
    }

    public function riceviOraInizioAppuntamento()
    {
        $dati = $this->ricevi();
        return $dati['dati']['oraInizioAppuntamento'];
    }

    public function riceviDataAppuntamento()
    {
        $dati = $this->ricevi();
        return $dati['dati']['dataAppuntamento'];
    }

    public function inviaDatiCalendario($durata, $intervalli)
    {
        $dati['durata'] = $durata;
        $dati['intervalli'] = $intervalli;
        $this->invia($dati);
    }
}