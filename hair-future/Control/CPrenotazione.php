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
        $Mercurio = USingleton::getInstance('VJson');
        $dati = $catalogo->getListaCategorie();
        $Mercurio->invia($dati);
    }

    public function inviaDurataListaServizi()
    {
        $catalogoServizi = USingleton::getInstance('ECatalogoServizi');
        $Mercurio = USingleton::getInstance('VJson');
        $dati = $Mercurio->ricevi();
        $dati = $dati["dati"];
        $durata = $catalogoServizi->getDurataListaServizi($dati);
        $dati = null;
        $dati['durata'] = $durata;
        $catalogoAppuntamenti = USingleton::getInstance('ECatalogoAppuntamenti');
        $dati['intervalli'] = $catalogoAppuntamenti->ottieniIntervalliNonPrenotabili(7,date('Y-m-d'), $durata);
        $Mercurio->invia($dati);
    }
}