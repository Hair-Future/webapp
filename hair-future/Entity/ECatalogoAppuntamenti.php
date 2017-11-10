<?php

/**
 * Created by PhpStorm.
 * User: toki
 * Date: 29/05/17
 * Time: 22.57
 */
class ECatalogoAppuntamenti
{
    private $catalogo = [];

    private function carica()
    {
        $db = new FAppuntamento();
        $result = $db->search("CURRENT_DATE", "CURRENT_TIME");
        $this->catalogo = [];
        foreach ($result as $row)
        {
            $appuntamento = new EAppuntamento();
            $this->catalogo[] = $appuntamento->loadByValori($row);
        }
    }

    private function calcolaDurataListaServizi($listaServizi)
    {
        $durata = 0;
        foreach ($listaServizi as $servizio)
        {
            $durata += $servizio->getDurata();
        }
        return $durata;
    }
    /**
     * controlla che l'appuntamento richiesto (la combinzaione $data, $ora, $listaServizi ne costruirà uno)
     * non verrà sovrapposto con un altro
     * @param $data
     * @param $ora
     * @param $listaServizi
     * @return int -1 fallimento, 0 successo
     *
     * metodo che riceve una data in formato 'Y-m-d', e l'ora in formato 'H:i:s'
     */
    private function controllaNoSovrapposizione($data, $ora, $listaServizi)
    {
        $startTime = strtotime($data." ".$ora);
        $durata = $this->calcolaDurataListaServizi($listaServizi);

        $endTime = $startTime + (($durata)*60);
        $listaAppuntamenti = $this->searchAppuntamentoByData($data);
        foreach ($listaAppuntamenti as $appuntamento)
        {
            $oraInizioTemp = strtotime($data." ".$appuntamento->getOraInizio());
            $oraFineTemp = strtotime($data." ".$appuntamento->getOraFine());

            if (((($startTime <= $oraInizioTemp) && ($endTime >= $oraFineTemp)) ||
                (($startTime < $oraInizioTemp) && (($endTime <= $oraFineTemp) && ($endTime > $oraInizioTemp))) ||
                ((($startTime >= $oraInizioTemp) && ($startTime < $oraFineTemp)) && ($endTime >= $oraFineTemp)) ||
                (($startTime > $oraInizioTemp) && ($endTime < $oraFineTemp))))
            {
                return -1;
            }
        }
        return 0;
    }

    /**
     * controlla che l'appuntamento richiesto (la combinzaione $data, $ora, $listaServizi ne costruirà uno)
     * sia nell'orario di apertura
     * @param $data
     * @param $ora
     * @param $listaServizi
     * @return int -1: fallimento, 0:successo.
     */
    private function inOrarioApertura($data, $ora, $listaServizi)
    {
        $orarioApertura = new EOrarioApertura();
        $giorno = $orarioApertura->getGiorno($data);

        $inizioListaServizi = strtotime($data." ".$ora);
        $fineListaServizi = $inizioListaServizi + $this->calcolaDurataListaServizi($listaServizi)*60;

        $aperturaMattina = strtotime($data." ".$giorno->getAperturaMattina());
        $chiusuraMattina = strtotime($data." ".$giorno->getChiusuraMattina());
        $aperturaPomeriggio = strtotime($data." ".$giorno->getAperturaPomeriggio());
        $chiusuraPomeriggio = strtotime($data." ".$giorno->getChiusuraPomeriggio());

        if (($aperturaMattina > $inizioListaServizi) ||
            ($chiusuraPomeriggio < $fineListaServizi) ||
            (($inizioListaServizi <= $chiusuraMattina) && ($fineListaServizi > $chiusuraMattina)) ||
            (($inizioListaServizi < $aperturaPomeriggio) && ($fineListaServizi >= $aperturaPomeriggio)) ||
            (($inizioListaServizi >= $chiusuraMattina) && ($fineListaServizi <= $aperturaPomeriggio)))
            return -1;
        else
            return 0;
    }

    /**
     * controlla che l'appuntamento sia prenotabile
     * @param $data
     * @param $ora
     * @param $listaServizi
     * @return int -1: fallimento, 0:successo.
     */
    private function controllaPossibilitaPrenotazione($data,$ora,$listaServizi)
    {
        if (($this->inOrarioApertura($data,$ora,$listaServizi) == 0) &&
            ($this->controllaNoSovrapposizione($data,$ora,$listaServizi) == 0))
            return 0;
        else
            return -1;
    }
    /**
     * ECatalogoAppuntamenti constructor.
     */
    public function __construct()
    {
        $this->carica();
    }

    /**
     * @param string $utente
     * @return array
     * metodo che riceve una stringa rappresentante l'email di un utente (attributo identificativo)
     *  e restituisce tutti gli appuntamenti a lui associati
     */


