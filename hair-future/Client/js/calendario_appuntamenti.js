/**
 * Created by loren on 03/11/2017.
 */
$(document).ready(function() {
    indirizzo='../index.php';

    //inizializzazione mappe tra codice e stringa degli orari, dei giorni e dei mesi
    orari={
        800: "08:00", 850: "08:30", 900: "09:00", 950: "09:30",
        1000: "10:00", 1050: "10:30", 1100: "11:00", 1150: "11:30",
        1200: "12:00", 1250: "12:30", 1300: "13:00", 1350: "13:30",
        1400: "14:00", 1450: "14:30", 1500: "15:00", 1550: "15:30",
        1600: "16:00", 1650: "16:30", 1700: "17:00", 1750: "17:30",
        1800: "18:00", 1850: "18:30", 1900: "19:00", 1950: "19:30"
    };

    giorni={
        1: "Lunedì",
        2: "Martedì",
        3: "Mercoledì",
        4: "Giovedì",
        5: "Venerdì",
        6: "Sabato",
        0: "Domenica"
    };

    mesi= {
        0: "Gennaio",
        1: "Febbraio",
        2: "Marzo",
        3: "Aprile",
        4: "Maggio",
        5: "Giugno",
        6: "Luglio",
        7: "Agosto",
        8: "Settembre",
        9: "Ottobre",
        10: "Novembre",
        11: "Dicembre"
    }; //Att! i mesi iniziano da 0 es. novembre=10

    //dati da inviare al server per conoscere la disponibilità
    var richiesta= {
        controller: "CGestione",
        metodo: "inviaAppuntamenti"
    };
    var dati={
        numeroGiorni:7
    };

    //richiesta post che restituirà gli intervalli disponibili
    $.post(indirizzo,
        JSON.stringify(
            {richiesta: richiesta,
                dati:dati}),
        function (dati)
        {
            $(".result").html(dati);
            creaTabella(dati);
        },
        "json"
    );


    function creaTabella(appuntamenti)
    {
        // formattare il giorno che arriva in php nel formato Y-m-d in formato js
        dataphp=appuntamenti.dataInizio;
        giornoInizio = convertiInDataJs(dataphp);

        ind="indietro";
        av="avanti";

        testo="";

        //Creazione dinamica della prima settimana
        testo=+testo+'<thead> <tr id="giorni"> <th><button class="freccia" id="settPrecedente" onClick="sposta(ind)"><span class="glyphicon glyphicon-chevron-left"></span></button></th>'; //&nbsp;

        // creazione barra in cui sono segnati i giorni a partire dal giornoInizio
        for (i=0;i<7;i++)
        {
            giorno=new Date(giornoInizio.getTime()+86400000*i);
            testo=testo+'<th width="14%">'+giorni[giorno.getDay()]+'<br>'+giorno.getDate()+' '+mesi[giorno.getMonth()]+'</th>';
        }
        testo=testo+'<th><button class="freccia" id="settSuccessivo" onClick="sposta(av)"><span class="glyphicon glyphicon-chevron-right"></span></button></th></tr></thead> <tbody id="iniziotabella">';

        // creazione caselle a cui vengono associati degli id in base alle loro caratteristiche (giorno, ora,...)
        for (j in orari)
        {
            testo=testo+"<tr><td class='colonna'>"+orari[j]+"</td>";
            for (i=0;i<7;i++)
            {
                giorno=new Date(giornoInizio.getTime()+86400000*i);
                //id di una casella: codiceOrario-Giorno-Mese-Anno
                testo = testo + '<td id="'+j+'-'+giorno.getDate()+'-'+giorno.getMonth()+'-'+giorno.getFullYear()+'" class="orario '+giorno.getDay()+'" rowspan="1" onClick="apriModalEffettuato(this.id)"></td>'
            }
            testo=testo+"<td class='colonna'>"+orari[j]+"</td>";
            testo=testo+"</tr>";
        }

        testo=testo+ "</tbody>";
        $('#calendario').append(testo);

        inserisciAppuntamenti(appuntamenti.appuntamenti);
    }

    function inserisciAppuntamenti(appuntamenti)
    {
        for (i in appuntamenti)
        {
            data=appuntamenti[i].data;
            ora=appuntamenti[i].ora;
            durata=(appuntamenti[i].durata)/30;
            utente=appuntamenti[i].utente;
            servizi=appuntamenti[i].servizi;
            effettuato=appuntamenti[i].effettuato;

            orario=parseInt(ora.substr(0,2));
            if (ora.substr(3,2)=='30') {orario=orario+"50"}
             else {orario=orario+"00"};

            datajs = convertiInDataJs(data);
            elem = document.getElementById('' +orario+ '-' + datajs.getDate() + '-' + datajs.getMonth() + '-' + datajs.getFullYear() + '');
            elem.classList.add('has-events');
            elem.id=elem.id+'-'+appuntamenti[i].codice;
            elem.rowSpan = durata;
            if (effettuato==1) elem.style.backgroundColor = "#009900";
            descrizione = "";
            descrizione = descrizione+'<div class="row-fluid lecture" style="width: 99%; height: 100%;">' +
                    '<span class="title">'+utente.nome+' '+utente.cognome+'</span>'
            for (j in servizi)
            {   descrizione= descrizione +'<span class="lecturer">'+ servizi[j].nome +' </span>' }
            descrizione= descrizione+'</div>';
            $(elem).append(descrizione);
            for (j = 1; j < durata; j++)
            {
                elimina = document.getElementById('' +
                    (parseInt(orario) + (50 * j)) + '-' +
                    datajs.getDate() + '-' +
                    datajs.getMonth() + '-' +
                    datajs.getFullYear() + '');
                    elimina.remove();
            }

        }
    }

});

