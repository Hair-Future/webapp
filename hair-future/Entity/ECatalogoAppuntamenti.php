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
        $result = $db->search("CURRENT_DATE");
        $this->catalogo = [];
        foreach ($result as $row)
        {
            $appuntamento = new EAppuntamento();
            $this->catalogo[] = $appuntamento->loadByValori($row);
        }
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
        $mutex = new FMutex();
        $mutex->wait();
        $this->carica();
        if ($this->controllaPossibilitaPrenotazione($data,$ora,$listaServizi)==0)
        {
            $appuntamento = new EAppuntamento();
            $appuntamento->sceltaServizi($email, $listaServizi);
            $appuntamento->addAppuntamento($data, $ora);
            $mutex->signal();
            $this->carica();
            return 0;
        }
        else
        {
            $mutex->signal();
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
     * @param $data
     * @param $ora
     * @param $listaServizi
     * @return int
     *
     * metodo che riceve una data in formato 'Y-m-d', e l'ora in formato 'H:i:s'
     */
    public function controllaPossibilitaPrenotazione($data, $ora, $listaServizi)
    {
        $startTime = strtotime($data." ".$ora);
        $durata = 0;
        foreach ($listaServizi as $servizio)
        {
            $durata += $servizio->getDurata();
        }

        $endTime = $startTime + (($durata)*60);
        $listaAppuntamenti = $this->searchAppuntamentoByData($data);
        foreach ($listaAppuntamenti as $appuntamento)
        {
            $oraInizioTemp = strtotime($data." ".$appuntamento->getOraInizio());
            $oraFineTemp = strtotime($data." ".$appuntamento->getOraFine());

            if (((($startTime <= $oraInizioTemp) && ($endTime >= $oraFineTemp)) ||
                (($startTime <= $oraInizioTemp) && (($endTime <= $oraFineTemp) && ($endTime >= $oraInizioTemp))) ||
                ((($startTime >= $oraInizioTemp) && ($startTime <= $oraFineTemp)) && ($endTime >= $oraFineTemp)) ||
                (($startTime >= $oraInizioTemp) && ($endTime <= $oraFineTemp))))
            {
                return -1;
            }
        }
        return 0;
    }

    /**
     * @param $numGiorni
     * @param $data: date(Y-m-d)
     * @return array
     */
    public function ottieniIntervalliOccupati($numGiorni, $data)
    {
        $appuntamenti = array();
        $date = new DateTime($data);
        for ($i = 0; $i < $numGiorni; $i++)
        {
            $date->modify('+1 day');
            $giorno = $this->searchAppuntamentoByData($date->format('Y-m-d'));
            if (($giorno))
            {
                foreach ($giorno as $appuntamento)
                {
                    $appuntamenti[] = $appuntamento;
                }
            }
        }
        $intervalli = array();
        foreach ($appuntamenti as $item)
        {
            $intervalli[$item->getData()][] = array('inizioIntervallo' => $item->getOraInizio(),
            'fineIntervallo' => $item->getOraFine());
        }
        return $intervalli;
    }

    public function ottieniIntervalliNonPrenotabili($numGiorni, $data, $durataAppuntamento)
    {
        $intervalli = $this->ottieniIntervalliOccupati($numGiorni, $data);
        $nonPrenotabili = array();
        $durata = $durataAppuntamento*60;
        //strtotime($data." ".$ora)
        foreach ($intervalli as $giorno=>$lista)
        {
            $nonPrenotabili[$giorno][] = $lista[0];
            for ($i = 1; $i < sizeof($lista); $i++)
            {
                $libero = strtotime($giorno." ".$lista[$i]['inizioIntervallo'])-strtotime($giorno." ".$lista[$i-1]['fineIntervallo']);
                if ($durata > $libero)
                {
                    $nonPrenotabili[$giorno][] = array('inizioIntervallo'=>$lista[$i-1]['fineIntervallo'],
                        'fineIntervallo'=>$lista[$i]['inizioIntervallo']);
                }
                $nonPrenotabili[$giorno][] = $lista[$i];
            }
        }
        return $nonPrenotabili;
    }

    public function segnaEffettuato($codice)
    {
        $appuntamento = $this->searchAppuntamentoByCodice($codice);
        $appuntamento->effettuato();
    }

    public function segnaEffettuati($codici)
    {
        foreach ($codici as $codice)
        {
            $this->segnaEffettuato($codice);
        }
    }
}