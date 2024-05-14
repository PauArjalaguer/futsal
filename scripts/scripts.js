var serverUrl = "http://www.futsal.cat/";
//var serverUrl = "http://localhost:8081/futsal/";
function resize() {
    var windowSize = window.innerWidth;
    var windowSize = screen.height;
    var offset = document.getElementById("web").offsetHeight;
    var header = document.getElementById("head").offsetHeight;
    var footer = document.getElementById("footerBackground").offsetHeight;
    var web = offset + header + footer;

    var resta = windowSize - web;
    // alert(windowSize+" "+offset+" "+web+" "+resta);
    if (resta > 270) {
        var y = resta + web - 390;
        document.getElementById("web").style.height = y + "px";

    }
}

function opacity(id, opacStart, opacEnd, millisec) {

    // speed for each frame
    var speed = Math.round(millisec / 100);
    var timer = 0;

    // determine the direction for the blending, if start and end are the same
    // nothing happens
    if (opacStart > opacEnd) {
        for (i = opacStart; i >= opacEnd; i--) {
            setTimeout("changeOpac(" + i + ",'" + id + "')", (timer * speed));
            timer++;

        }
    } else if (opacStart < opacEnd) {
        for (i = opacStart; i <= opacEnd; i++) {
            setTimeout("changeOpac(" + i + ",'" + id + "')", (timer * speed));
            timer++;
        }
    }
}
function changeOpac(opacity, id) {

    var object = document.getElementById(id).style;
    object.opacity = (opacity / 100);
    object.MozOpacity = (opacity / 100);
    object.KhtmlOpacity = (opacity / 100);
    object.filter = "alpha(opacity=" + opacity + ")";

// if(opacity==80){document.getElementById("alpha").style.visibility =
// "hidden";}
}

var openedMenu;
function showMenu(menu, order) {
    document.getElementById("menuSearch").style.display = 'none';
    opacity(menu, 0, 100, 1000);

    document.getElementById(menu).style.display = 'block';

    pixels = (order * 112);
    document.getElementById(menu).style.left = pixels + 'px';
    if (openedMenu) {
        opacity(openedMenu, 100, 0, 100);
        document.getElementById(openedMenu).style.display = 'none';

    }

    openedMenu = menu;

}
function closeMenu() {
    if (openedMenu) {
        opacity(openedMenu, 100, 0, 100);
        document.getElementById(openedMenu).style.display = 'none';
        openedMenu = '';
    }
}
function nuevoAjax() {
    var xmlhttp = false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }

    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}
function clearSearchForm() {
    document.getElementById('searchForm').value = "";
}
function search() {
    var str = document.getElementById('searchForm').value;
    //alert(str.length);
    if(str.length>1){
        document.getElementById("menuSearch").style.display = 'block';

        document.getElementById("menuSearch").style.left = '818px';
   
        var buscador;
        buscador = document.getElementById('menuSearch');
        ajax = nuevoAjax();
        ajax.open("GET", serverUrl + "search.php?str=" + str, true);
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4) {

                buscador.innerHTML = ajax.responseText
            }
        }
        ajax.send(null)
    }else{
        document.getElementById("menuSearch").style.display = 'none';
    }
}
function highlight_poll(number, id) {
    if (number == 1) {

        document.getElementById("star1_" + id).src = serverUrl + serverUrl
        + 'webImages/star.png';
        document.getElementById("star2_" + id).src = serverUrl + serverUrl
        + 'webImages/star2.png';
        document.getElementById("star3_" + id).src = serverUrl + serverUrl
        + 'webImages/star2.png';
        document.getElementById("star4_" + id).src = serverUrl + serverUrl
        + 'webImages/star2.png';
        document.getElementById("star5_" + id).src = serverUrl + serverUrl
        + 'webImages/star2.png';
    }

    if (number == 2) {
        document.getElementById("star1_" + id).src = serverUrl + 'webImages/star.png';
        document.getElementById("star2_" + id).src = serverUrl + 'webImages/star.png';
        document.getElementById("star3_" + id).src = serverUrl + 'webImages/star2.png';
        document.getElementById("star4_" + id).src = serverUrl + 'webImages/star2.png';
        document.getElementById("star5_" + id).src = serverUrl + 'webImages/star2.png';
    }
    if (number == 3) {
        document.getElementById("star1_" + id).src = serverUrl + 'webImages/star.png';
        document.getElementById("star2_" + id).src = serverUrl + 'webImages/star.png';
        document.getElementById("star3_" + id).src = serverUrl + 'webImages/star.png';
        document.getElementById("star4_" + id).src = serverUrl + 'webImages/star2.png';
        document.getElementById("star5_" + id).src = serverUrl + 'webImages/star2.png';
    }
    if (number == 4) {
        document.getElementById("star1_" + id).src = serverUrl + 'webImages/star.png';
        document.getElementById("star2_" + id).src = serverUrl + 'webImages/star.png';
        document.getElementById("star3_" + id).src = serverUrl + 'webImages/star.png';
        document.getElementById("star4_" + id).src = serverUrl + 'webImages/star.png';
        document.getElementById("star5_" + id).src = serverUrl + 'webImages/star2.png';
    }
    if (number == 5) {
        document.getElementById("star1_" + id).src = serverUrl + 'webImages/star.png';
        document.getElementById("star2_" + id).src = serverUrl + 'webImages/star.png';
        document.getElementById("star3_" + id).src = serverUrl + 'webImages/star.png';
        document.getElementById("star4_" + id).src = serverUrl + 'webImages/star.png';
        document.getElementById("star5_" + id).src = serverUrl + 'webImages/star.png';
    }
}
function file_vote(value, idNew) { // alert("VALOR:"+value+"
    // ARCHIVO:"+file_id);
    var container;
    container = document.getElementById('newsVote');
    ajax = nuevoAjax();
    ajax.open("GET", serverUrl + "newVote.php?idNew=" + idNew + "&value="
        + value, true);
    container.innerHTML = "Votant...";
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            container.innerHTML = ajax.responseText
        }
    }
    ajax.send(null)
}
function showPopUp() {
    opacity("alpha", 0, 80, 500);
    document.getElementById("alpha").style.display = "block";
    document.getElementById("alpha").style.width = "100%";
    document.getElementById("alpha").style.height = "100%";
    document.getElementById("popup").style.display = "block";
    document.getElementById("popup_container").style.display = "block";

    var pos = document.documentElement.scrollTop + 200;
    // document.getElementById("popup_container").style.top = pos + "px";
    var top = (document.documentElement && document.documentElement.scrollTop) ? document.documentElement.scrollTop
    : document.body.scrollTop;
// document.getElementById("alpha").style.top = top+" px";

}
function closePopUp() {
    opacity("alpha", 60, 0, 1000);
    document.getElementById("alpha").style.display = "none";
    document.getElementById("popup").style.display = "none";
    document.getElementById("popup").innerHTML = "";
    document.getElementById("popup").style.height = '50%';
    document.getElementById("popup").style.width = '50%';

}

