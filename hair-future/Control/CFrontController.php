<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 10/10/17
 * Time: 18.24
 */

class CFrontController
{
    public function run()
    {
        $Mercurio = new VJson();
        $sceltaController = $Mercurio->ricevi();
        if ($sceltaController['richiesta'] == 'registrazione')
        {
            $registrazione = new CRegistrazione();
            $registrazione->Registra();
        }
        elseif ($sceltaController['richiesta'] == 'login')
        {
            $login = new CLogin();
            $login->effettuaLogin();
        }
        elseif ($sceltaController['richiesta'] == 'sceltaServizi')
        {
            $inviaServizi = new CPrenotazione();
            $inviaServizi->inviaTuttiServizi();
        }
        elseif ($sceltaController['richiesta'] == 'durataListaServizi')
        {
            $durata = new CPrenotazione();
            $durata->inviaDurataListaServizi();
        }
    }
}