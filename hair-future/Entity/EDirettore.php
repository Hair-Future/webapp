<?php

/**
 * Created by PhpStorm.
 * User: loren
 * Date: 02/06/2017
 * Time: 17:12
 */

/**
 * Class EDirettore
 */

class EDirettore extends EUtente
{

    function getTipo()
    {
        return "Direttore";
    }

    //gestione servizi
    public function creaServizio($nome, $descrizione, $prezzo, $durata, $categoriaInCuiAllocarlo)
    {
        $catalogoServizi = new ECatalogoServizi();
        $catalogoServizi->aggiungiNuovoServizio($nome, $descrizione, $prezzo, $durata, $categoriaInCuiAllocarlo);
    }

    public function modificaServizio($id, $nome, $descrizione, $prezzo, $durata)
    {
        $catalogoServizi = new ECatalogoServizi();
        $servizio = $catalogoServizi->ottieniServizioByCodice($id);
        $servizio->modificaAttributi($nome, $descrizione, $prezzo, $durata);
    }

    public function eliminaServizio($id)
    {
        $catalogoServizi = new ECatalogoServizi();
        $catalogoServizi->rimuoviServizio($id);
    }

    public function creaCategoria($nome, $descrizione)
    {
        $catalogoServizi = new ECatalogoServizi();
        $catalogoServizi->aggiungiNuovaCategoria($nome, $descrizione);
    }

    public function modificaCategoria($vecchioNome, $nuovoNome, $nuovaDescrizione)
    {
        $catalogoServizi = new ECatalogoServizi();
        $categoria = $catalogoServizi->ottieniCategoria($vecchioNome);
        $categoria->modificaAttributi($nuovoNome, $nuovaDescrizione);
    }

    public function eliminaCategoria($nome)
    {
        $catalogoServizi = new ECatalogoServizi();
        $catalogoServizi->rimuoviCategoria($nome);
    }

    //modifica degli orari
    public function modificaOrario($orarioArray)
    {
        $orario = new EOrarioApertura();
        return $orario->modificaGiorni($orarioArray);
    }

    //scrittura appuntamenti effettuati
    public function segnaAppuntamentoEffettuato($effettuato)
    {
        $catalogo = USingleton::getInstance('ECatalogoAppuntamenti');
        return $catalogo->segnaEffettuato($effettuato);
    }

    public function segnaAppuntamentiEffettuati($effettuati)
    {
        $catalogo = USingleton::getInstance('ECatalogoAppuntamenti');
        return $catalogo->segnaEffettuati($effettuati);
    }

    //statistiche
    public function maxSpesaUtente($dataInizio, $dataFine)
    {
        $statistiche = new EStatistiche();
        return $statistiche->maxSpesaUtente($dataInizio, $dataFine);
    }

    public function guadagno($dataInizio, $dataFine)
    {
        $statistiche = new EStatistiche();
        return $statistiche->guadagno($dataInizio, $dataFine);
    }

    public function serviziApplicati($dataInizio, $dataFine)
    {
        $statistiche = new EStatistiche();
        return $statistiche->serviziApplicati($dataInizio, $dataFine);
    }

    public function appuntamentiMancati($dataInizio, $dataFine)
    {
        $statistiche = new EStatistiche();
        return $statistiche->appuntamentiMancati($dataInizio, $dataFine);
    }

    //fatti per conto di un cliente
    public function prenotaAppuntamento($email, $listaServizi, $data, $ora)
    {
        return parent::prenotaAppuntamento($email, $listaServizi, $data, $ora);
    }

    public function modificaAppuntamento($id, $data, $ora, $email)
    {
        parent::modificaAppuntamento($id, $data, $ora, $email);
    }

    public function cancellaAppuntamento($id, $email)
    {
        parent::cancellaAppuntamento($id, $email);
    }
}