    public function searchAppuntamentoByUtente($utente){
        $result = array();
        foreach ($this->catalogo as $appuntamento){
            if($appuntamento->getUtente()->getEmail() == $utente)
                $result[] = $appuntamento;
        }
        return $result;
    }


    /**
     * @return array
     * metodo che restituisce tutti gli appuntamenti della data corrente
     */
    public function searchAppuntamentoOdierno(){
        $result = array();
        foreach ($this->catalogo as $appuntamento) {
            if($appuntamento->getData() == date('Y-m-d'))
                $result[] = $appuntamento;
        }
        return $result;
    }

    /**
     * @param $data
     * @return array
     * metodo che riceve una data in formato 'Y-m-d' e restituisce tutti gli appuntamenti associati ad essa associati
     */
    public function searchAppuntamentoByData($data){
        $result = array();
        foreach ($this->catalogo as $appuntamento){
            if($appuntamento->getData() == $data)
                $result[] = $appuntamento;
        }

        return $result;
    }


    /**
     * @param $dataInizio
     * @param $dataFine
     * @return array
     * riceve due date in formato 'Y-m-d' e restituisce tutti gli appuntamenti compresi nelle due date
     */
    public function searchAppuntamentoByPeriodo($dataInizio, $dataFine){
        $result = array();
        $db = new FAppuntamento();
        $rows = $db->searchByPeriodo(array($dataInizio, $dataFine));
        foreach($rows as $row){
            $appuntamento = new EAppuntamento();
            $result[] = $appuntamento->loadByValori($row);
        }
        return $result;
    }

    /**
     * @param $codice
     * @return bool|mixed
     * metodo che riceve un codice di un appuntamento e lo restituisce, se esiste
     */
    public function searchAppuntamentoByCodice($codice){
        foreach ($this->catalogo as $appuntamento){
            if($appuntamento->getCodice() == $codice)
                return $appuntamento;
        }
        return false;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $result = '';
        foreach ($this->catalogo as $appuntamento){
            $result = $result. $appuntamento->__toString() . "\n";
        }
        return $result;
    }

    public function prenotaAppuntamento($email, $listaServizi, $data, $ora)
    {
        FAppuntamento::lock();
        $this->carica();
        if ($this->controllaPossibilitaPrenotazione($data,$ora,$listaServizi)==0)
        {
            $appuntamento = new EAppuntamento();
            $appuntamento->sceltaServizi($email, $listaServizi);
            $appuntamento->addAppuntamento($data, $ora);
            FAppuntamento::unlock();
            $this->carica();
            return 0;
        }
        else
        {
            FAppuntamento::unlock();
            return -1;
        }
    }

    public function modificaAppuntamento($id, $data, $ora, $email)
    {
        $appuntamenti = $this->searchAppuntamentoByUtente($email);
        foreach ($appuntamenti as $appuntamento)
        {
            if ($appuntamento->getCodice() == $id)
            {
                $appuntamento->updateAppuntamento($data, $ora);
                $this->carica();
                return 0;
            }
        }
        return -1;
    }

    public function cancellaAppuntamento($id, $email)
    {
        $appuntamenti = $this->searchAppuntamentoByUtente($email);
        foreach ($appuntamenti as $appuntamento)
        {
            if ($appuntamento->getCodice() == $id)
            {
                $appuntamento->deleteAppuntamento();
                $this->carica();
                return 0;
            }
        }
        return -1;
    }

    /**
     * @param $dataInizio
     * @param $numGiorni
     * @return array
     */
    public function ottieniAppuntamentiPeriodo($dataInizio, $numGiorni)
    {
        $appuntamenti = array();
        $date = new DateTime($dataInizio);
        for ($i = 0; $i < $numGiorni; $i++)
        {
            $giorno = $this->searchAppuntamentoByData($date->format('Y-m-d'));
            if (($giorno))
            {
                foreach ($giorno as $appuntamento)
                {
                    $appuntamenti[] = $appuntamento;
                }
            }
            $date->modify('+1 day');
        }
        return $appuntamenti;
    }

    /**
     * @param $dataInizio
     * @param $numGiorni
     * @return array
     */
    public function ottieniAppuntamentiPeriodoInArray($dataInizio, $numGiorni)
    {
        $appuntamenti = $this->ottieniAppuntamentiPeriodo($dataInizio, $numGiorni);
        $dati = array();
        foreach ($appuntamenti as $appuntamento)
        {
            $dati[] = $appuntamento->convertiInArray();
        }
        return $dati;
    }
    /**
     * @param $numGiorni
     * @param $data: date(Y-m-d)
     * @return array
     */
    public function ottieniIntervalliOccupati($data, $numGiorni)
    {
        $appuntamenti = $this->ottieniAppuntamentiPeriodo($data, $numGiorni);
        $intervalli = array();
        foreach ($appuntamenti as $item)
        {
            $intervalli[$item->getData()][] = array('inizioIntervallo' => $item->getOraInizio(),
            'fineIntervallo' => $item->getOraFine());
        }
        return $intervalli;
    }

