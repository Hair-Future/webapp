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
        $orarioArray = $Mercurio->riceviOrario();
        $orario = new EOrarioApertura();
        $check = $orario->modificaGiorni($orarioArray);
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
        $catalogo = new ECatalogoAppuntamenti();
        $effettuati = $Mercurio->riceviEffettuati();
        $check = $catalogo->segnaEffettuati($effettuati);
        $Mercurio->invia($check);
    }
}