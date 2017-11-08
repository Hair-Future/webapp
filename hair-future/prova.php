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
$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Carl", "Johnson",
    "3212530891", "cj@sanandreas.com", "grovestreet4life", "Cliente");
$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Sean", "Johnson",
    "3152407845", "sweet@sanandreas.com", "grovestreet4life", "Cliente");
$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Melvin", "Harris",
    "3576892790", "bigsmoke@sanandreas.com", "greensabre", "Cliente");
$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Lance", "Wilson",
    "3230401151", "ryder@sanandreas.com", "smokeeveryday", "Cliente");


$nuoviUtenti[] = EGestoreUtenti::creaNuovoUtente("Reece", "Old",
    "3236020450", "oldreece@hairfuture.com", "hairfuture", "Direttore");


print "Sono stati ineriti nel db i seguenti utenti:\n";
foreach ($nuoviUtenti as $item) {
    print $item."\n\n\n";
}




//CREAZIONE DEI SERVIZI E CATEGORIE NEL DB


$reece = EGestoreUtenti::ottieniUtenteByID("oldreece@hairfuture.com");


$reece->creaCategoria("Capelli","Qui si possono travare i vari tagli di capelli che si trovano dal parrucchiere");
$reece->creaCategoria("Barba","Qui si possono trovare i vari tagli di barba che si trovano dal barbiere");



$reece->creaServizio("Afro","I capelli come Jimmy Hendrix", 25, 120, "Capelli");
$reece->creaServizio("A spazzola","Finalmente un taglio normale", 20, 30, "Capelli");
$reece->creaServizio("Scalati","Ideale per farsi qualunque acconciatura", 20, 45, "Capelli");
$reece->creaServizio("Caschetto","Potrai andare in moto tutte le volte che vuoi", 20, 60, "Capelli");
$reece->creaServizio("Sfoltita", "Meglio del barbiere non lo fa nessuno", 10, 30, "Barba");
$reece->creaServizio("Pizzetto", "Il migliore taglio di barba", 10, 45, "Barba");




//INSERIMENTO DI APPUNTAMENTI VARI





$catalogo = new ECatalogoServizi();


$servizi[] = $catalogo->ottieniServizioByCodice(2);
$servizi[] = $catalogo->ottieniServizioByCodice(3);


$cj = EGestoreUtenti::ottieniUtenteByID("cj@sanandreas.com");
$cj->prenotaAppuntamento($servizi, "2017-12-12", "09:00:00");

$altriServizi[] = $catalogo->ottieniServizioByCodice(2);


$cj->prenotaAppuntamento($altriServizi, "2017-11-12", "10:00:00");