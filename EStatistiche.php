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
            //if($appuntamento->getEffettuato())
                $risultati[$utente] += $appuntamento->getCosto();
        }
        $max = 0;
        $result = '';
        foreach ($risultati as $key=>$spesa){
            if($spesa > $max){
                $max = $spesa;
                $result = $key;
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
        $risultati = array();
        $catalogoAppuntamenti = USingleton::getInstance('ECatalogoAppuntamenti');
        $appuntamenti = $catalogoAppuntamenti->searchAppuntamentoByPeriodo($dataInizio, $dataFine);
        foreach ($appuntamenti as $appuntamento){
            $utente = (string)$appuntamento->getUtente()->getEmail();
            $risultati[$utente] = 0;
        }
        $result = 0;
        foreach($appuntamenti as $appuntamento){
            $result += $appuntamento->getCosto();
        }
        return $result;
    }

    /**
     * @param $dataInizio
     * @param $dataFine
     * @return string
     * restituisce il tempo impiegato negli appuntamenti e il tempo non utilizzato in un dato periodo di tempo
     */
    public function tempoImpiegato($dataInizio, $dataFine){
        $catalogoServizi = USingleton::getInstance('ECatalogoServizi');
    }

    /**
     * @param $dataInizio
     * @param $dataFine
     * @return string
     * restituisce la percentuale di utilizzo di ogni servizio in un dato periodo di tempo
     * i servizi non utilizzati non vengono mostrati
     */
    public function serviziApplicati($dataInizio, $dataFine){
        $catalogoServizi = USingleton::getInstance('ECatalogoServizi');
    }

    /**
     * @param $dataInizio
     * @param $dataFine
     * @return array
     * restituisce gli utenti che non si sono presentati ad almeno un appuntamento e il numero di appuntamenti mancati
     */
    public function appuntamentiMancati($dataInizio, $dataFine){
        $catalogoServizi = USingleton::getInstance('ECatalogoServizi');
    }
}