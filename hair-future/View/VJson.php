<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 05/10/17
 * Time: 18.35
 */

class VJson
{
    public function invia($data)
    {
        $json = json_encode($data);
        header('Content-type: application/json');
        header('Access-Control-Allow-Origin: http://localhost:63342','*',false);
        echo($json);
    }

    public function ricevi()
    {
        return json_decode(file_get_contents('php://input'),true);
    }
}