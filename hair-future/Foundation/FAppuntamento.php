<?php

/**
 * Created by PhpStorm.
 * User: toki
 * Date: 28/05/17
 * Time: 18.02
 */
class FAppuntamento extends FDb{

    public function __construct(){
        parent::__construct();
    }

    public static function lock()
    {
        parent::lock("Appuntamento");
    }

    public static function unlock()
    {
        parent::unlock();
    }

    /**
     * @param string $codice
     * @return array
     */
    public function search($data, $ora)
    {
        $this->sql = $this->con->prepare("SELECT *
                      FROM Appuntamento
                      WHERE data >= ? AND ora >= ?
                      ORDER BY `Appuntamento`.`ora` ASC;");
        return parent::search(array($data, $ora));
    }

    public function searchByPeriodo($values)
    {
        $this->sql = $this->con->prepare("SELECT *
                      FROM Appuntamento
                      WHERE data >= ? and data <= ?
                      ORDER BY `Appuntamento`.`ora` ASC;");
        return parent::search($values);
    }

    /**
     * @param array $values
     */
    public function insert($values)
    {
        $this->sql = $this->con->prepare("INSERT INTO Appuntamento(data, ora, durata, costo, utente, listaServizi)
                      VALUES (?,?,?,?,?,?)");
        parent::query($values);
    }

    /**
     * @param array $values
     */
    public function update($values){
        $this->sql = $this->con->prepare("UPDATE Appuntamento
                     SET data = ?,
                         ora = ?,
                         durata = ?,
                         costo = ?,
                         utente = ?,
                         listaServizi = ?
                     WHERE codice = ?;");
        parent::query($values);
    }

    public function done($id)
    {
        $this->sql = $this->con->prepare("UPDATE Appuntamento
                     SET effettuato = TRUE 
                     WHERE codice = ?;");
        return parent::query(array($id));
    }

    /**
     * @param string $codice
     */
    public function delete($codice){
        $this->sql = $this->con->prepare("DELETE FROM Appuntamento WHERE codice=?;");
        parent::query(array($codice));
    }

}
