<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 11/10/17
 * Time: 10.00
 */

class CLogin
{
    public function effettuaLogin()
    {
        $Mercurio = new VLogin();
        $dati = $Mercurio->effettuaLogin();
        $utente = EGestoreUtenti::autenticaUtente($dati['email'], $dati['password']);
        if (!is_bool($utente))
            $Mercurio->invia($utente->convertiInArray());
        else
            $Mercurio->invia($utente);
    }

    public function effettuaLogout()
    {
        $Mercurio = new VLogin();
        $comando = $Mercurio->effettuaLogout();
        if ($comando)
        {
            $session = USingleton::getInstance('CSession');
            $session->__destroy();
        }
    }
}