<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 11/11/17
 * Time: 17.27
 */

require_once 'includes/autoload.inc.php';
require_once 'includes/config.inc.php';
require_once 'FrontController.php';

// CREAZIONE DEGLI UTENTI NEL DB
$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Carlo", "Attardi",
    "3236020450", "carlo@hairfuture.com", "hairfuture", "Direttore");
$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Lorenza", "Pasquini",
    "3432424432", "lorenza@hairfuture.com", "hairfuture", "Direttore");
$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Marco", "Stigliano",
    "3263263684", "marco@hairfuture.com", "hairfuture", "Direttore");






$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Marzia", "Toscani",
    "3212530891", "marzia.toscani@hairfuture.it", "hairfuture", "Cliente");

$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Veneranda", "Calabrese",
    "3345543891", "veneranda.calabrese@hairfuture.it", "hairfuture", "Cliente");

$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Maia", "Lucchesi",
    "0394 7887359", "MaiaLucchesi@teleworm.us", "hairfuture", "Cliente");

$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Maddalena", "Arcuri",
    "0372 9127469", "MaddalenaArcuri@rhyta.com", "hairfuture", "Cliente");

$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Gemma", "Fallaci",
    "0371 4133587", "GemmaFallaci@dayrep.com", "hairfuture", "Cliente");

$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Angelina", "Pagnotto",
    "0339 2484509", "AngelinaPagnotto@armyspy.com", "hairfuture", "Cliente");

$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Vincenza", "Lucchesi",
    "0320 8560393", "VincenzaLucchesi@teleworm.us", "hairfuture", "Cliente");

$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Angela", "Marino",
    "0376 0179418", "AngelaMarino@dayrep.com", "hairfuture", "Cliente");




print "Sono stati ineriti nel db i seguenti utenti:\n";
foreach ($nuoviUtenti as $item) {
    print $item."\n\n\n";
}



//CREAZIONE DEI SERVIZI E CATEGORIE NEL DB


$carlo = EGestoreUtenti::ottieniUtenteByID("carlo@hairfuture.com");


$carlo->creaCategoria("Acconciatura","Per ogni occasione");
$carlo->creaCategoria("Piega","Ricci, lisci o semplici");
$carlo->creaCategoria("Taglio","Qui puoi trovare ogni genere di taglio");
$carlo->creaCategoria("Colorazione","Da quella totale alle extension");


$carlo->creaServizio("Raccolta","", 22, 30, "Acconciatura");
$carlo->creaServizio("Mossi lunghi","", 22, 30, "Piega");
$carlo->creaServizio("Taglio normale","", 19, 30, "Taglio");
$carlo->creaServizio("Spuntata","", 15, 30, "Taglio");
$carlo->creaServizio("Taglio frangia", "", 5, 30, "Taglio");
$carlo->creaServizio("Capelli corti", "", 15, 30, "Piega");
$carlo->creaServizio("Capelli lunghi", "", 17, 30, "Piega");
$carlo->creaServizio("Piastra capelli corti", "", 18, 30, "Piega");
$carlo->creaServizio("Piastra capelli lunghi", "", 20, 30, "Piega");
$carlo->creaServizio("Mossi corti", "", 20, 30, "Piega");
$carlo->creaServizio("Treccia semplice", "", 20, 30, "Acconciatura");
$carlo->creaServizio("Treccia attaccata", "", 25, 30, "Acconciatura");
$carlo->creaServizio("Da sposa", "", 130, 90, "Acconciatura");
$carlo->creaServizio("A pigmenti", "Dura alcuni lavaggi", 14, 30, "Colorazione");
$carlo->creaServizio("Permanente", "Dura a lungo", 36, 60, "Colorazione");
$carlo->creaServizio("Extension", "", 25, 60, "Colorazione");


