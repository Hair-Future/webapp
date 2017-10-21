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
        $Mercurio = USingleton::getInstance('VJson');
        $sessione = USingleton::getInstance('CSession');
        $sessione->Session();
        $data = $Mercurio->ricevi();
        $dati = $data["dati"];
        $sessione->impostaValore('email', $dati['email']);
        $sessione->impostaValore('password', $dati['password']);
        $utente = EGestoreUtenti::autenticaUtente($dati['email'], $dati['password']);
        if (!is_bool($utente))
            $Mercurio->invia($utente->convertiInArray());
        else
            $Mercurio->invia($utente);
    }
}