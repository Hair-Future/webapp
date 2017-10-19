<?php

/**
 * Created by PhpStorm.
 * User: loren
 * Date: 02/06/2017
 * Time: 17:12
 */

/**
 * Class ECliente
 */

class ECliente extends EUtente
{

    function getTipo()
    {
        return "Cliente";
    }

    public function prenotaAppuntamento($listaServizi, $data, $ora)
    {
        parent::prenotaAppuntamento($this->getEmail(), $listaServizi, $data, $ora);
    }

    public function modificaAppuntamento($id, $data, $ora)
    {
        return parent::modificaAppuntamento($id, $data, $ora, $this->getEmail());
    }

    public function cancellaAppuntamento($id)
    {
        parent::cancellaAppuntamento($id, $this->getEmail());
    }

    public function ottieniListaServizi()
    {
        return parent::ottieniListaServizi($this->getEmail()); // TODO: Change the autogenerated stub
    }

}