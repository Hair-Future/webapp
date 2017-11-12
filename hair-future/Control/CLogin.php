<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 11/10/17
 * Time: 10.00
 */

class CLogin
{
    /**
     *
     */
    public function effettuaLogin()
    {
        $Mercurio = new VLogin();
        $password = $Mercurio->ottieniPassword();
        $email = $Mercurio->ottieniEmail();

        $sessione = USingleton::getInstance('CSession');

        $utente = EGestoreUtenti::autenticaUtente($email, $password);
        $sessione->impostaValore('utente', $utente);

        $Mercurio->inviaUtente($utente);
    }

    /**
     * permette di verificare se il login è stato eseguito correttamente.
     * in caso di successo verranno restituiti al client i dati relativi all'utente.
     * in caso di fallimento verrà restituito false o -1.
     */
    public function check()
    {
        $Mercurio = new VLogin();
        $sessione = USingleton::getInstance('CSession');

        $utente = $sessione->leggiValore('utente');

        $Mercurio->inviaUtente($utente);
    }

    /**
     *
     */
    public function effettuaLogout()
    {
        $session = USingleton::getInstance('CSession');
        $session->__destroy();
    }
}