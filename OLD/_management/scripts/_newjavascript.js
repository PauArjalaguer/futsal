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

function TamVentana() {
    var Tamanyo = [0, 0];
    if (typeof window.innerWidth != 'undefined')
    {
        Tamanyo = [
        window.innerWidth,
        window.innerHeight
        ];
    }
    else if (typeof document.documentElement != 'undefined'
        && typeof document.documentElement.clientWidth !=
        'undefined' && document.documentElement.clientWidth != 0)
        {
        Tamanyo = [
        document.documentElement.clientWidth,
        document.documentElement.clientHeight
        ];
    }
    else   {
        Tamanyo = [
        document.getElementsByTagName('body')[0].clientWidth,
        document.getElementsByTagName('body')[0].clientHeight
        ];
    }
    return Tamanyo;
}



var prevUlToShow;

function clubInfoUpdate(idClub){
    var clubAddress=document.getElementById("clubAddress").value;
    var clubCity=document.getElementById("clubCity").value;
    var clubEmail=document.getElementById("clubEmail").value;

    var clubPhone1=document.getElementById("clubPhone1").value;
    var clubPhone2=document.getElementById("clubPhone2").value;
    var clubWeb=document.getElementById("clubWeb").value;
    var clubFacebook=document.getElementById("clubFacebook").value;
    var clubTwitter=document.getElementById("clubTwitter").value;

    var clubHistory=document.getElementById("clubHistory").value;

    var billingName=document.getElementById("billingName").value;
    var billingNif=document.getElementById("billingNif").value;
    var billingAddress=document.getElementById("billingAddress").value;
    var billingCity=document.getElementById("billingCity").value;
    
    ajax = nuevoAjax();
    ajax.open("POST", "clubInfoUpdate.php", true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
    //alert(ajax.responseText);
          
    }
    }
    ajax.setRequestHeader("Content-Type",
        "application/x-www-form-urlencoded");
    ajax.send("clubAddress="+clubAddress+"&clubCity="+clubCity+"&clubEmail="+clubEmail+"&clubPhone1="+clubPhone1+"&clubPhone2="+clubPhone2+"&clubWeb="+clubWeb+"&clubFacebook="+clubFacebook+"&clubTwitter="+clubTwitter+"&clubHistory="+clubHistory+"&idClub="+idClub+"&billingName="+billingName+"&billingNif="+billingNif+"&billingAddress="+billingAddress+"&billingCity="+billingCity)

}

function ulShow(ulToShow){
    if(prevUlToShow){
        document.getElementById(prevUlToShow).style.display="none";
        document.getElementById(prevUlToShow+"_a").className="nav-top-item";
    }
    document.getElementById(ulToShow).style.display="block";
    document.getElementById(ulToShow+"_a").className +=" current";

    prevUlToShow=ulToShow;
}


function openModal(width,height){

    width=width+20;
    height=height+20;
    //alert(width+" "+height);
    var modal=document.getElementById("modal");
    modal.style.display="block";
    modal.style.width=width+"px";
    modal.style.height=height+"px";
    modal.style.margin="auto;";
    modal.style.display="block";

    var alpha=document.getElementById("alpha");
    alpha.style.display="block";
}

function hideModal(){
    document.getElementById("modal").innerHTML="";
    var modal=document.getElementById("modal");
    modal.style.width="0px";
    modal.style.height="0px";
    modal.style.margin="auto";
    modal.style.display="none";

    var alpha=document.getElementById("alpha");
    alpha.style.display="none";

}
function adjustModal(w,h){
    var size=TamVentana();
    var screenH=size[0];
    var screenW=size[1];
   
    var posH=(screenH/2)-(w/2);
    var posW=(screenW/2)-(h/2);
   
    document.getElementById("modal").style.left=posH+"px";
    document.getElementById("modal").style.top=posW+"px";

}
var prevIdClub;


// SECCIO EQUIPS I CLUBS //

