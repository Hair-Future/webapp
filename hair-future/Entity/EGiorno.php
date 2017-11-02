<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 01/11/2017
 * Time: 19:01
 */

class EGiorno
{
    /**
     * @AttributeType string
     */
    private $nome;

    /**
     * @AttributeType string
     */
    private $aperturaMattina;
    /**
     * @AttributeType string
     */
    private $aperturaPomeriggio;
    /**
     * @AttributeType string
     */
    private $chiusuraMattina;
    /**
     * @AttributeType string
     */
    private $chiusuraPomeriggio;

    public function __construct(){}

    public function loadByValori($values){
        $this->nome = $values['giorno'];
        $this->aperturaMattina = $values['aperturaMattina'];
        $this->aperturaPomeriggio = $values['aperturaPomeriggio'];
        $this->chiusuraMattina = $values['chiusuraMattina'];
        $this->chiusuraPomeriggio = $values['chiusuraPomeriggio'];
        return $this;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return string
     */
    public function getAperturaMattina()
    {
        return $this->aperturaMattina;
    }

    /**
     * @return string
     */
    public function getAperturaPomeriggio()
    {
        return $this->aperturaPomeriggio;
    }

    /**
     * @return string
     */
    public function getChiusuraMattina()
    {
        return $this->chiusuraMattina;
    }

    /**
     * @return string
     */
    public function getChiusuraPomeriggio()
    {
        return $this->chiusuraPomeriggio;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @param string $aperturaMattina
     */
    public function setAperturaMattina($aperturaMattina)
    {
        $this->aperturaMattina = $aperturaMattina;
    }

    /**
     * @param string $aperturaPomeriggio
     */
    public function setAperturaPomeriggio($aperturaPomeriggio)
    {
        $this->aperturaPomeriggio = $aperturaPomeriggio;
    }

    /**
     * @param string $chiusuraMattina
     */
    public function setChiusuraMattina($chiusuraMattina)
    {
        $this->chiusuraMattina = $chiusuraMattina;
    }

    /**
     * @param string $chiusuraPomeriggio
     */
    public function setChiusuraPomeriggio($chiusuraPomeriggio)
    {
        $this->chiusuraPomeriggio = $chiusuraPomeriggio;
    }

    public function difference($apertura, $chiusura){
        $open = strtotime($apertura);
        $close = strtotime($chiusura);
        return ( $close - $open) / 60;
    }
}