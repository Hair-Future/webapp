<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 31/10/2017
 * Time: 15:40
 */

class VRegistrazione extends VJson
{
/*
    public function getNome(){
        $dati = $this->ricevi();
        $nome = $dati['dati']['nome'];
        return $nome;
    }

    public function getCognome(){
        $dati = $this->ricevi();
        $cognome = $dati['dati']['cognome'];
        return $cognome;
    }

    public function getTelefono(){
        $dati = $this->ricevi();
        $telefono = $dati['dati']['telefono'];
        return $telefono;
    }

    public function getMail(){
        $dati = $this->ricevi();
        $mail = $dati['dati']['email'];
        return $mail;
    }

    public function getPassword(){
        $dati = $this->ricevi();
        $password = $dati['dati']['password'];
        return $password;
    }

    public function getTipo(){
        $dati = $this->ricevi();
        $tipo = $dati['dati']['tipo'];
        return $tipo;
    }

    public function ottieniDati()
    {
        $dati['nome'] = $this->getNome();
        $dati['cognome'] = $this->getCognome();
        $dati['telefono'] = $this->getTelefono();
        $dati['email'] = $this->getMail();
        $dati['password'] = $this->getPassword();
        $dati['tipo'] = $this->getTipo();
        return $dati;
    }

*/

    /**
     * @return array
     * il metodo riceve i dati della registrazione dal client e ritorna un array contente suddetti dati
     */
    public function ottieniDati(){
        $dati = $this->ricevi();
        return $dati['dati'];
    }
}