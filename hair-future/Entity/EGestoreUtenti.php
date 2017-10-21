<?php

/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 20/08/17
 * Time: 15.48
 */
class EGestoreUtenti
{
    /**
     * @param $email
     * @return ECliente|EDipendente|EDirettore|int
     */
    public static function ottieniUtenteByID($email)
    {
        $Caronte = new FUtente();
        $result = $Caronte->searchById($email);
        if ($result['tipo'] == 'Cliente')
        {
            $Cliente = new ECliente();
            $Cliente->loadByID($result);
            return $Cliente;
        }
        elseif ($result['tipo'] == 'Dipendente')
        {
            $Dipendente = new EDipendente();
            $Dipendente->loadByID($result);
            return $Dipendente;
        }
        elseif ($result['tipo'] == 'Direttore')
        {
            $Direttore = new EDirettore();
            $Direttore->loadByID($result);
            return $Direttore;
        }
        else
            return -1;
    }

    /**
     * @param $nome
     * @param $cognome
     * @param $recapito
     * @param $email
     * @param $password
     * @param $tipo
     * @return ECliente|EDipendente|EDirettore|int
     */
    public static function creaNuovoUtente($nome, $cognome, $recapito, $email, $password, $tipo)
    {
        if (!is_string($nome) or !is_string($cognome) or !is_string($recapito) or !is_string($email) or
            !is_string($password) or !is_string($tipo))
        {
            return -1;
        }
        elseif ($tipo == 'Cliente')
        {
            $Cliente = new ECliente();
            $check = $Cliente->addUtente($nome, $cognome, $recapito, $email, $password);
            if ($check)
                return $Cliente;
            else
                return -1;
        }
        elseif ($tipo == 'Dipendente')
        {
            $Dipendente = new EDipendente();
            $check = $Dipendente->addUtente($nome, $cognome, $recapito, $email, $password);
            if ($check)
                return $Dipendente;
            else
                return -1;
        }
        elseif ($tipo == 'Direttore')
        {
            $Direttore = new EDirettore();
            $check = $Direttore->addUtente($nome, $cognome, $recapito, $email, $password);
            if ($check)
                return $Direttore;
            else
                return -1;
        }
        else
            return -1;
    }

    public static function autenticaUtente($email, $password)
    {
        $Caronte = new FUtente();
        $result = $Caronte->searchByEmailPassword($email, $password);
        if ($result['tipo'] == 'Cliente')
        {
            $Cliente = new ECliente();
            $Cliente->loadByID($result);
            return $Cliente;
        }
        elseif ($result['tipo'] == 'Dipendente')
        {
            $Dipendente = new EDipendente();
            $Dipendente->loadByID($result);
            return $Dipendente;
        }
        elseif ($result['tipo'] == 'Direttore')
        {
            $Direttore = new EDirettore();
            $Direttore->loadByID($result);
            return $Direttore;
        }
        else
            return -1;
    }

}