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
    private static $semaforo = false;

    private static function &getConnection($className)
    {
        if (is_null(FDb::$connection) || (FDb::$semaforo != $className))
        {
            global $config;
            try {
                FDb::$connection = new PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
            }catch(PDOException $e){
                print "Error!: " . $e->getMessage() . ".<br/>";
                die();
            }
            return FDb::$connection;
        }
        else
            return FDb::$connection;
    }

    protected static function lock($nomeTabella)
    {
        self::$connection = self::getConnection("F".$nomeTabella);
        $sql = self::$connection->prepare("LOCK TABLES ? WRITE");
        $sql->execute(array($nomeTabella));
        self::$semaforo = "F".$nomeTabella;
    }

    protected static function unlock()
    {
        $sql = self::$connection->prepare("UNLOCK TABLES");
        $sql->execute();
        self::$connection = null;
        self::$semaforo = FALSE;
    }

    /**
     * FDb constructor.
     */

    public function __construct(){

        $this->con = self::getConnection(get_class($this));
    }

    /**
     *
     */
    public function __destruct()
    {
        if (!self::$semaforo)
            self::$connection = null;
        $this->con = null;
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
