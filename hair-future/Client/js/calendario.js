/**
 * Created by loren on 22/10/2017.
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

    //vedere che giorno è oggi
    oggi= new Date();
    // formattare il giorno in base alla classe data di php nel formato Y-m-d
    dataphp=convertiInDataPhp(oggi);

    testo="";
    //Creazione dinamica della prima settimana
    testo=+testo+'<thead> <tr id="giorni"> <th><span class="glyphicon glyphicon-chevron-left"></span></th>'; //&nbsp;

    // creazione barra in cui sono segnati i giorni a partire da oggi
    for (i=0;i<7;i++)
    {
        giorno=new Date(oggi.getTime()+86400000*i);
        testo=testo+'<th width="14%">'+giorni[giorno.getDay()]+'<br>'+giorno.getDate()+' '+mesi[giorno.getMonth()]+'</th>';
    }
    testo=testo+'<th><span class="glyphicon glyphicon-chevron-right"></span></th></tr></thead> <tbody id="iniziotabella">';

    // creazione caselle a cui vengono associati degli id in base alle loro caratteristiche (giorno, ora,...)
    for (j in orari)
    {
        testo=testo+"<tr><td class='colonna'>"+orari[j]+"</td>";
        for (i=0;i<7;i++)
        {
            giorno=new Date(oggi.getTime()+86400000*i);
            //id di una casella: codiceOrario-Giorno-Mese-Anno
            testo = testo + '<td id="'+j+'-'+giorno.getDate()+'-'+giorno.getMonth()+'-'+giorno.getFullYear()+'" class="orario '+giorno.getDay()+'" rowspan="1"></td>'
        }
        testo=testo+"<td class='colonna'>"+orari[j]+"</td>";
        testo=testo+"</tr>";
    }

    testo=testo+ "</tbody>";
    $('#calendario').append(testo);


    //dati da inviare al server per conoscere la disponibilità
    var richiesta= {
        controller: "CPrenotazione",
        metodo: "inviaDatiCalendario"
    };
    var dati={
        numeroGiorni:7,
        data: dataphp
    };

    //richiesta post che restituirà gli intervalli disponibili
    $.post(indirizzo,
        JSON.stringify(
            {richiesta: richiesta,
            dati:dati}),
        function (prenotabili)
        {
            //durata diventa numero di "mezz'ore"
            $(".result").html(prenotabili);
            durata=prenotabili.durata/30;

            //formattazione delle date ricevute secondo le date e gli orari qui definiti
            for (i in prenotabili.intervalli)
            {
                giorno=prenotabili.intervalli[i];
                for ( j in giorno ) {
                    ora=giorno[j];
                    ore=parseInt(ora.substr(0,2));
                    if (ora.substr(3,2)=='30') {prenotabili.intervalli[i][j]=ore+"50"}
                    else {prenotabili.intervalli[i][j]=ore+"00"};
                }
            }

            inserisciIntervalliDisponibili(durata, prenotabili.intervalli);
        },
        "json"
    );

    //supponiamo di ricevere i seguenti orari prenotabili
    function inserisciIntervalliDisponibili(durata, dateDisp)
    {

        //inserimento appuntamenti disponibili
        for (data in dateDisp) {
            for (i in dateDisp[data]) {
                datajs = convertiInDataJs(data);
                elem = document.getElementById('' + dateDisp[data][i] + '-' + datajs.getDate() + '-' + datajs.getMonth() + '-' + datajs.getFullYear() + '');
                elem.classList.add('has-events');
                elem.rowSpan = durata;
                elem.style.backgroundColor = "#a311e3";
                descrizione = "";
                descrizione = '<div class="row-fluid lecture" style="width: 99%; height: 100%;">' +
                    '<span class="title">Prenota per il</span>' +
                    '<span class="location">' + datajs.getDate() + '-' + (datajs.getMonth() + 1) + '-' + datajs.getFullYear() + '</span>' +
                    '<span class="location">alle ' + orari[dateDisp[data][i]] + '</span>' +
                    '</div>';
                $(elem).append(descrizione);
                for (j = 1; j < durata; j++) {
                    elimina = document.getElementById('' +
                        (parseInt(dateDisp[data][i]) + (50 * j)) + '-' +
                        datajs.getDate() + '-' +
                        datajs.getMonth() + '-' +
                        datajs.getFullYear() + '');
                    elimina.remove();
                }
            }
        }
    }



    $(".orario").click(function() {
        info=getInformazioni(this.id);
        oraIn=info.ora;
        giornoApp=info.anno+"-"+(parseInt(info.mese)+1)+"-"+info.giorno;
        //dati da inviare al server per salvare la prenotazione
        var richiesta1= {
            controller: "CPrenotazione",
            metodo: "effettuaPrenotazione"
        };

        var dati1=
            {
                oraInizioAppuntamento: orari[oraIn]+":00",
                dataAppuntamento: giornoApp
        };

        console.log(dati1);

        $.post(indirizzo,
            JSON.stringify(
                {
                    richiesta: richiesta1,
                    dati:dati1
                }),
            function (risp)
            {
                $(".result").html(risp);
                console.log(risp);
            },
            "json"
        );
    });

});

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
    return informazioni
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
