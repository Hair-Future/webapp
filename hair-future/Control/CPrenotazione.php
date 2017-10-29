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
        $Mercurio = new VJson;
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
        $intervalli = $catalogoAppuntamenti->ottieniIntervalliNonPrenotabili($numeroGiorni, $data, $durata);

        $Mercurio->inviaDatiCalendario($durata, $intervalli);
    }
}