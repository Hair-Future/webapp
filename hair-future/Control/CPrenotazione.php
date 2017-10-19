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
        $catalogo = new ECatalogoServizi();
        $Mercurio = new VJson();
        $dati = $catalogo->getListaCategorie();
        $Mercurio->invia($dati);
    }

    public function inviaDurataListaServizi()
    {
        $catalogoServizi = new ECatalogoServizi();
        $durata = 0;
        $Mercurio = new VJson();
        $dati = $Mercurio->ricevi();
        foreach ($dati["lista"] as $item)
        {
            $servizio = $catalogoServizi->ottieniServizioByCodice($item);
            $durata += $servizio->getDurata();
        }
        $dati = null;
        $dati[] = $durata;
        $catalogoAppuntamenti = new ECatalogoAppuntamenti();
        $dati[] = $catalogoAppuntamenti->ottieniIntervalliOccupati(7);
        $Mercurio->invia($dati);
    }
}