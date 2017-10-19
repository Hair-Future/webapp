<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 11/10/17
 * Time: 14.21
 */

class USingleton
{
    public static function getInstance($classe)
    {
        if( ! isset( self::$instances[$classe] ) )
        {
            self::$instances[$classe] = new $classe;
        }
        return self::$instances[$classe];
    }
}