/**
 * Created by loren on 01/11/2017.
 */

$(document).ready(function() {
    indirizzo='../index.php';

    htmlNavbar = '' +
        '<nav class="navbar navbar-default navbar-fixed-top">' +
        '<div class="container-fluid">' +
        '<!-- Brand and toggle get grouped for better mobile display -->' +
        '<div class="navbar-header">' +
        '<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">' +
        '<span class="sr-only">Toggle navigation</span>' +
        '<span class="icon-bar"></span>' +
        '<span class="icon-bar"></span>' +
        '<span class="icon-bar"></span>' +
        '</button>' +
        '<a class="navbar-brand" href="index.html">' +
        '<img src="img/logo.png">' +
        '</a>' +
        '</div>' +

        '<!-- Collect the nav links, forms, and other content for toggling -->' +
        '<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">' +
        '<ul class="nav navbar-nav navbar-right">' +
        '<li><a style="font-size:13px;" id="login_effettuato"></a></li>'+

        '<li><a class="btn-default active" id="home" href="index.html">Home</a></li>' +
        '<li><a class="btn-default active" data-toggle="modal" data-target="#myModal" href="" id="login">Log In</a></li>' +
        '<li><a class="btn-default active" id="logout" href="index.html">Log Out</a></li>' +
        '<li><a class="btn-default active" id="modifica_orari" href="modifica_orari.html">Modifica Orario</a></li>'+
        '<li><a class="btn-default active" id="statistiche" href="statistiche.html">Statistiche</a></li>'+
        '<li><a class="btn-default active" id="registrati" href="registrazione.html">Registrati</a></li>' +
        //'<!--<li><a class="btn btn-default active" href="#" role="button" id="btn-nav">Prenota</a></li> -->' +
        '<li><a class=" btn-default active" id="prenota">' +
        'Prenota' +
        '</a></li>' +
        '<li><a class=" btn-default active" id="appuntamenti"" href="calendario_appuntamenti.html">' +
        'Appuntamenti' +
        '</a></li>'+

        '</ul>' +

        '</div><!-- /.navbar-collapse -->' +

        '</div><!-- /.container-fluid -->' +
        '</nav>';
        $("body").append(htmlNavbar);
        $("#login").hide();
        $("#registrati").hide();
        $("#logout").hide();
        $("#modifica_orari").hide();
        $("#statistiche").hide();
        $("#appuntamenti").hide();

    $.post
    (       indirizzo,
        JSON.stringify(
            {
                richiesta: {
                    controller: "CLogin",
                    metodo: "check"
                },
                dati: ""
            }
        ),
        function (utente)
        {
            $(".result").html(utente);
            if(utente!=-1 && utente!=false) { //se c'è un utente che ha effettuato il login può effettuare il logout
                connesso_come='Sei connesso come <span style="color:#a311e3">'+ utente.nome + ' ' + utente.cognome+'</span>';
                document.getElementById("login_effettuato").append("Sei connesso come " + utente.nome +" "+ utente.cognome);
                $("#logout").show();

                if(utente.tipo=='Direttore')
                    //se l'utente connesso è un direttore pò anche modificare gli orari, vedere le statistiche
                { $("#modifica_orari").show();
                    $("#statistiche").show();
                    $("#prenota").hide();
                    $("#appuntamenti").show();}

            }
            else { //se non c'è login mostriamo login, registrati
                $("#login").show();
                $("#registrati").show();
                $('#prenota').click(function () {});
            }
        },
        "json"
    );

    $('#logout').click(function () {
        $.post
        (       indirizzo,
            JSON.stringify(
                {
                    richiesta: {
                        controller: "CLogin",
                        metodo: "effettuaLogout"
                    },
                    dati: ""
                }
            ),
            "",
            "json"
        );
    });

    $('#prenota').click(function ()
    {
        $.post
        (       indirizzo,
            JSON.stringify(
                {
                    richiesta: {
                        controller: "CLogin",
                        metodo: "check"
                    },
                    dati: ""
                }
            ),
            function (utente)
            {
                $(".result").html(utente);
                if(utente!=-1 && utente!=false)
                {
                    window.location="scelta_servizi.html";
                }
                else
                {
                    alert('Ops, sembra che tu non abbia effettuato il login')
                }
            },
            "json"
        );
    });
});