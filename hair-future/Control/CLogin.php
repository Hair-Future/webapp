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
        $Mercurio = new VJson();
        $sessione = USingleton::getInstance('CSession');
        $sessione->Session();
        $dati = $Mercurio->ricevi();
        $sessione->impostaValore('email', $dati['email']);
        $sessione->impostaValore('password', $dati['password']);
        $utente = EGestoreUtenti::ottieniUtenteByID($dati['email'], $dati['password']);
        if (!is_bool($utente))
            $Mercurio->invia($utente->convertiInArray());
        else
            $Mercurio->invia($utente);
    }
}