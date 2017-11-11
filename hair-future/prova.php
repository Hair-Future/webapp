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




// CREAZIONE DEGLI UTENTI NEL DB
$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Carlo", "Attardi",
    "3236020450", "carlo@hairfuture.com", "hairfuture", "Direttore");
$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Lorenza", "Pasquini",
    "3432424432", "lorenza@hairfuture.com", "hairfuture", "Direttore");
$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Marco", "Stigliano",
    "3263263684", "marco@hairfuture.com", "hairfuture", "Direttore");






$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Carl", "Johnson",
    "3212530891", "cj@sanandreas.com", "grovestreet4life", "Cliente");
$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Sean", "Johnson",
    "3152407845", "sweet@sanandreas.com", "grovestreet4life", "Cliente");
$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Melvin", "Harris",
    "3576892790", "bigsmoke@sanandreas.com", "greensabre", "Cliente");
$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Lance", "Wilson",
    "3230401151", "ryder@sanandreas.com", "smokeeveryday", "Cliente");




print "Sono stati ineriti nel db i seguenti utenti:\n";
foreach ($nuoviUtenti as $item) {
    print $item."\n\n\n";
}




//CREAZIONE DEI SERVIZI E CATEGORIE NEL DB


$reece = EGestoreUtenti::ottieniUtenteByID("oldreece@hairfuture.com");


$reece->creaCategoria("Acconciatura","Per ogni occasione");
$reece->creaCategoria("Piega","Ricci, lisci o semplici");
$reece->creaCategoria("Taglio","Qui puoi trovare ogni genere di taglio");
$reece->creaCategoria("Colorazione","Da quella totale alle extension");


$reece->creaServizio("Raccolta","", 22, 30, "Acconciatura");
$reece->creaServizio("Mossi lunghi","", 22, 30, "Piega");
$reece->creaServizio("Taglio normale","", 19, 30, "Taglio");
$reece->creaServizio("Spuntata","", 15, 30, "Taglio");
$reece->creaServizio("Taglio frangia", "", 5, 30, "Taglio");
$reece->creaServizio("Capelli corti", "", 15, 30, "Piega");
$reece->creaServizio("Capelli lunghi", "", 17, 30, "Piega");
$reece->creaServizio("Piastra capelli corti", "", 18, 30, "Piega");
$reece->creaServizio("Piastra capelli lunghi", "", 20, 30, "Piega");
$reece->creaServizio("Mossi corti", "", 20, 30, "Piega");
$reece->creaServizio("Treccia semplice", "", 20, 30, "Acconciatura");
$reece->creaServizio("Treccia attaccata", "", 25, 30, "Acconciatura");
$reece->creaServizio("Da sposa", "", 130, 90, "Acconciatura");
$reece->creaServizio("A pigmenti", "Dura alcuni lavaggi", 14, 30, "Colorazione");
$reece->creaServizio("Permanente", "Dura a lungo", 36, 60, "Colorazione");
$reece->creaServizio("Extension", "", 25, 60, "Colorazione");



//INSERIMENTO DI APPUNTAMENTI VARI





$catalogo = new ECatalogoServizi();


$servizi[] = $catalogo->ottieniServizioByCodice(2);
$servizi[] = $catalogo->ottieniServizioByCodice(3);


$cj = EGestoreUtenti::ottieniUtenteByID("cj@sanandreas.com");
$cj->prenotaAppuntamento($servizi, "2017-12-12", "09:00:00");

$altriServizi[] = $catalogo->ottieniServizioByCodice(2);


$cj->prenotaAppuntamento($altriServizi, "2017-11-12", "10:00:00");