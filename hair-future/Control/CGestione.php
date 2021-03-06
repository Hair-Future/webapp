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
        $session = USingleton::getInstance('CSession');

        //$dataInizio = $Mercurio->riceviInizioPeriodo();
        $numeroGiorni = $Mercurio->riceviDurataPeriodo();
        $utente = $session->leggiValore('utente');
        $data = $session->leggiValore('data');
        if ($data == false)
                $data = new DateTime('now');

        $session->impostaValore('data', $data);
        $dataInizio = $data->format('Y-m-d');

        if ($utente->getTipo() == 'Direttore')
            $appuntamenti= $utente->ottieniAppuntamentiPeriodoInArray($dataInizio, $numeroGiorni);
        else
            $appuntamenti= -1;

        $Mercurio->inviaAppuntamentiData($appuntamenti, $dataInizio);
    }

    public function spostaDiNGiorni()
    {
        $Mercurio = new VGestione();
        $session = USingleton::getInstance('CSession');

        $data = $session->leggiValore('data');
        $numeroGiorni = $Mercurio->riceviDurataPeriodo();

        $data->modify($numeroGiorni.' day');
    }

    public function segnaEffettuato()
    {
        $Mercurio = new VGestione();
        $session = USingleton::getInstance('CSession');
        $utente = $session->leggiValore('utente');
        $effettuato = $Mercurio->riceviEffettuati();
        if ($utente->getTipo() == 'Direttore')
            $check = $utente->segnaAppuntamentoEffettuato($effettuato);
        else
            $check = -1;

        $Mercurio->invia(array($check));
    }
}