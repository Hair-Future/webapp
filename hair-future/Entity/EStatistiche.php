<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 31/10/2017
 * Time: 22:29
 */

class EStatistiche
{
    /**
     * @param $dataInizio
     * @param $dataFine
     * @return string
     * restituisce l'email dell'utente che ha speso di più in un dato periodo di tempo
     */
    public function maxSpesaUtente($dataInizio, $dataFine){
        //$gestoreUtenti = USingleton::getInstance("EGestoreUtenti");
        $risultati = array();
        $catalogoAppuntamenti = USingleton::getInstance('ECatalogoAppuntamenti');
        $appuntamenti = $catalogoAppuntamenti->searchAppuntamentoByPeriodo($dataInizio, $dataFine);
        foreach ($appuntamenti as $appuntamento){
            $utente = (string)$appuntamento->getUtente()->getEmail();
            $risultati[$utente] = 0;
        }
        foreach($appuntamenti as $appuntamento){
            $utente = (string)$appuntamento->getUtente()->getEmail();
            if($appuntamento->getEffettuato())
                $risultati[$utente] += $appuntamento->getCosto();
        }
        $max = 0;
        $result = '';
        foreach ($risultati as $key=>$spesa){
            if($spesa > $max){
                $max = $spesa;
                $utente = EGestoreUtenti::ottieniUtenteByID($key);
                $result = $utente->convertiInArray();
            }
        }
        /*$utente = $gestoreUtenti->ottieniUtenteByID($result);
        $result = "L'utente con spesa maggiore è " . $utente->getNome() . ' ' . $utente->getCognome() .
            ' (e-mail: ' . $utente->getEmail() . ') con totale ' . $max . '€';*/
        return $result;
    }

    /**
     * @param $dataInizio
     * @param $dataFine
     * @return float
     * restituisce il guadagno in un dato periodo di tempo
     */
    public function guadagno($dataInizio, $dataFine){
        $catalogoAppuntamenti = USingleton::getInstance('ECatalogoAppuntamenti');
        $appuntamenti = $catalogoAppuntamenti->searchAppuntamentoByPeriodo($dataInizio, $dataFine);
        $result = 0;
        foreach($appuntamenti as $appuntamento){
            if($appuntamento->getEffettuato())
                $result += $appuntamento->getCosto();
        }
        return $result;
    }

    /**
     * @param $dataInizio
     * @param $dataFine
     * @return array
     * restituisce la percentuale di applicazione di ogni servizio in un dato periodo di tempo
     * i servizi non utilizzati non vengono mostrati
     */
    public function serviziApplicati($dataInizio, $dataFine){
        $catalogoAppuntamenti = USingleton::getInstance('ECatalogoAppuntamenti');
        $catalogoServizi = USingleton::getInstance('ECatalogoServizi');
        $appuntamenti = $catalogoAppuntamenti->searchAppuntamentoByPeriodo($dataInizio, $dataFine);
        $totale = array();
        $max = 0;
        $result = array();
        foreach($appuntamenti as $appuntamento){
            if ($appuntamento->getEffettuato()) {
                foreach ($appuntamento->getListaServizi() as $servizio) {
                    $totale[$servizio->getCodice()] = 0;
                }
            }
        }
        foreach($appuntamenti as $appuntamento) {
            if ($appuntamento->getEffettuato()) {
            foreach ($appuntamento->getListaServizi() as $servizio) {
                $totale[$servizio->getCodice()] += 1;
                $max += 1;
            }
            }
        }
        $i = 0;
        foreach($totale as $key=>$value){
            $servizio = $catalogoServizi->ottieniServizioByCodice($key);
            $result[$i]['servizio'] = $servizio->convertiInArray();
            $result[$i]['percentuale'] = $value / $max * 100;
            $i++;
        }
        return $result;
    }

    /**
     * @param $dataInizio
     * @param $dataFine
     * @return array
     * restituisce un array degli utenti che non si sono presentati ad almeno un appuntamento e il numero di appuntamenti mancati
     */
    public function appuntamentiMancati($dataInizio, $dataFine){
        $mancati = array();
        $catalogoAppuntamenti = USingleton::getInstance('ECatalogoAppuntamenti');
        $appuntamenti = $catalogoAppuntamenti->searchAppuntamentoByPeriodo($dataInizio, $dataFine);
        foreach ($appuntamenti as $appuntamento){
            $utente = (string)$appuntamento->getUtente()->getEmail();
            $mancati[$utente] = 0;
        }
        foreach($appuntamenti as $appuntamento) {
            $utente = (string)$appuntamento->getUtente()->getEmail();
            if ($appuntamento->getEffettuato() == 0)
                $mancati[$utente] += 1;
        }
        $result = array();
        $i = 0;
        foreach($mancati as $key=>$value){
            if($mancati[$key] > 0) {
                $utente = EGestoreUtenti::ottieniUtenteByID($key);
                $result[$i]['utente'] = $utente->convertiInArray();
                $result[$i]['mancati'] = $value;
            }
            $i++;
        }
        return $result;
    }
}