var team;
var prevTeam;
function playersByTeamId(idTeam){
    team=idTeam;
    if(prevTeam){
        document.getElementById("teamsList_"+prevTeam).className='';
    }
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "playersByTeamId.php?idTeam="+idTeam, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            document.getElementById("teamsList_"+idTeam).className='listCurrent';
            prevTeam=idTeam;
            //alert(ajax.responseText);
            container1.innerHTML = ajax.responseText;
            $("#newPlayerName").click(function(){
                if($("#newPlayerName").val() == "")
                {
                    $("#newPlayerName").val("");
                }
            })
            $("#newPlayerName").keyup(function(event){
                //alert("a");
                if($("#newPlayerName").val() != "")
                {
                    // make suggestions visible
                    $("#suggestions").css('visibility', 'visible');
                    $("#suggestions").hide();
                    $("#suggestions").fadeIn('slow');
                    search=$("#newPlayerName").val();

                    $.get('http://www.futsal.cat/management/playersOldByTeamId.php?idTeam='+idTeam+"&search="+search,processSuggestionData);

                //$("#suggestions").load('http://localhost:8081/futsal2011/management/playersOldByTeamId.php?idTeam='+idTeam+"&search="+search);

                } else {
                    // hide suggestions
                    $("#suggestions").fadeOut('slow', function(){
                        $("#suggestions").css('visibility', 'hidden');
                    });

                }
            })

           
        }
    }
    ajax.send(null)
}
function processSuggestionData(data){
    if(data.length>0){
        document.getElementById("suggestions").innerHTML=data;
    //document.getElementById("newPlayerNameButton").disabled=true;
    }else{
        //document.getElementById("newPlayerNameButton").disabled=false;
        document.getElementById("suggestions").innerHTML="";

    }
}


function playerTransferDNISearch(idTeam){
    var dni=document.getElementById("playerTransferDNI").value;
    ajax = nuevoAjax();
    ajax.open("GET", "playerTransferDNISearch.php?idTeam="+idTeam+"&dni="+dni, true);


    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            // var idPlayer=ajax.responseText;
            //playerCardEdit(idPlayer,idTeam);
            document.getElementById("playerTransferDNISearch").innerHTML=ajax.responseText;
        }
    }
    ajax.send(null)


}


function teamsInsertPlayer(idTeam){
    var playerName=document.getElementById("newPlayerName").value;
    ajax = nuevoAjax();
    ajax.open("GET", "teamsInsertPlayer.php?idTeam="+idTeam+"&playerName="+playerName, true);
    

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {           
            var idPlayer=ajax.responseText;
            playerCardEdit(idPlayer,idTeam);
        }
    }
    ajax.send(null)
    
    
}


function playersInsertIntoPlayerTeamSeason(idPlayer,idTeam){
    ajax = nuevoAjax();
    ajax.open("GET", "playersInsertIntoPlayerTeamSeason.php?idPlayer="+idPlayer+"&idTeam="+idTeam, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            var l=ajax.responseText.length;
           
            if(l>1){
                alert(ajax.responseText);
                playersByTeamId(idTeam);
            }else{
                playerCardEdit(idPlayer,idTeam);
            }

            
        }
    }
    ajax.send(null)


}
function playerCardEdit(idPlayer,idTeam){
    hideModal();
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "playerCardEdit.php?idPlayer="+idPlayer+"&idTeam="+idTeam, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            container1.innerHTML = ajax.responseText;
        //$("form.jqtransform").jqTransform();
        }
    }
    ajax.send(null);


}
function imageCapture(idPlayer,idTeam){
    playerCardUpdateNoRefresh(idPlayer,idTeam);
    var w=640;
    var h=560;
    openModal(w,h);
    ajax = nuevoAjax();
    ajax.open("GET", "imageCapture.php?idPlayer="+idPlayer+"&idTeam="+idTeam, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            document.getElementById("modal").innerHTML=ajax.responseText;
            adjustModal(w,h);
        }
    }
    ajax.send(null)

}

function imageUploader(idPlayer,idTeam){
    playerCardUpdateNoRefresh(idPlayer,idTeam);
    var w=220;
    var h=80;
    openModal(w,h);
    ajax = nuevoAjax();
    ajax.open("GET", "imageUploader.php?idPlayer="+idPlayer+"&idTeam="+idTeam, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            document.getElementById("modal").innerHTML=ajax.responseText;
            adjustModal(w,h);

        }
    }
    ajax.send(null)

}
function imageCropFromTeamPicture(idPlayer,idTeam){
    playerCardUpdateNoRefresh(idPlayer,idTeam);
    window.location="imageEdit.php?idPlayer="+idPlayer+"&idTeam="+idTeam+"&cropFromPicture=yes";
}
function playerCardEditInsuranceDateInsert(idPlayer,idTeam){
    /*var w=350;
    var h=120;
    openModal(w,h);
    ajax = nuevoAjax();
    ajax.open("GET", "playerCardEditInsuranceDateInsert.php?idPlayer="+idPlayer+"&idTeam="+idTeam, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            document.getElementById("modal").innerHTML=ajax.responseText;
            adjustModal(w,h);

        }
    }
    ajax.send(null);*/
    playerCardEdit(idPlayer,idTeam);

}

