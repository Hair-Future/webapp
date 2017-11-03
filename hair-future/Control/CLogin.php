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
        $sessione->Session();
        $sessione->impostaValore('email', $email);
        $sessione->impostaValore('password', $password);

        $utente = EGestoreUtenti::autenticaUtente($email, $password);

        $Mercurio->inviaUtente($utente);
    }

    /**
     * permette di verificare se il login è stato eseguito correttamente.
     * in caso di successo verranno restituiti al client i dati relativi all'utente.
     * in caso di fallimento verrà rretituito false o -1.
     */
    public function check()
    {
        $Mercurio = new VLogin();
        $sessione = USingleton::getInstance('CSession');

        $email = $sessione->leggiValore('email');
        $utente = EGestoreUtenti::ottieniUtenteByID($email);

        $Mercurio->inviaUtente($utente);
    }

    /**
     *
     */
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