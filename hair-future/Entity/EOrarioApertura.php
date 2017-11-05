<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 01/11/2017
 * Time: 19:05
 */

class EOrarioApertura
{
    private $listaGiorni = [];

    private function carica(){
        $db = new FOrarioApertura();
        $rows = $db->ottieniOrario();
        foreach($rows as $row){
            $giorno = new EGiorno();
            $this->listaGiorni[(string)$row['giorno']] = $giorno->loadByValori($row);
        }
    }

    public function __construct()
    {
        $this->carica();
    }

    public function convertiInArray()
    {
        $dati = array();
        foreach ($this->listaGiorni as $giorno)
        {
            $dati[$giorno->getNome()] = $giorno->convertiInArray();
        }
        return $dati;
    }

    /**
     * @param $valori
     * @return int
     * riceve in input un array che contiene il giorno e gli orari di apertura e chiusura di mattina e pomeriggio, controlla se il giorno fornito è corretto e procede alla modifica
     */
    public function modificaGiorno($valori){
        $db = new FOrarioApertura();
        if(isset($this->listaGiorni[$valori['giorno']])) {
            $this->listaGiorni[$valori['giorno']]->loadByValori($valori);
            return $db->modificaGiorno($valori['giorno'], $valori['aperturaMattina'], $valori['chiusuraMattina'], $valori['aperturaPomeriggio'], $valori['chiusuraPomeriggio']);
        }else
            return -1;
    }

    public function modificaGiorni($giorni)
    {
        $check = true;
        foreach ($giorni as $giorno)
        {
            if ($check)
                $check = $this->modificaGiorno($giorno);
            else
                return -1;
        }
        return 0;
    }

    /**
     * riceve in input una data in output retituisce un EGiorno corrispondente al giorno della settimana di tale data
     * @param $data
     * @return mixed
     */
    public function getGiorno($data)
    {
        $settimanaEngIta = array('Mon'=>'Lunedì','Tue'=>'Martedì','Wed'=>'Mercoledì',
            'Thu'=>'Giovedì','Fri'=>'Venerdì','Sat'=>'Sabato','Sun'=>'Domenica');
        $dayWeek = date('D', strtotime($data));
        return $this->listaGiorni[$settimanaEngIta[$dayWeek]];
    }

    /**
     * @return array
     */
    public function getListaGiorni()
    {
        return $this->listaGiorni;
    }
}