function playerCardEditInsuranceDateSave(idInsurance,idPlayer,idTeam){

    var insuranceExpirationDate=document.getElementById("insuranceExpirationYY").value+"-"+document.getElementById("insuranceExpirationMM").value+"-"+document.getElementById("insuranceExpirationDD").value;
    ajax = nuevoAjax();
    ajax.open("GET", "playerCardEditInsuranceDateSave.php?idInsurance="+idInsurance+"&expirationDate="+insuranceExpirationDate, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            playerCardEdit(idPlayer,idTeam);
        }
    }
    ajax.send(null);
}
function playerCardEditDeleteFile(idPlayer,item,idTeam,idItem){
    ajax = nuevoAjax();
    ajax.open("GET", "playerCardEditDeleteFile.php?idPlayer="+idPlayer+"&item="+item+"&idItem="+idItem, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            playerCardEdit(idPlayer,idTeam);
        }
    }
    ajax.send(null);
}
function preview(img, selection) {
    var scaleX = 100 / (selection.width || 1);
    var scaleY = 100 / (selection.height || 1);

    $('#imageToCrop + div > img').css({
        width: Math.round(scaleX * 400) + 'px',
        height: Math.round(scaleY * 300) + 'px',
        marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
        marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
    });
}

function imageEdit(idPlayer,idTeam){
    /*hideModal();
    openModal(840,580);

    ajax2= nuevoAjax();
    ajax2.open("GET", "imageEdit.php?idPlayer="+idPlayer+"&idTeam="+idTeam, true);
    ajax2.onreadystatechange = function() {
        if (ajax2.readyState == 4) {
 
            document.getElementById("rightContent").innerHTML=ajax2.responseText;
            if ($('#imageToCrop').is(':visible')) {
                $('#imageToCrop').imgAreaSelect({
                    aspectRatio: '4:3',
                    handles: true
                });
            }
    
        }
    }

    ajax2.send(null);
*/
    window.location="imageEdit.php?idPlayer="+idPlayer+"&idTeam="+idTeam;
  
}


