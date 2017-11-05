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
            console.log(dati);
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
                '<input  type="text" name="' + i + '-matt-dalle" class="form-control" id="' + i + '-matt-dalle" value="'+ore.aperturaMattina.substr(0,5)+'">' +
                '</div>' +
                '<div class="campoform" style="white-space:nowrap">' +
                '<label for="' + i + '-matt-alle">alle</label>' +
                '<input  type="text" name="' + i + '-matt-alle" class="form-control" id="' + i + '-matt-alle" value="'+ore.chiusuraMattina.substr(0,5)+'">' +
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
        dati=FormattaDatiDaInviare();
        $.post
        (       indirizzo,
            JSON.stringify(
                {
                    richiesta: {
                        controller: "CGestione",
                        metodo: "modificaOrario"
                    },
                    dati: dati
                }
            ), function() {

            },
        "json")
    })

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
            dati[giorni[i]]=day;
            //dati=dati.concat(day);
            console.log(dati);
        }

        return dati;
    }
});