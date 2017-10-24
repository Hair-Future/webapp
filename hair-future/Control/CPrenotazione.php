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
        $catalogoServizi = new ECatalogoServizi();
        $durata = 0;
        $Mercurio = USingleton::getInstance('VJson');
        $data = $Mercurio->ricevi();
        $dati = $data["dati"];
        foreach ($dati["lista"] as $item)
        {
            $servizio = $catalogoServizi->ottieniServizioByCodice($item);
            $durata += $servizio->getDurata();
        }
        $dati = null;
        $dati['durata'] = $durata;
        $catalogoAppuntamenti = USingleton::getInstance('ECatalogoAppuntamenti');
        $dati['intervalli'] = $catalogoAppuntamenti->ottieniIntervalliNonPrenotabili(7,date('Y-m-d'), $durata);
        $Mercurio->invia($dati);
    }
}