function playerCardUpdate(idPlayer,idTeam,refresh){
    var playerBirthDate=document.getElementById("playerBirthDateDD").value+"-"+document.getElementById("playerBirthDateMM").value+"-"+document.getElementById("playerBirthDateYY").value;
    var playerName=document.getElementById("playerName").value;
    var playerNumber=document.getElementById("playerNumber").value;
    var playerDNI=document.getElementById("playerDNI").value;
    var playerNIF=document.getElementById("playerNIF").value;


    var playerAddress=document.getElementById("playerAddress").value;
    var playerAddressNumber=document.getElementById("playerAddressNumber").value;
    var playerAddressFloor=document.getElementById("playerAddressFloor").value;
    var playerAddressDoor=document.getElementById("playerAddressDoor").value;

    var playerAddressCity=document.getElementById("playerAddressCity").value;
    var playerAddressProvince=document.getElementById("playerAddressProvince").value;

    var playerCP=document.getElementById("playerAddressCP").value;
    
    var playerNationality=document.getElementById("playerNationality").value;
    var playerCountryOfBirth=document.getElementById("playerCountryOfBirth").value;
    var playerProvinceOfBirth=document.getElementById("playerProvinceOfBirth").value;

    var playerEmail=document.getElementById("playerEmail").value;
    var playerNotes=document.getElementById("playerNotes").value;

    /*var select=document.getElementById("playerPosition");
    var select_index = select.selectedIndex;
    var select_value=select.options[select_index].value;

    var playerPosition=select_value;
    */

    ajax = nuevoAjax();
    ajax.open("GET", "playerCardUpdate.php?idPlayer="+idPlayer+"&playerName="+playerName+"&playerBirthDate="+playerBirthDate+"&playerDNI="+playerDNI+"&playerNIF="+playerNIF+"&playerNumber="+playerNumber+"&playerAddress="+playerAddress+"&playerAddressNumber="+playerAddressNumber+"&playerAddressFloor="+playerAddressFloor+"&playerAddressDoor="+playerAddressDoor+"&playerAddressCity="+playerAddressCity+"&playerCP="+playerCP+"&playerAddressProvince="+playerAddressProvince+"&playerNationality="+playerNationality+"&playerCountryOfBirth="+playerCountryOfBirth+"&playerProvinceOfBirth="+playerProvinceOfBirth+"&playerEmail="+playerEmail+"&playerNotes="+playerNotes, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            playersByTeamId(idTeam);
        }
    }
    ajax.send(null)


}
function playerCardUpdateNoRefresh(idPlayer,idTeam,refresh){
    var playerBirthDate=document.getElementById("playerBirthDateDD").value+"-"+document.getElementById("playerBirthDateMM").value+"-"+document.getElementById("playerBirthDateYY").value;

    var playerName=document.getElementById("playerName").value;
    var playerNumber=document.getElementById("playerNumber").value;
    var playerDNI=document.getElementById("playerDNI").value;
    var playerNIF=document.getElementById("playerNIF").value;


    var playerAddress=document.getElementById("playerAddress").value;
    var playerAddressNumber=document.getElementById("playerAddressNumber").value;
    var playerAddressFloor=document.getElementById("playerAddressFloor").value;
    var playerAddressDoor=document.getElementById("playerAddressDoor").value;

    var playerAddressCity=document.getElementById("playerAddressCity").value;
    var playerAddressProvince=document.getElementById("playerAddressProvince").value;

    var playerCP=document.getElementById("playerAddressCP").value;

    var playerNationality=document.getElementById("playerNationality").value;
    var playerCountryOfBirth=document.getElementById("playerCountryOfBirth").value;
    var playerProvinceOfBirth=document.getElementById("playerProvinceOfBirth").value;

    var playerEmail=document.getElementById("playerEmail").value;
    var playerNotes=document.getElementById("playerNotes").value;

    /*var select=document.getElementById("playerPosition");
    var select_index = select.selectedIndex;
    var select_value=select.options[select_index].value;

    var playerPosition=select_value;
    */

    ajax = nuevoAjax();
    ajax.open("GET", "playerCardUpdate.php?idPlayer="+idPlayer+"&playerName="+playerName+"&playerBirthDate="+playerBirthDate+"&playerDNI="+playerDNI+"&playerNIF="+playerNIF+"&playerNumber="+playerNumber+"&playerAddress="+playerAddress+"&playerAddressNumber="+playerAddressNumber+"&playerAddressFloor="+playerAddressFloor+"&playerAddressDoor="+playerAddressDoor+"&playerAddressCity="+playerAddressCity+"&playerCP="+playerCP+"&playerAddressProvince="+playerAddressProvince+"&playerNationality="+playerNationality+"&playerCountryOfBirth="+playerCountryOfBirth+"&playerProvinceOfBirth="+playerProvinceOfBirth+"&playerEmail="+playerEmail+"&playerNotes="+playerNotes, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
    //alert(ajax.responseText);
    //playersByTeamId(idTeam);
    }
    }
    ajax.send(null)


}

