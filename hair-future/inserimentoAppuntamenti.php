<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 11/11/17
 * Time: 17.28
 */

require_once 'includes/autoload.inc.php';
require_once 'includes/config.inc.php';
require_once 'FrontController.php';

//INSERIMENTO DI APPUNTAMENTI VARI
$idUtenti = array("marzia.toscani@hairfuture.it", "veneranda.calabrese@hairfuture.it", "MaiaLucchesi@teleworm.us",
    "MaddalenaArcuri@rhyta.com", "GemmaFallaci@dayrep.com", "AngelinaPagnotto@armyspy.com", "VincenzaLucchesi@teleworm.us",
    "AngelaMarino@dayrep.com");

$catalogo = new ECatalogoServizi();

$aBuonFine = 0;

for ($i = 0; $i < 500; $i++)
{
    $servizi = array();
    $lim = rand(2, 5);
    for ($j = 0; $j < $lim; $j++)
    {
        $servizi[] = $catalogo->ottieniServizioByCodice(rand(1,16));
    }
    $rand = rand(0, 7);
    $id = $idUtenti[$rand];
    $signora = EGestoreUtenti::ottieniUtenteByID($id);

    $date = new DateTime(date("Y-m-d H:i:s",rand(strtotime('2017-10-01'),strtotime('2017-12-23'))));
    $ret = $signora->prenotaAppuntamento($servizi, $date->format('Y-m-d'), ''.rand(9,19).':00:00');
    if ($ret == 0)
    {
        $aBuonFine++;
    }
}


$catalogo = new ECatalogoAppuntamenti();
for ($i=0; $i<500; $i++)
{
    $rand = rand(1, $aBuonFine);
    $catalogo->segnaEffettuato($rand);
}