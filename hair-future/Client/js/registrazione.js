/**
 * Created by loren on 04/10/2017.
 */
$(document).ready(function()
{indirizzo='../index.php';
    $('#no').hide();

    /*Evento tasto Registrati*/
    $('#registrazione').click(function ()
    {

        var nome = $('#nome').val();
        var cognome = $('#cognome').val();
        var telefono = $('#telefono').val();
        var email = $('#email').val();
        var pass1 = $('#pass1').val();
        var pass2 = $('#pass2').val();



        if (nome == "" || cognome == "" || telefono == "" || email == "" || pass1 == "" || pass2 == "")
        {
            alert("Per favore, inserisci tutti i campi!");
        } else if (pass1 !== pass2) {
            alert("Attenzione! Le password non corrispondono!");
        } else
            {
                var richiesta={
                    controller : "CRegistrazione",
                    metodo: "Registra"
                };

                var dati={
                    nome : nome,
                    cognome : cognome,
                    telefono : telefono,
                    email: email,
                    password: pass1
                };

             $.post(indirizzo,
                 JSON.stringify(
                     {
                         richiesta: richiesta,
                         dati: dati
                     }),
                 function (risultato) {
                     $(".result").html(risultato);
                     alert(risultato.nome);
                 },
                 "json"
             );

            // $.get("http://10.170.54.17/hair-future/index.php?nome="+nome+"&cognome="+cognome+"&telefono="+telefono+"&email="+email+"&password="+pass1)
        }
    });

    $('input').change(function ()
    {

        var nome = $('#nome').val();
        var cognome = $('#cognome').val();
        var telefono = $('#telefono').val();
        var email = $('#email').val();
        var pass1 = $('#pass1').val();
        var pass2 = $('#pass2').val();
        var login = "login";

        if (pass1 !== pass2) {
            $('#no').show();
        } else {
            $('#no').hide();
        }
    });


});

