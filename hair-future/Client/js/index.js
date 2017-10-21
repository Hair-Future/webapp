/**
 * Created by loren on 04/10/2017.
 */
$(document).ready(function() {
    indirizzo='../index.php';

    $('#accedi').click(function () {

        var email = $('#email').val();
        var password = $('#password').val();


        if (email == "" || password == "")
        {
            alert('I campi non possono essere vuoti!');
        }
        else
        {
            var richiesta={
                controller : "CLogin",
                metodo: "effettuaLogin"
            };

            var dati={
                email: email,
                password: password
            };


            $.post(
                indirizzo,
                JSON.stringify(
                    {
                        richiesta: richiesta,
                        dati:dati
                    }),
                function (data)
                {
                    $(".result").html(data);
                    alert("Ciao "+data.nome+""+data.cognome);
                },
                "json");
        }
        })


    });

