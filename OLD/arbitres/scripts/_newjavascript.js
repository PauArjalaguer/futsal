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

function maskContainer(){
//document.getElementById("rightContent").innerHTML="<img src='http://www.futsal.cat/webImages/LOGO.png' />";
//document.getElementById("rightContent").style.backgroundColor="#c00";
}
function unMaskContainer(){
    document.getElementById("rightContent").style.backgroundColor="";
}
function rfrMatchAssignation(){
    //alert("a");
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "rfrMatchAssignation.php", true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
           
            //alert(ajax.responseText);
            container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)
}

function rfrMatchAssignation(){
    //alert("a");
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "rfrMatchAssignation.php", true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {

            //alert(ajax.responseText);
            container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)
}
function rfrMatchAssignationsPerMatch(idMatch){
    maskContainer();
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "rfrMatchAssignationsPerMatch.php?idMatch="+idMatch, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {

            //alert(ajax.responseText);
            container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)
}

function rfrMatchAssignationsUpdateByCmrId(idCmr, idMatch){
    maskContainer();

    var select=document.getElementById("rfrMatchAssignationsUpdateByCmrId_"+idCmr);
    var select_index = select.selectedIndex;
    var select_value=select.options[select_index].value;

    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "rfrMatchAssignationsUpdateByCmrId.php?idCmr="+idCmr+"&idReferee="+select_value, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {

            //alert(ajax.responseText);
            //container1.innerHTML = ajax.responseText;
            rfrMatchAssignationsPerMatch(idMatch);
        }
    }
    ajax.send(null)
}


function rfrMatchAssignationsUpdateTypeByCmrId(idCmr, idMatch){
    maskContainer();

    var select=document.getElementById("rfrMatchAssignationsUpdateTypeByCmrId_"+idCmr);
    var select_index = select.selectedIndex;
    var select_value=select.options[select_index].value;

    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "rfrMatchAssignationsUpdateTypeByCmrId.php?idCmr="+idCmr+"&idRefereeType="+select_value, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {

            //alert(ajax.responseText);
            //container1.innerHTML = ajax.responseText;
            rfrMatchAssignationsPerMatch(idMatch);
        }
    }
    ajax.send(null)
}

function rfrMatchAssignationsUpdateKmByCmrId(idCmr, idMatch){
    maskContainer();

    var km=document.getElementById("rfrMatchAssignationsUpdateKmByCmrId_"+idCmr).value;
    if(km){
        var container1=document.getElementById("rightContent");
    }else{
        km=0;
    }
    ajax = nuevoAjax();
    ajax.open("GET", "rfrMatchAssignationsUpdateKmByCmrId.php?idCmr="+idCmr+"&km="+km, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {

            //alert(ajax.responseText);
        //container1.innerHTML = ajax.responseText;
        //rfrMatchAssignationsPerMatch(idMatch);
        }
    }
    ajax.send(null)
}

function rfrMatchAssignationsInsert(idMatch){
    //alert(idMatch);
    maskContainer();

    var select=document.getElementById("rfrMatchAssignationsInsert");
    var select_index = select.selectedIndex;
    var select_value=select.options[select_index].value;
    //alert(select_value);
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "rfrMatchAssignationsInsert.php?idMatch="+idMatch+"&idReferee="+select_value, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {

            //alert(ajax.responseText);
            //container1.innerHTML = ajax.responseText;
            rfrMatchAssignationsPerMatch(idMatch);
        }
    }
    ajax.send(null)
}













function rfrMatchAssignation(){
    //alert("a");
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "rfrMatchAssignation.php", true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {

            //alert(ajax.responseText);
            container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)
}
function rfrRefereeManagement(){
    //alert("a");
    maskContainer();
    var container1=document.getElementById("rightContent");
    
    ajax = nuevoAjax();
    ajax.open("GET", "rfrRefereeManagement.php", true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {

            //alert(ajax.responseText);
            container1.innerHTML=ajax.responseText;

        }
    }
    ajax.send(null)
}
function rfrRefereeInsert(){
    var name=document.getElementById("rfrRefereeName").value;
    ajax = nuevoAjax();
    ajax.open("GET", "rfrRefereeInsert.php?name="+name, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {

            rfrRefereeEdit(ajax.responseText);

        }
    }
    ajax.send(null)
}
function rfrRefereeEdit(idReferee){
    maskContainer();
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "rfrRefereeEdit.php?idReferee="+idReferee, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {

            container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)
}

function rfrRefereeEditSave(idReferee) {
    maskContainer();
    var name=document.getElementById("rfrRefereeName").value;
    var DNI=document.getElementById("rfrRefereeDNI").value;
    var password=document.getElementById("rfrRefereePassword").value;
    var city=document.getElementById("rfrRefereeCity").value;
    var province=document.getElementById("rfrRefereeProvince").value;
    var email=document.getElementById("rfrRefereeEmail").value;

    ajax = nuevoAjax();

    ajax.open ('POST', 'rfrRefereeEditSave.php', true);
    ajax.onreadystatechange = function() {

        if (ajax.readyState==4){
          
            rfrRefereeManagement();
        }


    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("name="+name+"&email="+email+"&dni="+DNI+"&city="+city+"&province="+province+"&password="+password+"&idReferee="+idReferee);
}

