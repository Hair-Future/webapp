/**
 * Created by loren on 05/11/2017.
 */

$("#via").click(function(){

    if($("#risultato")!==null) {$("#risultato").remove();}
    statistica= $("#scegli_statistica").val();
    inizio= $("#giorno_inizio").val();
    fine= $("#giorno_fine").val();

    if(!inizio || !fine) alert ("Attenzione inserire tutti i campi")
    else{
        var richiesta={
            controller : "CStatistiche",
            metodo: statistica
        };

        var dati={
            dataInizio : inizio,
            dataFine : fine,
        };
        $.post(indirizzo,
            JSON.stringify(
                {
                    richiesta: richiesta,
                    dati: dati
                }),
            function (risultato) {
                $(".result").html(risultato);
                console.log(risultato);
                visualizzaRis(risultato, richiesta.metodo, dati);
            },
            "json"
        );
    }



    function visualizzaRis(ris, metodo, giorni)
    {
        x=giorni.dataInizio.split("-");
        y=giorni.dataFine.split("-");

        dataInizio=x[2]+"-"+x[1]+"-"+x[0];
        dataFine=y[2]+"-"+y[1]+"-"+y[0];
        testo='<div id="risultato" class="col-sm-5 sfondo_grigio">';
        if (metodo=="guadagno")
        {
            testo=testo+
            '<div class="title">Dal '+dataInizio+' al '+dataFine+' il tuo ricavo è stato di:</div>'+
            '<div class="ris">'+ris+' €</div>';
        }
        if (metodo=="serviziApplicati")
        {
            testo=testo+
                '<div class="title"> Lista dei servizi applicati dal '+dataInizio+' al '+dataFine+':</div>'+
                '<div class="ris">';
            for (i in ris)
            {   console.log(ris[i].servizio);
                testo=testo+' <div> '+ris[i].servizio.nome+ ' è stato applicato il '+ris[i].percentuale+'% delle volte</div>'
            }
            testo=testo+'</div>';
        }
        if (metodo=="maxSpesaUtente")
        {
            testo=testo+
                '<div class="title"> Dal '+dataInizio+' al '+dataFine+" l'utente che ha speso di più è:</div>"+
                '<div class="ris">'+ris.nome+' '+ris.cognome+' </div>';
        }
        if (metodo=="appuntamentiMancati")
        {
            testo=testo+
                '<div class="title"> Lista degli utenti che dal '+dataInizio+' al '+dataFine+' hanno saltato almeno un appuntamento :</div>'+
                '<div class="ris">';
                    for (i in ris)
                    {
                        testo=testo+' <div> '+ris[i].utente.nome+ ' '+ris[i].utente.cognome+' è mancato '+ris[i].mancati+' volte</div>'
                    }
                    testo=testo+'</div>';
        }

        testo=testo+'</div>';
        $("#box").append(testo);

    }

});
