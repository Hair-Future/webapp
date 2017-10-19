<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 05/10/17
 * Time: 17.54
 */

class CRegistrazione
{
    public function Registra()
    {
        $Mercurio = new VJson();
        $data = $Mercurio->ricevi();
        $dati = $data["dati"];
        $utente = EGestoreUtenti::creaNuovoUtente($dati["nome"], $dati["cognome"], $dati["telefono"],
            $dati["email"], $dati["password"], "Cliente");
        if (!is_int($utente))
            $Mercurio->invia($utente->convertiInArray());
        else
            $Mercurio->invia($utente);
    }

}