<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 11/10/17
 * Time: 14.21
 */

class USingleton
{
    /**
     * La variabile statica privata che conterrà l'istanza univoca
     * della nostra classe.
     */
    private static $instances = array();

    /**
     * Il costruttore in cui ci occuperemo di inizializzare la nostra
     * classe. E' opportuno specificarlo come privato in modo che venga
     * visualizzato automaticamente un errore dall'interprete se si cerca
     * di istanziare la classe direttamente.
     */
    private function __construct()
    {
        // vuoto
    }

    /**
     * Il metodo statico che si occupa di restituire l'istanza univoca della classe.
     */
    public static function getInstance($nomeClasse)
    {
        if( ! isset( self::$instances[$nomeClasse] ) )
        {
            self::$instances[$nomeClasse] = new $nomeClasse;
        }
        return self::$instances[$nomeClasse];
    }
}