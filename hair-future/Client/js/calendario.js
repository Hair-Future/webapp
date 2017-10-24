/**
 * Created by loren on 22/10/2017.
 */

$(document).ready(function() {
    testo="";
    orari={
        800: "08:00",
        830: "08:30",
        900: "09:00",
        930: "09:30",
        1000: "10:00",
        1030: "10:30",
        1100: "11:00",
        1130: "11:30",
        1200: "12:00",
        1230: "12:30",
        1300: "13:00",
        1330: "13:30",
        1400: "14:00",
        1430: "14:30",
        1500: "15:00",
        1530: "15:30",
        1600: "16:00",
        1630: "16:30",
        1700: "17:00",
        1730: "17:30",
        1800: "18:00",
        1830: "18:30",
        1900: "19:00",
        1930: "19:30"
    };
    giorni={
        lun: "Lunedì",
        mar: "Martedì",
        mer: "Mercoledì",
        gio: "Giovedì",
        ven: "Venerdì",
        sab: "Sabato",
        dom: "Domenica"
    };


    for (i in orari)
    {
        testo=testo+"<tr><td class='colonna'>"+orari[i]+"</td>";
        for(j in giorni)
        {
            testo = testo + '<td id="'+j+i+'" class=" no-events" rowspan="1"></td>'
        }
        testo=testo+"</tr>";
    };

    $('#iniziotabella').append(testo);

    for(i in orari){
        document.getElementById("lun"+i).style.backgroundColor="#969696";
    }




});





/*
 onmouseenter="myMoveFunction()"
 function myMoveFunction() {
 var x = document.getElementById("lun800");
 }


<td class=" has-events" rowspan="4">

    <div class="row-fluid lecture" style="width: 99%; height: 100%;">


    <span class="title">Data Structures</span> <span class="lecturer"><a>Prof.
        If</a></span> <span class="location">54/222</span>
    </div>
    </td>
    */