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
        $data = new DateTime("now");

        $session->impostaValore('data', $data);
        $session->impostaValore('durataListaServiziAttuale', $durata);
        $session->impostaValore('listaServiziAttuale', $lista);
    }

    public function inviaDatiCalendario()
    {
        $Mercurio = new VPrenotazione();
        $session = USingleton::getInstance('CSession');

        //$data = $Mercurio->riceviPrimoGiornoCalendario();
        $data = $session->leggiValore('data');
        $numeroGiorni = (int)$Mercurio->riceviNumeroGiorni();
        $cliente = $session->leggiValore('utente');

        $durata = $session->leggiValore('durataListaServiziAttuale');
        $intervalli = $cliente->ottieniIntervalliPrenotabili($data->format('Y-m-d'),
            $numeroGiorni, $durata);

        $Mercurio->inviaDatiCalendario($data->format('Y-m-d'), $durata, $intervalli);
    }

    public function spostaDiNGiorni()
    {
        $Mercurio = new VPrenotazione();
        $session = USingleton::getInstance('CSession');

        $data = $session->leggiValore('data');
        $numeroGiorni = $Mercurio->riceviNumeroGiorni();

        $data->modify($numeroGiorni.' day');
        if (strtotime($data->format('Y-m-d')) < strtotime(date('Y-m-d')))
            $session->impostaValore('data', new DateTime('now'));

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