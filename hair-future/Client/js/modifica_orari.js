/**
 * Created by loren on 03/11/2017.
 */
$(document).ready(function() {
    indirizzo='../index.php';

    $.post
    (    indirizzo,
        JSON.stringify(
            {
                richiesta: {
                    controller: "CGestione",
                    metodo: "inviaOrario"
                },
                dati: ""
            }
        ),
        function(dati)
        {
            $(".result").html(dati);
            creaTabella(dati);

        },
        "json");

    giorni={
        lun: "Lunedì",
        mar: "Martedì",
        mer: "Mercoledì",
        gio: "Giovedì",
        ven: "Venerdì",
        sab: "Sabato",
        dom: "Domenica"
    };

    orari={
        800: "08:00", 850: "08:30", 900: "09:00", 950: "09:30",
        1000: "10:00", 1050: "10:30", 1100: "11:00", 1150: "11:30",
        1200: "12:00", 1250: "12:30", 1300: "13:00", 1350: "13:30",
        1400: "14:00", 1450: "14:30", 1500: "15:00", 1550: "15:30",
        1600: "16:00", 1650: "16:30", 1700: "17:00", 1750: "17:30",
        1800: "18:00", 1850: "18:30", 1900: "19:00", 1950: "19:30"
    };

    function creaTabella(dati)
    {
        testo = "";
        testo = testo + '<tr>';
        for (i in giorni) {

            day=giorni[i];
            ore=dati[day];

            testo = testo + '<td>' +
                '<div class="bigger">Mattina</div>' +
                '<div class="campoform" style="white-space:nowrap">' +
                '<label for="' + i + '-matt-dalle">dalle</label>' +
                '<input  type="text" pattern="^(0[0-9]|1[0-9]|2[0-3]):[0|3]0$" title="HH:MM es: 09:00" name="' + i + '-matt-dalle" class="form-control" id="' + i + '-matt-dalle" value="'+ore.aperturaMattina.substr(0,5)+'">' +
                '</div>' +
                '<div class="campoform" style="white-space:nowrap">' +
                '<label for="' + i + '-matt-alle">alle</label>' +
                '<input  type="text" pattern="^(0[0-9]|1[0-9]|2[0-3]):[0|3]0$" title="HH:MM es: 09:00" name="' + i + '-matt-alle" class="form-control" id="' + i + '-matt-alle" value="'+ore.chiusuraMattina.substr(0,5)+'">' +
                '</div>' +
                '</td>';
        }
        testo = testo + '</tr>';
        testo = testo + '<tr>';
        for (i in giorni) {
            day=giorni[i];
            ore=dati[day];

            testo = testo + '<td>' +
                '<div class="bigger">Pomeriggio</div>' +
                '<div class="campoform" style="white-space:nowrap">' +
                '<label for="' + i + '-pom-dalle">dalle</label>' +
                '<input type="text" name="'+ i + '-pom-dalle" class="form-control" id="' + i + '-pom-dalle" value="'+ore.aperturaPomeriggio.substr(0,5)+'">' +
                '</div>' +
                '<div class="campoform" style="white-space:nowrap">' +
                '<label for="' + i + '-pom-alle">alle</label>' +
                '<input type="text" name="' + i + '-pom-alle" class="form-control" id="' + i + '-pom-alle" value="'+ore.chiusuraPomeriggio.substr(0,5)+'">' +
                '</div>' +
                '</td>';
        }
        testo = testo + '</tr>';

        $("#tabella").append(testo);

    }


    $("#salva_orari").click(function () {
        err=0;
        for (i in giorni)
        {
            if (!validaOra($("#"+i+"-matt-dalle").val())) {err=2;}
            if (!validaOra($("#"+i+"-matt-alle").val())) {err=2;}
            if (!validaOra($("#"+i+"-pom-dalle").val())) {err=2;}
            if (!validaOra($("#"+i+"-pom-alle").val())) {err=2;}
            aperturaMattina= parseInt(getKey(orari, $("#"+i+"-matt-dalle").val()));
            chiusuraMattina= parseInt(getKey(orari,$("#"+i+"-matt-alle").val()));
            aperturaPomeriggio= parseInt(getKey(orari,$("#"+i+"-pom-dalle").val()));
            chiusuraPomeriggio= parseInt(getKey(orari,$("#"+i+"-pom-alle").val()));

            if (aperturaMattina>=chiusuraMattina) err=1;
            if (aperturaPomeriggio>=chiusuraPomeriggio) err=1;
            if (aperturaPomeriggio<chiusuraMattina) err=1;
        }
        if (err==1) alert("Attenzione: per ogni intervallo l'apertura deve essere antecedente alla chiusura e l'apertura pomeridiana posteriore (o uguale) alla chiusura mattutina")
        else if(err!=2)
            {
            dati = FormattaDatiDaInviare();
            $.post
            (indirizzo,
                JSON.stringify(
                    {
                        richiesta: {
                            controller: "CGestione",
                            metodo: "modificaOrario"
                        },
                        dati: dati
                    }
                ), function (risp) {
                    if (risp==0) alert("Salvataggio avvenuto con successo!");
                    else alert("Ops! Sembra si sia verificato un errore. Prova a ricontrollare gli orari inseriti.");
                },
                "json")
        }
    });

    $("#annulla").click(function () {
        risp= confirm("Sei sicuro di voler uscire? Tutte le modifiche andranno perse");
        if(risp==true) {window.location = "index.html"}
    });

    function FormattaDatiDaInviare () {

        dati= new Array();

        for (i in giorni)
        {
            day= {
                    giorno: giorni[i],
                    aperturaMattina: $("#"+i+"-matt-dalle").val()+":00",
                    chiusuraMattina: $("#"+i+"-matt-alle").val()+":00",
                    aperturaPomeriggio: $("#"+i+"-pom-dalle").val()+":00",
                    chiusuraPomeriggio: $("#"+i+"-pom-alle").val()+":00"
            };
            //dati[giorni[i]]=day; per avere gli indici con i giorni della settimana
            dati=dati.concat(day); //per avere indici numerici da 0 a 6
        }

        return dati;
    }
});

function validaOra(ora) {
    var re = /^(0[0-9]|1[0-9]|2[0-3]):[0|3]0$/;
    return re.test(ora);
}

function getKey (array, value){
    for(var key in array){
        if(array[key] == value){
            return key;
        }
    }
    return null;
};