function playerPositionUpdate(id,idPlayer,idTeam){
    playerCardUpdateNoRefresh(idPlayer,idTeam);
    //alert(id+" "+idPlayer+" "+idTeam);
    var select=document.getElementById("playerPosition"+id);
    var select_index = select.selectedIndex;
    var select_value=select.options[select_index].value;
    var playerPosition=select_value;

    //var playerNumber=getElementById("playerNumber"+id).value;
    var playerNumber=3;
    ajax3 = nuevoAjax();
    ajax3.open("GET", "playerPositionUpdate.php?playerPosition="+playerPosition+"&playerNumber="+playerNumber+"&idCard="+id, true);

    ajax3.onreadystatechange = function() {
        if (ajax3.readyState == 4) {
            
            playerCardEdit(idPlayer,idTeam);
        }
    }
    ajax3.send(null)
}
function playerCardDeleteConfirm(idCard, playerName,idTeam){
    var conf=confirm("Segur que vols la fitxa del jugador eliminar el jugador "+ playerName+" ?");
    if(conf==true){
        playerCardDelete(idCard,idTeam);

    }
}
function playerCardDelete(idCard,idTeam){
    
    ajax = nuevoAjax();
    ajax.open("GET", "playerCardDelete.php?idCard="+idCard, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            playersByTeamId(idTeam);
           
        //container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)
}

function playerCardInsert(idPlayer,idTeam){

    ajax = nuevoAjax();
    ajax.open("GET", "playerCardInsert.php?idPlayer="+idPlayer+"&idTeam="+idTeam, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            playerCardEdit(idPlayer,idTeam);

        //container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)
}

function cmptMatchDateManagement(idClub){
    //alert(idTeam);
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "cmptMatchDateManagement.php?idClub="+idClub, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
           
            container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)
}
function cmptMatchDateChange(idTeam,idMatch){
    //alert(idTeam);
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "cmptMatchDateChange.php?idTeam="+idTeam+"&idMatch="+idMatch, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            //playerCardEdit(idPlayer,idTeam);

            container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)
}


function cmptMatchDateChangeInsert(idTeam, idMatch){
    document.getElementById("cmptMatchDateChangeInsertButton").disabled = true
    document.getElementById("cmptMatchDateChangeInsertButton").value = "Enviant";
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    var date=document.getElementById("match_date").value;
    var time=document.getElementById("match_time").value;
    var comment=document.getElementById("matchChangeComment").value;
    //alert(date+" "+time+" "+comment);
    ajax.open("POST", "cmptMatchDateChangeInsert.php", true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText.length);
            if(ajax.responseText.length>1){
                document.getElementById("cmptMatchDateChangeInsertButton").enabled = true
                alert(ajax.responseText);
            }
            //playerCardEdit(idPlayer,idTeam);
            cmptMatchDateChange(idTeam,idMatch);
        //container1.innerHTML = ajax.responseText;

        }
    }
    ajax.setRequestHeader("Content-Type",
        "application/x-www-form-urlencoded");
    ajax.send("idTeam="+idTeam+"&idMatch="+idMatch+"&date="+date+"&time="+time+"&comment="+comment);

}
function cmptMatchDateAccept(id, idMatch, idTeam){
    
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
   
    ajax.open("GET", "cmptMatchDateChangeAccept.php?idMatch="+idMatch+"&id="+id, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            //playerCardEdit(idPlayer,idTeam);
            document.location.reload() 
        //container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)
}

function cmptMatchDateDeny(id, idMatch, idTeam){

    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();

    ajax.open("GET", "cmptMatchDateChangeDeny.php?idMatch="+idMatch+"&id="+id, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            //playerCardEdit(idPlayer,idTeam);
            document.location.reload() ;
        //cmptMatchDateChange(idTeam,idMatch);
        //container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)
}

function cmptMatchComplexInsert(idClub,idTeam,idMatch){
    //alert("a");
    var complexName=document.getElementById("cmptComplexName").value;
    var complexAddress=document.getElementById("cmptComplexAddress").value;

    ajax = nuevoAjax();
    ajax.open("POST", "cmptMatchComplexInsert.php", true);

    ajax.onreadystatechange = function() {
        //alert("b");
        if (ajax.readyState == 4) {
            //
            //alert(ajax.responseText);
            cmptMatchDateChange(idTeam,idMatch);
        //alert("c");
        }
    }
    ajax.setRequestHeader("Content-Type",
        "application/x-www-form-urlencoded");
    ajax.send("complexName="+complexName+"&complexAddress="+complexAddress+"&idClub="+idClub+"&idMatch="+idMatch);

}


function cmptMatchComplexPreview(){
    //alert("a");

    var complexAddress=document.getElementById("cmptComplexAddress").value;
    var c=encodeURIComponent(complexAddress);
    window.open("cmptMatchComplexPreview.php?complexAddress="+c);
}

function cmptComplexManagement(idClub){
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();

    ajax.open("GET", "cmptComplexManagement.php?idClub="+idClub, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)

}

function cmptComplexEdit(idComplex){
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();

    ajax.open("GET", "cmptComplexEdit.php?idComplex="+idComplex, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)

}

function cmptBills(hash,idClub){
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();

    ajax.open("GET", "cmptBills.php?hash="+hash+"&idClub="+idClub, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)

}