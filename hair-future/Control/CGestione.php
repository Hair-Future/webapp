<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 04/11/17
 * Time: 18.36
 */

class CGestione
{
    public function inviaOrario()
    {
        $Mercurio = new VGestione();
        $orario = new EOrarioApertura();
        $Mercurio->inviaOrario($orario);
    }

    /**
     * riceve un array di array chiave/valore dove le chiavi sono:
     *
     * giorno
     * aperturaMattina
     * chiusuraMattina
     * aperturaPomeriggio
     * chiusuraPomeriggio
     */

    public function modificaOrario()
    {
        $Mercurio = new VGestione();
        $session = USingleton::getInstance('CSession');
        $orarioArray = $Mercurio->riceviOrario();

        $utente = $session->leggiValore('utente');
        if ($utente->getTipo() == 'Direttore')
            $check = $utente->modificaOrario($orarioArray);
        else
            $check = -1;

        $Mercurio->invia($check);
    }

    public function inviaAppuntamenti()
    {
        $Mercurio = new VGestione();
        $catalogo = USingleton::getInstance('ECatalogoAppuntamenti');
        $dataInizio = $Mercurio->riceviInizioPeriodo();
        $numeroGiorni = $Mercurio->riceviDurataPeriodo();
        $appuntamenti = $catalogo->ottieniAppuntamentiPeriodoInArray($dataInizio, $numeroGiorni);
        $Mercurio->invia($appuntamenti);
    }

    public function segnaEffettuati()
    {
        $Mercurio = new VGestione();
        $session = USingleton::getInstance('CSession');
        $utente = $session->leggiValore('utente');
        $effettuati = $Mercurio->riceviEffettuati();
        if ($utente->getTipo() == 'Direttore')
            $check = $utente->segnaAppuntamentiEffettuati($effettuati);
        else
            $check = -1;

        $Mercurio->invia($check);
    }
}