function apriModalEffettuato(idOrario) {

    if($("#"+idOrario).is(".has-events"))
    {   informazioni = getInformazioni(idOrario);
        $("#myModal").modal();
        $("#appEffettuato").click(function () {
            segnaEffettuato(informazioni);
        })
    }
}

function segnaEffettuato(informazioni)
{

    //dati da inviare al server per conoscere la disponibilità
    var richiesta1
        = {
        controller: "CGestione",
        metodo: "segnaEffettuato"
    };
    var dati1 = {appuntamentoEffettuato: informazioni.appuntamento};
    $.post
    (indirizzo,
        JSON.stringify(
            {
                richiesta: richiesta1,
                dati: dati1
            }),""
        ,
        "json"
    );
    window.location="calendario_appuntamenti.html";
}

function sposta(spostamento) {
    if (spostamento=="avanti") x="7";
    else x="-7";
    $.post(indirizzo,
        JSON.stringify(
            {
                richiesta:
                    {controller: "CGestione",
                        metodo: "spostaDiNGiorni"},
                dati: {numeroGiorni: x}
            }),
        "",
        "json"
    );
    window.location="calendario_appuntamenti.html";
}

//funzione che restituisce le informazioni di una casella passandogli l'id
function getInformazioni(idCasella)
{
    informazioni=
        {ora: "", giorno: "", mese: "", anno: ""};
    var res = idCasella.split("-");
    j=0;
    for (i in informazioni)
    {
        informazioni[i]=res[j];
        j++;
    }
    if($("#"+idCasella).is(".has-events")) informazioni.appuntamento= res[j];
    return informazioni;
}

function convertiInDataPhp (dataJs)
{
    dataPhp=""+dataJs.getFullYear()+"-"+(dataJs.getMonth()+1)+"-"+dataJs.getDate();
    return dataPhp;
}

function convertiInDataJs (dataPhp)
{
    var x =dataPhp.split("-");
    dataJs= new Date;
    dataJs.setFullYear(x[0]);
    dataJs.setMonth(x[1]-1);
    dataJs.setDate(x[2]);
    return dataJs;
}
