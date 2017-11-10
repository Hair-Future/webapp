/**
 * Created by loren on 04/10/2017.
 */
$(document).ready(function()
{indirizzo='../index.php';

    /*Evento tasto Registrati*/
    $('#registrazione').click(function ()
    {

        var nome = $('#nome').val();
        var cognome = $('#cognome').val();
        var telefono = $('#telefono').val();
        var emailReg = $('#emailReg').val();
        var pass1 = $('#pass1').val();
        var pass2 = $('#pass2').val();



        if (nome == "" || cognome == "" || telefono == "" || emailReg == "" || pass1 == "" || pass2 == "")
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
                    email: emailReg,
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
                     if(risultato!="-1")
                     alert("Ciao "+risultato.nome+", hai effettuato la registrazione con successo!");
                     else alert ("Ops! C'è già un account in uso con quella e-mail");
                     //alert(risultato);
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
        var emailReg = $('#emailReg').val();
        var pass1 = $('#pass1').val();
        var pass2 = $('#pass2').val();
        var login = "login";

    });


});

