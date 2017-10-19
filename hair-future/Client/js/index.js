/**
 * Created by loren on 04/10/2017.
 */
$(document).ready(function() {
    $('#accedi').click(function () {

        var email = $('#email').val();
        var password = $('#password').val();


        if (email == "" || password == "")
        {
            alert('I campi non possono essere vuoti!');
        }
        else
        {
            dati=JSON.stringify(
                {
                    richiesta: "login",
                    email: email,
                    password: password
                });
            $.post(
                "http://10.170.54.17/hair-future/index.php",
                dati,
                function (data)
                {
                    $(".result").html(data);
                    alert("Ciao "+data.nome+""+data.cognome);
                },
                "json");
        }
        })


    });

