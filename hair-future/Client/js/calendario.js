/**
 * Created by loren on 22/10/2017.
 */

$(document).ready(function() {
    indirizzo='../index.php';
    
    var richiesta= {
        controller: "CPrenotazione",
        metodo: "inviaDatiCalendario"
    };

    $.post(indirizzo,
        JSON.stringify(
            {richiesta: richiesta}),
        function (dati)
        {
            console.log(dati);
        },
        "json"
    );
    testo="";
    orari={
        800: "08:00",
        830: "08:30",
        900: "09:00",
        930: "09:30",
        1000: "10:00",
        1030: "10:30",
        1100: "11:00",
        1130: "11:30",
        1200: "12:00",
        1230: "12:30",
        1300: "13:00",
        1330: "13:30",
        1400: "14:00",
        1430: "14:30",
        1500: "15:00",
        1530: "15:30",
        1600: "16:00",
        1630: "16:30",
        1700: "17:00",
        1730: "17:30",
        1800: "18:00",
        1830: "18:30",
        1900: "19:00",
        1930: "19:30"
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
    };

    oggi= new Date();

    //Creazione dinamica della prima settimana
    testo=+testo+'<thead> <tr id="giorni"> <th>&nbsp;</th>';
    for (i=0;i<7;i++)
    {
        giorno=new Date(oggi.getTime()+86400000*i);
        testo=testo+'<th width="14%">'+giorni[giorno.getDay()]+'<br>'+giorno.getDate()+' '+mesi[giorno.getMonth()]+'</th>';
    }
    testo=testo+'</tr></thead> <tbody id="iniziotabella">';

    for (j in orari)
    {
        testo=testo+"<tr><td class='colonna'>"+orari[j]+"</td>";
        for (i=0;i<7;i++)
        {
            giorno=new Date(oggi.getTime()+86400000*i);
            testo = testo + '<td id="'+j+'|'+giorno.getDate()+'|'+giorno.getMonth()+'|'+giorno.getFullYear()+'" class="orario no-events" rowspan="1"></td>'
        }
        testo=testo+"</tr>";
    };
    testo=testo+ "</tbody>";
    $('#calendario').append(testo);


    $(".orario").click(function() {
        var elemento = this.id.split("|");
        console.log(elemento);
    });

    document.getElementById("830|31|9|2017").style.backgroundColor="#969696";
    //per rendere lo sfondo grigio a elementi prenotati


});


/*
 onmouseenter="myMoveFunction()"
 function myMoveFunction() {
 var x = document.getElementById("lun800");
 }


<td class=" has-events" rowspan="4">

    <div class="row-fluid lecture" style="width: 99%; height: 100%;">


    <span class="title">Data Structures</span> <span class="lecturer"><a>Prof.
        If</a></span> <span class="location">54/222</span>
    </div>
    </td>
    */