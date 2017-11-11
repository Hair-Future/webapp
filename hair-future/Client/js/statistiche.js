/**
 * Created by loren on 05/11/2017.
 */
$(document).ready(function()
    {
        oggi=new Date();
        $("#giorno_fine").val(convertiInDataPhp(oggi));
        oggi.setDate(oggi.getDate()-30);
        $("#giorno_inizio").val(convertiInDataPhp(oggi));
    });

$("#via").click(function()
    {
    if($("#risultato")!==null) {$("#risultato").remove();}
    statistica= $("#scegli_statistica").val();
    inizio= $("#giorno_inizio").val();
    iniziojs=convertiInDataJs(inizio);
    fine= $("#giorno_fine").val();
    finejs=convertiInDataJs(fine);
    oggi= new Date();

    if(!inizio || !fine) alert ("Attenzione: inserire tutti i campi")
    else{
        if( iniziojs.getTime()>oggi.getTime() || finejs.getTime()>oggi.getTime()) alert("Attenzione: le date devono essere uguali o antecedenti ad oggi");
        else {
            if (iniziojs.getTime() >= finejs.getTime()) alert("Attenzione: la data di inizio deve essere precedente alla data di fine");
            else {
                var richiesta = {
                    controller: "CStatistiche",
                    metodo: statistica
                };

                var dati = {
                    dataInizio: inizio,
                    dataFine: fine
                };
                $.post(indirizzo,
                    JSON.stringify(
                        {
                            richiesta: richiesta,
                            dati: dati
                        }),
                    function (risultato) {
                        $(".result").html(risultato);
                        visualizzaRis(risultato, richiesta.metodo, dati);
                    },
                    "json"
                );
            }
        }
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
            testo=testo+'</div>';
            $("#box").append(testo);
        }
        else if (metodo=="serviziApplicati" && ris.length > 0)
        {

            testo=testo+'<div class="title"> Lista dei servizi applicati dal '+dataInizio+' al '+dataFine+':</div>'+
                '<div class="ris"><div id="chartContainer" style="height: 300px; width: 100%;"></div></div>'
            testo=testo+'</div>';
            $("#box").append(testo);
            creaPieChart(ris);
        }
        else if (metodo=="maxSpesaUtente" && ris)
        {
            testo=testo+
                '<div class="title"> Dal '+dataInizio+' al '+dataFine+" l'utente che ha speso di più è:</div>"+
                '<div class="ris">'+ris.nome+' '+ris.cognome+' </div>';
            testo=testo+'</div>';
            $("#box").append(testo);
        }
        else if (metodo=="appuntamentiMancati" && ris.length > 0)
        {
            testo=testo+
                '<div class="title"> Lista degli utenti che dal '+dataInizio+' al '+dataFine+' hanno saltato almeno un appuntamento :</div>'+
                '<div class="ris">';
                    for (i in ris)
                    {
                        testo=testo+' <div> '+ris[i].utente.nome+ ' '+ris[i].utente.cognome+': '+ris[i].mancati+'</div>'
                    }
                    testo=testo+'</div>';
            testo=testo+'</div>';
            $("#box").append(testo);
        }
        else alert("Non c'è alcun risultato relativo all'intervallo scelto");

    }

});

function convertiInDataPhp (dataJs)
{
    if(dataJs.getDate()<10) {giorno="0"+dataJs.getDate()} else {giorno=dataJs.getDate()}
    dataPhp=""+dataJs.getFullYear()+"-"+(dataJs.getMonth()+1)+"-"+giorno;
    return dataPhp;
}

function convertiInDataJs (dataPhp)
{
    var x =dataPhp.split("-");
    dataJs= new Date;
    dataJs.setFullYear(x[0]);
    dataJs.setMonth(x[1]-1);
    dataJs.setDate(x[2]);
    return dataJs;
}

function creaPieChart(dati) {

    percentuali= [];
    for (i in dati)
    {
        testo=testo+' <div> '+dati[i].servizio.nome+ ' è stato applicato il '+dati[i].percentuale+'% delle volte</div>'

        percentuali.push({y: dati[i].percentuale, indexLabel: dati[i].servizio.nome});
    }

        var chart = new CanvasJS.Chart("chartContainer",
            {   animationEnabled: true,
                theme: "theme2",
                data: [
                    {
                        type: "pie",
                        showInLegend: true,
                        toolTipContent: "#percent %",
                        yValueFormatString: "##0.00\"%\"",
                        legendText: "{indexLabel}",
                        dataPoints: percentuali
                    }
                ]
            });
        chart.render();
}