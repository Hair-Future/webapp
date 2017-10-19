/**
 * Created by loren on 05/10/2017.
 */
$(document).ready(function() {
    indirizzo='http://localhost/hair-future/Server_side/index.php';
        //'http://10.170.13.186/hair-future/index.php';

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
        $.post(indirizzo,
            //"http://localhost/hair-future/Server_side/index.php",
            //"http://172.27.24.147/hair-future/index.php",
            JSON.stringify(
                {
                    richiesta: "sceltaServizi"
                }),
            function (data) {
                $(".result").html(data);
                testo="";

                for (i in data)
                {
                    testo=testo+"<h3>"+data[i].nome+"</h3><div>"
                    for(j in data[i].servizi)

                        testo=testo+'<li> <input class="check" type="checkbox" name="servizio" value="'+data[i].servizi[j].codice+'"/> '+data[i].servizi[j].nome+'</li>';
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
        lista=new Array();
        i=0;
        $("input[name=servizio]").each(function () {
            var ischecked = $(this).is(":checked");
            if (ischecked) {
                lista[i] = $(this).val();
                console.log(lista[i]);
                i++;
            }
        });

        $.post(indirizzo,
            //http://localhost/hair-future/Server_side/index.php,
            //"http://172.27.24.147/hair-future/index.php",
            JSON.stringify(
                {
                    richiesta: "durataListaServizi",
                    lista: lista
                }),
            function (intervalli)
            {
                console.log('ciao');
                alert(intervalli)
            },
            "json"
        );
    })




        /*
         testo="<h3>"+data[0].nome+"</h3><ul><li>"+data[0].servizi[0].nome+"</li></ul>";
         testo=testo+"<h3>"+data[0].nome+"</h3><ul><li>"+data[0].servizi[1].nome+"</li></ul>";
         $('#accordion').append(testo)

         .accordion('destroy').accordion();


         $('#accordion').append("<h3>"+data[0].nome+"</h3><ul><li>"+data[0].servizi[0].nome+"</li></ul>")

         .accordion('destroy').accordion();



        testo="";

        for (i=0; i<5; i++)
        {
            testo=testo+"<h3>Categoria " + i + "</h3>";

            for (j = 0; j < 2; i++) {
                testo=testo+"<div><ul><li>Servizio " + j + "</li></ul></div>";
            }
        }
        console.log(testo);

        $('#accordion').append(testo).accordion('destroy')
            .accordion();

            */



    } );