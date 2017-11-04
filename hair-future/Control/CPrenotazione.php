<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 10/10/17
 * Time: 18.08
 */

class CPrenotazione
{
    public function inviaTuttiServizi()
    {
        $catalogo = USingleton::getInstance('ECatalogoServizi');
        $Mercurio = new VPrenotazione();
        $dati = $catalogo->getListaCategorie();
        $Mercurio->invia($dati);
    }

    public function salvaListaServizi()
    {
        $Mercurio = new VPrenotazione();
        $session = USingleton::getInstance('CSession');
        $catalogoServizi = USingleton::getInstance('ECatalogoServizi');

        $listaCodici = $Mercurio->riceviListaCodiciServizi();

        $durata = $catalogoServizi->getDurataListaServizi($listaCodici);
        $lista = $catalogoServizi->ottieniListaServiziByCodici($listaCodici);

        $session->impostaValore('durataListaServiziAttuale', $durata);
        $session->impostaValore('listaServiziAttuale', $lista);
    }

    public function inviaDatiCalendario()
    {
        $Mercurio = new VPrenotazione();
        $session = USingleton::getInstance('CSession');
        $catalogoAppuntamenti = USingleton::getInstance('ECatalogoAppuntamenti');

        $data = $Mercurio->riceviPrimoGiornoCalendario();
        $numeroGiorni =$Mercurio->riceviNumeroGiorni();

        $durata = $session->leggiValore('durataListaServiziAttuale');
        $intervalli = $catalogoAppuntamenti->ottieniIntervalliPrenotabili($data, $numeroGiorni, $durata);

        $Mercurio->inviaDatiCalendario($durata, $intervalli);
    }

    public function effettuaPrenotazione()
    {
        $Mercurio = new VPrenotazione();
        $oraAppuntamento = $Mercurio->riceviOraInizioAppuntamento();
        $dataAppuntamento = $Mercurio->riceviDataAppuntamento();

        $session = USingleton::getInstance('CSession');
        $listaServizi = $session->leggiValore('listaServiziAttuale');
        $utente = $session->leggiValore('utente');

        if ($utente->getTipo() == 'Cliente')
        {
            $check = $utente->prenotaAppuntamento($listaServizi, $dataAppuntamento, $oraAppuntamento);
            $Mercurio->invia($check);
        }
        else
            $Mercurio->invia("l'utente non è un cliente");

    }
}