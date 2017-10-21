<?php

/**
 * Created by PhpStorm.
 * User: loren
 * Date: 05/06/2017
 * Time: 15:18
 */
class FUtente extends FDb
{

    /**
     * FUtente constructor.
     */

     public function __construct()
    {
        parent::__construct(); //connessione al database
    }

    /**
     * @param $nome
     * @param $cognome
     * @param $recapito
     * @param $email
     * @param $password
     * @param $tipo
     * @return mixed
     */
    public function insert($nome, $cognome, $recapito, $email, $password, $tipo)
    {
        $this->sql =
            $this->con->prepare("INSERT INTO Utente(nome, cognome, recapito, email, password, tipo)
                                 VALUES (?,?,?,?,?,?)");
        return parent::query(array($nome, $cognome, $recapito, $email, $password, $tipo));
    }

    /**
     * @param $email
     * @return array
     */
    public function searchById($email)
    {
        $this->sql = $this->con->prepare("SELECT *
                      FROM Utente
                      WHERE email=?;");
        $result= parent::searchById(array($email));
        return $result;
    }

    public function searchByEmailPassword($email, $password)
    {
        $this->sql = $this->con->prepare("SELECT *
                      FROM Utente
                      WHERE email=? AND password=?;");
        $result= parent::searchById(array($email, $password));
        return $result;
    }
    /**
     * @param $nome
     * @param $cognome
     * @param $recapito
     * @param $password
     * @param $tipo
     * @param $email
     */
    public function update($nome, $cognome, $recapito, $password, $tipo, $email)
    {
        $this->sql = $this->con->prepare("UPDATE Utente
                     SET nome = ?,
                         cognome = ?,
                         recapito = ?,
                         password = ?,
                         tipo = ?
                     WHERE email = ?;");
        parent::query(array($nome, $cognome, $recapito, $password, $tipo, $email));
    }

    /**
     * @param $email
     */
    public function delete($email)
    {
        $this->sql = $this->con->prepare("DELETE FROM Utente WHERE email = ?;");
        parent::query(array($email));
    }

}