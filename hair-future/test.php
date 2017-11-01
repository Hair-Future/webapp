<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 01/11/2017
 * Time: 15:42
 */

require_once 'includes/autoload.inc.php';
require_once 'includes/config.inc.php';
require_once 'FrontController.php';

$catalogo = new ECatalogoServizi();
$stat = new EStatistiche();
print($stat->maxSpesaUtente('2017-10-20', '2017-10-31') . "<br />");
print($stat->guadagno('2017-10-20', '2017-10-31'));