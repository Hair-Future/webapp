<?php

/**
 * Created by PhpStorm.
 * User: toki
 * Date: 26/05/17
 * Time: 19.14
 */
class FDb{
    protected $con;
    protected $_result;
    protected $sql;
    private static $connection;

    private static function &getConnection()
    {
        if (!is_null(FDb::$connection))
        {
            global $config;
            try {
                FDb::$connection= new PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
            }catch(PDOException $e){
                print "Error!: " . $e->getMessage() . ".<br/>";
                die();
            }
            return FDb::$connection;
        }
        else
            return FDb::$connection;
    }

    /**
     * FDb constructor.
     */

    public function __construct(){

        $this->con = FDb::getConnection();
    }

    /**
     *
     */
    public function __destruct()
    {
        //$this->con = null;
    }

    /**
     * @return array se la query è ben posta
     *         null se è mal posta
     */
    public function searchAll()
    {
        $this->sql->execute();
        $this->_result = $this->sql->fetchAll(PDO::FETCH_ASSOC);
        return $this->_result;
    }

    /**
     * @array $id
     * @return array associativo corrispondente alla tupla cercata dove le chiavi corrispondono
     *                  ai nomi degli attributi della tabella nel db in cui è contenuta
     */
    public function searchById($id){
        $this->sql->execute($id);
        $this->_result = $this->sql->fetch(PDO::FETCH_ASSOC); //mi mette in un array i risultati della query
        return $this->_result;
    }

    /**
     * @array $values
     * @return array  di array associativi corrispondenti alle tuple cercate dove le chiavi corrispondono
     *                  ai nomi degli attributi della tabella nel db in cui è contenuta
     */
    public function search($values){
        $this->sql->execute($values);
        $this->_result = $this->sql->fetchAll(PDO::FETCH_ASSOC); //mi mette in un array i risultati della query
        return $this->_result;
    }

    /**
     * @param array $values
     */
    public function query($values){
        return $this->sql->execute($values);
    }

    public function queryNoValues(){
        return $this->sql->execute();
    }

}
