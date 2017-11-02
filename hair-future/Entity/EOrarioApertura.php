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

    /**
     * @return array
     */
    public function getListaGiorni()
    {
        return $this->listaGiorni;
    }

}