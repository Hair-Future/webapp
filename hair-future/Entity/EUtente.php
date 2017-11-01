<?php

/**
 * Created by PhpStorm.
 * User: loren
 * Date: 27/05/2017
 * Time: 16:45
 */

/**
 * Class EUtente
 */

abstract class EUtente
{
    /** @AttributeType string */
    private $nome="";
    /** @AttributeType string */
    private $cognome="";
    /** @AttributeType int */
    private $recapito;
    /** @AttributeType string */
    private $email="";
    /** @AttributeType string */
    private $password;


    /**
     *
     */
    private function update()
    {
        $Caronte = new FUtente();
        $Caronte->update($this->nome,$this->cognome,$this->recapito,$this->password,$this->getTipo(),$this->email);
    }


    /**
     * EUtente constructor.
     */
    public function __construct() {}


    public function loadByID($risultati)
    {
        $this->nome = $risultati['nome'];
        $this->cognome = $risultati['cognome'];
        $this->recapito = $risultati['recapito'];
        $this->email = $risultati['email'];
        $this->password = $risultati['password'];
    }

    /**
     * @param $nome
     * @param $cognome
     * @param $recapito
     * @param $email
     * @param $password
     * @return mixed
     */
    public function addUtente($nome, $cognome, $recapito, $email, $password)
    {
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->recapito = $recapito;
        $this->email = $email;
        $this->password = $password;
        $db= new FUtente();
        return $db->insert($nome, $cognome, $recapito, $email, $password,$this->getTipo());
    }

    /**
     * @return string
     */

    public function __toString()
    {
        return "$this->nome | $this->cognome | $this->recapito | $this->email | $this->password | ".$this->getTipo();
    }

    /**
     * @return array
     */
    public function convertiInArray()
    {
        $attributi = array();
        $attributi['nome'] = $this->nome;
        $attributi['cognome'] = $this->cognome;
        $attributi['telefono'] = $this->recapito;
        $attributi['email'] = $this->email;
        //$attributi['password'] = $this->password;
        $attributi['tipo'] = $this->getTipo();
        return $attributi;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return mixed
     */
    public function getCognome()
    {
        return $this->cognome;
    }

    /**
     * @return mixed
     */
    public function getRecapito()
    {
        return $this->recapito;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    abstract function getTipo();

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        $this->update();
    }

    /**
     * @param mixed $cognome
     */
    public function setCognome($cognome)
    {
        $this->cognome = $cognome;
        $this->update();
    }

    /**
     * @param mixed $recapito
     */
    public function setRecapito($recapito)
    {
        $this->recapito = $recapito;
        $this->update();
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
        $this->update();
    }

    /**
     *
     */
    public function rimuoviDefinitivamente()
    {
        $Caronte = new FUtente();
        $Caronte->delete($this->email);
    }

    /**
     * @param $email
     * @param $listaServizi
     * @param $data
     * @param $ora
     */
    public function prenotaAppuntamento($email, $listaServizi, $data, $ora)
    {
        $catalogo = USingleton::getInstance('ECatalogoAppuntamenti');
        $catalogo->prenotaAppuntamento($email, $listaServizi, $data, $ora);
    }

    /**
     * @param $id
     * @param $data
     * @param $ora
     * @param $email
     */
    public function modificaAppuntamento($id, $data, $ora, $email)
    {
        $catalogo = USingleton::getInstance('ECatalogoAppuntamenti');
        $catalogo->modificaAppuntamento($id, $data, $ora, $email);
    }

    /**
     * @param $id
     * @param $email
     */
    public function cancellaAppuntamento($id, $email)
    {
        $catalogo = USingleton::getInstance('ECatalogoAppuntamenti');
        $catalogo->cancellaAppuntamento($id, $email);
    }

    /**
     * @param $email
     * @return array
     *
     */
    public function ottieniListaServizi($email)
    {
        $catalogo = USingleton::getInstance('ECatalogoAppuntamenti');
        return $catalogo->searchAppuntamentoByUtente($email);
    }
}