    private function ottieniIntervalliPrenotabiliMattinaOppurePomeriggio($data, $durataAppuntamento, $mattinaPomeriggio)
    {
        $orarioApertura = new EOrarioApertura();
        $giorno = $orarioApertura->getGiorno($data);
        $intervalli = $this->ottieniIntervalliOccupati($data, 1);
        $durata = $durataAppuntamento*60;

        $prenotabili = [];
        $fineIntervalloPrec = $giorno->{"getApertura".$mattinaPomeriggio}();
        foreach ($intervalli as $item)
        {
            foreach ($item as $intervallo)
            {
                if (strtotime($intervallo["inizioIntervallo"]) >= strtotime($fineIntervalloPrec))
                {
                    if (strtotime($intervallo["inizioIntervallo"]) < strtotime($giorno->{"getChiusura".$mattinaPomeriggio}()))
                    {
                        $libero = strtotime($intervallo["inizioIntervallo"]) - strtotime($fineIntervalloPrec);
                        $numIntervalli = floor($libero/$durata);
                        for ($i = 0; $i<$numIntervalli; $i++)
                        {
                            $prenotabili[] = $fineIntervalloPrec;
                            $fineIntervalloPrec = date('H:i:s', strtotime('+'.$durataAppuntamento.' min', strtotime($fineIntervalloPrec)));
                        }
                    }
                    //if (strtotime($giorno->{"getChiusura".$mattinaPomeriggio}()) > strtotime($intervallo["fineIntervallo"]))
                        $fineIntervalloPrec = $intervallo["fineIntervallo"];
                }
            }
        }
        if (strtotime($giorno->{"getChiusura".$mattinaPomeriggio}()) >= strtotime($fineIntervalloPrec))
        {
            $libero = strtotime($giorno->{"getChiusura".$mattinaPomeriggio}()) - strtotime($fineIntervalloPrec);
            if ($durata > 0)
                $numIntervalli = floor($libero/$durata);
            else
                return -1;
            for ($i = 0; $i<$numIntervalli; $i++)
            {
                $prenotabili[] = $fineIntervalloPrec;
                $fineIntervalloPrec = date('H:i:s', strtotime('+'.$durataAppuntamento.' min', strtotime($fineIntervalloPrec)));
            }
        }
        return $prenotabili;
    }

    public function ottieniIntervalliPrenotabili($data, $numGiorni, $durataAppuntamento)
    {
        $date = new DateTime($data);
        $prenotabili = array();

        $intervalli = $this->ottieniIntervalliPrenotabiliMattinaOppurePomeriggio($date->format('Y-m-d'), $durataAppuntamento, 'Mattina');
        foreach ($intervalli as $intervallo)
        {
            if (strtotime($intervallo) > time())
                $prenotabili[$date->format('Y-m-d')][] = $intervallo;
        }

        $intervalli = $this->ottieniIntervalliPrenotabiliMattinaOppurePomeriggio($date->format('Y-m-d'), $durataAppuntamento, 'Pomeriggio');
        foreach ($intervalli as $intervallo)
        {
            if (strtotime($intervallo) > time())
                $prenotabili[$date->format('Y-m-d')][] = $intervallo;
        }
        $date->modify('+1 day');

        for ($i = 1; $i < $numGiorni; $i++)
        {
            $intervalli = $this->ottieniIntervalliPrenotabiliMattinaOppurePomeriggio($date->format('Y-m-d'), $durataAppuntamento, 'Mattina');
            foreach ($intervalli as $intervallo)
            {
                $prenotabili[$date->format('Y-m-d')][] = $intervallo;
            }

            $intervalli = $this->ottieniIntervalliPrenotabiliMattinaOppurePomeriggio($date->format('Y-m-d'), $durataAppuntamento, 'Pomeriggio');
            foreach ($intervalli as $intervallo)
            {
                $prenotabili[$date->format('Y-m-d')][] = $intervallo;
            }
            $date->modify('+1 day');
        }
        return $prenotabili;
    }
/*
    public function ottieniListaServiziByCodici($listaCodici)
    {
        $lista = array();
        foreach ($listaCodici as $codice)
        {
            $appuntamento = $this->searchAppuntamentoByCodice((int)$codice);
            if (!is_null($appuntamento))
                $lista[] = $appuntamento;
        }
        return $lista;
    }
*/
    public function segnaEffettuato($codice)
    {
        $appuntamento = $this->searchAppuntamentoByCodice($codice);
        return $appuntamento->effettuato();
    }

    public function segnaEffettuati(array $codici)
    {
        $check = true;
        foreach ($codici as $codice)
        {
            if ($check)
            {
                $check = $this->segnaEffettuato($codice);
            }
            else
                return -1;
        }
        return 0;
    }
}