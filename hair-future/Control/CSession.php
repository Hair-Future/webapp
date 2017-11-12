<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 11/10/17
 * Time: 9.37
 */

class CSession
{
    public function __construct()
    {
        session_start();
        ini_set('session.name', "PHPSESSID_Hair-Future");
        ini_set('session.cookie_lifetime', '1800');
        ini_set('session.gc_maxlifetime', '1800');
        ini_set('session.cookie_httponly', 'true');
        $this->Session();
    }

    public function __destroy()
    {
        session_destroy();
    }
    public function Session()
    {
        if (!isset($_SESSION['count']))
        {
            $_SESSION['count'] = 0;
            $_SESSION['start'] = time();
        }
        $_SESSION['count']++;
    }
    function impostaValore($chiave,$valore) {
        $_SESSION[$chiave]=$valore;
    }
    function cancellaValore($chiave) {
        unset($_SESSION[$chiave]);
    }
    function leggiValore($chiave) {
        if (isset($_SESSION[$chiave]))
            return $_SESSION[$chiave];
        else
            return false;
    }
}