function newsOpenMailSend(id) {
    showPopUp();
    document.getElementById("popup").style.width = "300px";
    var container;
    container = document.getElementById('popup');
    ajax = nuevoAjax();
    ajax.open("GET", serverUrl + "newsMailSenderForm.php?id=" + id, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            container.innerHTML = ajax.responseText
        }
    }
    ajax.send(null)
}
function newsMailSend() {
    var container;
    var senderName = document.getElementById("senderName").value;
    var receiverName = document.getElementById("receiverName").value;
    var receiverMail = document.getElementById("receiverMail").value;
    var idNew = document.getElementById("idNew").value;

    container = document.getElementById('popup');
    ajax = nuevoAjax();
    ajax.open("GET", serverUrl + "newsMailSend.php?senderName=" + senderName
        + "&receiverName=" + receiverName + "&receiverMail=" + receiverMail
        + "&idNew=" + idNew, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            container.innerHTML = ajax.responseText
        }
    }
    ajax.send(null)
}

function calendarChangeMonth(month, year) {

    var container = document.getElementById('calendarDiv');
    ajax = nuevoAjax();
    ajax.open("GET", serverUrl + "calendar.php?month=" + month + "&year="
        + year, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            container.innerHTML = ajax.responseText
        }
    }
    ajax.send(null);
}
function competitionChangeRound(round) {

    var container = document.getElementById('nextRound');
    ajax = nuevoAjax();
    ajax.open("GET", serverUrl + "competicioNextRound.php?idRound=" + round,
        true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            container.innerHTML = ajax.responseText
        }
    }
    ajax.send(null);
}

function newsWidget(field) {

    var container = document.getElementById('noticiesWidget');
    ajax = nuevoAjax();
    ajax.open("GET", serverUrl + "newsWidget.php?field=" + field, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            var active;
            container.innerHTML = ajax.responseText

        }
    }
    ajax.send(null);
}

function competitionShowResultsByLeagueAndRound(league) {
    var index= document.getElementById("roundSelection").selectedIndex;
    var idRound= document.getElementById("roundSelection").options[index].value;
    //alert(idRound);
        
    var container = document.getElementById('competitionContainer');
    ajax = nuevoAjax();
    ajax.open("GET", serverUrl + "competicioResults.php?idRound=" + idRound
        + "&idLeague=" + league, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {//alert(ajax.responseText);
            container.innerHTML = ajax.responseText
        }
    }
    ajax.send(null);
}

function userShowAvatarForm() {
    document.getElementById("userPhotoUploaderForm").style.display = "block";
}



var popupStatus = 0;

//loading popup with jQuery magic!
function loadPopup() {
    centerPopup();
    // loads popup only if it is disabled
    if (popupStatus == 0) {
        $("#backgroundPopup").css( {
            "opacity" : "0.7"
        });
        $("#backgroundPopup").fadeIn("slow");
        $("#popupContact").fadeIn("slow");
        popupStatus = 1;
    }
}

//disabling popup with jQuery magic!
function disablePopup() {
    // disables popup only if it is enabled
    if (popupStatus == 1) {
        $("#backgroundPopup").fadeOut("slow");
        $("#popupContact").fadeOut("slow");
        popupStatus = 0;
    }
}

//centering popup
function centerPopup() {
    // request data for centering
    var windowWidth = document.documentElement.clientWidth;
    var windowHeight = document.documentElement.clientHeight;
    var popupHeight = $("#popupContact").height();
    var popupWidth = $("#popupContact").width();
    // centering
    $("#popupContact").css( {
        "position" : "absolute",
        "top" : windowHeight / 4 - popupHeight / 2,
        "left" : windowWidth / 2 - popupWidth / 2
    });
    // only need force for IE6

    $("#backgroundPopup").css( {
        "height" : windowHeight
    });

}

//CONTROLLING EVENTS IN jQuery

$(document).ready(function() {

    // LOADING POPUP
    // Click the button event!
    $("#button").click(function() {
        // centering with css

        // load popup
        loadPopup();
    });

    // CLOSING POPUP
    // Click the x event!
    $("#popupContactClose").click(function() {
        disablePopup();
    });
    // Click out event!
    $("#backgroundPopup").click(function() {
        disablePopup();
    });
    // Press Escape event!
    $(document).keypress(function(e) {
        if (e.keyCode == 27 && popupStatus == 1) {
            disablePopup();
        }
    });

});


