<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 05/11/17
 * Time: 16.12
 */

class CStatistiche
{

    public function maxSpesaUtente()
    {
        $Mercurio = new VStatistiche();
        $session = USingleton::getInstance('CSession');
        $dataInizio = $Mercurio->riceviInizioIntervallo();
        $dataFine = $Mercurio->riceviFineIntervallo();

        $utente = $session->leggiValore('utente');
        if ($utente->getTipo() == 'Direttore')
            $risultati = $utente->maxSpesaUtente($dataInizio, $dataFine);
        else
            $risultati = -1;

        $Mercurio->invia($risultati);
    }

    public function guadagno()
    {
        $Mercurio = new VStatistiche();
        $session = USingleton::getInstance('CSession');
        $dataInizio = $Mercurio->riceviInizioIntervallo();
        $dataFine = $Mercurio->riceviFineIntervallo();

        $utente = $session->leggiValore('utente');
        if ($utente->getTipo() == 'Direttore')
            $risultati = $utente->guadagno($dataInizio, $dataFine);
        else
            $risultati = -1;

        $Mercurio->invia($risultati);
    }

    public function serviziApplicati()
    {
        $Mercurio = new VStatistiche();
        $session = USingleton::getInstance('CSession');
        $dataInizio = $Mercurio->riceviInizioIntervallo();
        $dataFine = $Mercurio->riceviFineIntervallo();

        $utente = $session->leggiValore('utente');
        if ($utente->getTipo() == 'Direttore')
            $risultati = $utente->serviziApplicati($dataInizio, $dataFine);
        else
            $risultati = -1;

        $Mercurio->invia($risultati);
    }

    public function appuntamentiMancati()
    {
        $Mercurio = new VStatistiche();
        $session = USingleton::getInstance('CSession');
        $dataInizio = $Mercurio->riceviInizioIntervallo();
        $dataFine = $Mercurio->riceviFineIntervallo();

        $utente = $session->leggiValore('utente');
        if ($utente->getTipo() == 'Direttore')
            $risultati = $utente->appuntamentiMancati($dataInizio, $dataFine);
        else
            $risultati = -1;

        $Mercurio->invia($risultati);
    }
}