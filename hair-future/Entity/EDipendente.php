<?php

/**
 * Created by PhpStorm.
 * User: loren
 * Date: 02/06/2017
 * Time: 17:12
 */

/**
 * Class EDipendente
 */

class EDipendente extends EUtente
{

    function getTipo()
    {
       return "Dipendente";
    }

    //fatti per conto di un cliente
    public function prenotaAppuntamento($email, $listaServizi, $data, $ora)
    {
        return parent::prenotaAppuntamento($email, $listaServizi, $data, $ora); // TODO: Change the autogenerated stub
    }

    public function modificaAppuntamento($id, $data, $ora, $email)
    {
        parent::modificaAppuntamento($id, $data, $ora, $email); // TODO: Change the autogenerated stub
    }

    public function cancellaAppuntamento($id, $email)
    {
        parent::cancellaAppuntamento($id, $email); // TODO: Change the autogenerated stub
    }
}