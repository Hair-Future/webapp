<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 01/11/17
 * Time: 16.55
 */

class FOrarioApertura extends FDb
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ottieniOrario()
    {
        $this->sql = $this->con->prepare("SELECT *
                      FROM OrarioApertura;");
        return parent::searchAll();
    }

    public function modificaGiorno($giorno, $aperturaMattina, $chiusuraMattina, $aperturaPomeriggio, $chiusuraPomeriggio)
    {
        $this->sql = $this->con->prepare("UPDATE OrarioApertura
                     SET aperturaMattina = ?,
                         chiusuraMattina = ?,
                         aperturaPomeriggio = ?,
                         chiusuraPomeriggio = ?
                     WHERE giorno = ?;");
        return parent::query(array($aperturaMattina, $chiusuraMattina, $aperturaPomeriggio, $chiusuraPomeriggio, $giorno));
    }
}