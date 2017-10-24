<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 24/10/17
 * Time: 18.09
 */

require_once 'includes/autoload.inc.php';
require_once 'includes/config.inc.php';
require_once 'FrontController.php';
/*
$catalogo = new ECatalogoAppuntamenti();
$intervalli = $catalogo->ottieniIntervalliOccupati(90, date("Y-m-d"));
var_dump($intervalli);
*/

$catalogo = new ECatalogoServizi();
$macisla = EGestoreUtenti::ottieniUtenteByID("macisla@hairfuture.com");
$servizi[] = $catalogo->ottieniServizioByCodice(15);
$servizi[] = $catalogo->ottieniServizioByCodice(18);
$macisla->prenotaAppuntamento("cj@sanandreas.com",$servizi, "2017-10-27", "12:00:00");

$servizi = null;
$servizi[] = $catalogo->ottieniServizioByCodice(10);
$servizi[] = $catalogo->ottieniServizioByCodice(21);
$servizi[] = $catalogo->ottieniServizioByCodice(19);
$macisla->prenotaAppuntamento("cj@sanandreas.com",$servizi, "2017-10-27", "17:00:00");

$servizi = null;
$servizi[] = $catalogo->ottieniServizioByCodice(9);
$servizi[] = $catalogo->ottieniServizioByCodice(21);
$servizi[] = $catalogo->ottieniServizioByCodice(19);
$macisla->prenotaAppuntamento("cj@sanandreas.com",$servizi, "2017-10-27", "18:00:00");

$servizi = null;
$servizi[] = $catalogo->ottieniServizioByCodice(9);
$servizi[] = $catalogo->ottieniServizioByCodice(21);
$servizi[] = $catalogo->ottieniServizioByCodice(19);
$macisla->prenotaAppuntamento("cj@sanandreas.com",$servizi, "2017-10-27", "09:00:00");



$servizi[] = $catalogo->ottieniServizioByCodice(15);
$servizi[] = $catalogo->ottieniServizioByCodice(14);
$macisla->prenotaAppuntamento("cj@sanandreas.com",$servizi, "2017-10-26", "11:00:00");

$servizi = null;
$servizi[] = $catalogo->ottieniServizioByCodice(23);
$servizi[] = $catalogo->ottieniServizioByCodice(13);
$servizi[] = $catalogo->ottieniServizioByCodice(20);
$macisla->prenotaAppuntamento("cj@sanandreas.com",$servizi, "2017-10-26", "15:00:00");

$servizi = null;
$servizi[] = $catalogo->ottieniServizioByCodice(8);
$servizi[] = $catalogo->ottieniServizioByCodice(3);
$servizi[] = $catalogo->ottieniServizioByCodice(2);
$macisla->prenotaAppuntamento("cj@sanandreas.com",$servizi, "2017-10-26", "18:00:00");

$servizi = null;
$servizi[] = $catalogo->ottieniServizioByCodice(22);
$servizi[] = $catalogo->ottieniServizioByCodice(14);
$servizi[] = $catalogo->ottieniServizioByCodice(10);
$macisla->prenotaAppuntamento("cj@sanandreas.com",$servizi, "2017-10-26", "16:00:00");
