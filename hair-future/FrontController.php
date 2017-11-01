<?php

/**
 * Created by PhpStorm.
 * User: HP User
 * Date: 27/06/2017
 * Time: 15:39
 */

class FrontController
{
    private $controller = null;
    private $metodo = null;
    private $json = null;


    public function __construct()
    {
        $this->json = new VJson();
        $this->parseUri();
    }

    public function parseUri()
    {
        $dati = $this->json->ricevi();
        $this->controller = $dati['richiesta']['controller'];
        $this->metodo=$dati['richiesta']['metodo'];
        //print_r($this->controller);
        //print_r($this->task);

    }


    public function run()
    {
        if (!$this->controller) {
            header('location: Client/index.html');
        } else {
            $this->route();

        }
    }



    private function route()
    {

        if (file_exists("Control/") . $this->controller . ".php") {
            $this->controller = new $this->controller();

            if (method_exists($this->controller, $this->metodo)) {
                $this->controller->{$this->metodo}();
                }
                else {
                echo "Non è stato trovato il task";
            } }
            else {
                echo "controller not found";
            }
        }
}
