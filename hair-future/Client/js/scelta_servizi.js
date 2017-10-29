/**
 * Created by loren on 05/10/2017.
 */
$(document).ready(function() {

    indirizzo='../index.php';


        //inizializzazione accordion
        $( "#accordion" ).accordion({
            collapsible: true
        });



        /* Attributi Categoria:
                -nome
                -descrizione
                -array di servizi

                    Attributi Servizi:
                        -nome
                        -descrizione
                        -prezzo
                        -durata
                        -codice
         */

        //richiesta al server dei servizi disponibili sul db

        var richiesta=
            {
                controller : "CPrenotazione",
                metodo: "inviaTuttiServizi"
            }
        $.post(indirizzo,
            JSON.stringify({richiesta: richiesta}),
            function (data) {
                $(".result").html(data);
                testo="";


                for (i in data)
                {
                    testo=testo+"<h3>"+data[i].nome+"</h3><div>";
                    for(j in data[i].servizi)
                    {
                        testo = testo +
                            '<li>' +
                            '<input class="check" type="checkbox" name="servizio" value="' + data[i].servizi[j].codice + '">' +
                            data[i].servizi[j].nome +
                            '<span id="prezzo" >'+data[i].servizi[j].prezzo+'€</span></li>';
                    }
                    // console.log(data[i].nome+": "+data[i].servizi[j].nome);
                    testo=testo+"</div>";
                }


                $('#accordion').append(testo)
                    .accordion('destroy').accordion
                ({
                    collapsible: true,
                    heightStyle: "content"
                    /*icons: {
                        header: "ui-icon-circle-arrow-e",
                        activeHeader: "ui-icon-circle-arrow-s"
                    }*/
                });

            },
            "json"

        );


    //invio al server della lista dei servizi per calcolo durata e orari disponibili
    $('#inviaServizi').click(function ()
    {
        var listaServizi={};
        i=0;
        $("input[name=servizio]").each(function () {
            var ischecked = $(this).is(":checked");
            if (ischecked) {
                listaServizi[i] = parseInt($(this).val(), 10);
                i++;
            }
        });
       // console.log(listaServizi);


        var richiesta= {
            controller: "CPrenotazione",
            metodo: "salvaListaServizi"
        };

        $.post(indirizzo,
            JSON.stringify(
                {
                    richiesta: richiesta,
                    dati: {lista: listaServizi}
                }),
            function (intervalli)
            {
                console.log("passo all'altra pagina");
            },
            "json"
        );
    })

    } );