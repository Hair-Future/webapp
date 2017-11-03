<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 26/10/17
 * Time: 10.10
 */

class VLogin extends VJson
{
    public function ottieniEmail()
    {
        $dati = $this->ricevi();
        $email = $dati["dati"]['email'];
        return $email;
    }

    public function ottieniPassword()
    {
        $dati = $this->ricevi();
        $password = $dati["dati"]['password'];
        return $password;
    }

    public function inviaUtente($utente)
    {
        if (!is_bool($utente) && !is_int($utente))
            $this->invia($utente->convertiInArray());
        else
            $this->invia($utente);

    }

    /**
     * return bool
     */
    public function effettuaLogout()
    {
        //TODO
    }
}