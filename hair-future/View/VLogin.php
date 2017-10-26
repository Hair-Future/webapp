<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 26/10/17
 * Time: 10.10
 */

class VLogin extends VJson
{
    public function effettuaLogin()
    {
        $sessione = USingleton::getInstance('CSession');
        $sessione->Session();
        $dati = $this->ricevi();
        $dati = $dati["dati"];
        $sessione->impostaValore('email', $dati['email']);
        $sessione->impostaValore('password', $dati['password']);
        return $dati;
    }

    /**
     * return bool
     */
    public function effettuaLogout()
    {
        //TODO
    }
}