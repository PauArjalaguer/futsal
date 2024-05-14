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

function teamPlayersList(idTeam){
    // alert("S");
    ajax = nuevoAjax();
    ajax.open("GET", "teamPlayersList.php?idTeam="+idTeam, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
    //  alert(ajax.responseText);

    }
    }
    ajax.send(null)

}


function clubsAndTeamsSearch(){
    var search=document.getElementById("clubsAndTeamsSearchInput").value;
    ajax = nuevoAjax();
    ajax.open("GET", "clubsAndTeamsSearch.php?search="+search, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
    document.getElementById("ul_teams").innerHTML=ajax.responseText;

    }
    }
    ajax.send(null)

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
    
    ajax = nuevoAjax();
    ajax.open("GET", "clubInfoUpdate.php?clubAddress="+clubAddress+"&clubCity="+clubCity+"&clubEmail="+clubEmail+"&clubPhone1="+clubPhone1+"&clubPhone2="+clubPhone2+"&clubWeb="+clubWeb+"&clubFacebook="+clubFacebook+"&clubTwitter="+clubTwitter+"&clubHistory="+clubHistory+"&idClub="+idClub, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
    //  alert(ajax.responseText);
          
    }
    }
    ajax.send(null)

}

function clubCashingInfo(idClub){
    window.location.hash="init";


    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", " clubCashingInfo.php?idClub="+idClub, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
           
            container1.innerHTML = ajax.responseText;
            scroll(0,0);
        }
    }
    ajax.send(null)
}

function clubPaymentInsert(idClub){
    window.location.hash="init";

    var date=document.getElementById("paymentDate").value;
    var concept=document.getElementById("paymentConcept").value;
    var amount=document.getElementById("paymentAmount").value;
    var select=document.getElementById("paymentType");
    var select_index = select.selectedIndex;
    var select_value=select.options[select_index].value;
    var paymentType=select_value;


    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "  clubPaymentInsert.php?idClub="+idClub+"&concept="+concept+"&amount="+amount+"&date="+date+"&paymentType="+paymentType, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            // alert(ajax.responseText);
            clubCashingInfo(idClub);

        }
    }
    ajax.send(null)
}

function clubBallsBuyingForm(idClub){
    window.location.hash="init";


    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", " clubBallsBuyingForm.php?idClub="+idClub, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {

            container1.innerHTML = ajax.responseText;
            scroll(0,0);
        }
    }
    ajax.send(null)
}
function clubBallsBuyingInsert(idClub){
    window.location.hash="init";

    var amount=document.getElementById("clubBallsBuyingAmount").value;
    
    if(amount==0){
        alert("El valor no pot ser 0");
    }else{
        var container1=document.getElementById("rightContent");
        ajax = nuevoAjax();
        ajax.open("GET", " clubBallsBuyingInsert.php?idClub="+idClub+"&amount="+amount, true);

        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4) {
                //clubCashingInfo(idClub);
                //alert(ajax.responseText.length);
                if(ajax.responseText.length==0){
                    clubCashingInfo(idClub);
                }else{
                    alert(""+ajax.responseText+ " ");
                }
                scroll(0,0);
            }
        }
        ajax.send(null)
    }
}

function admClubPaymentConcepts(){//alert("a");

    var select=document.getElementById("admClubPaymentConcepts");
    var select_index = select.selectedIndex;
    var select_value=select.options[select_index].value;
    //alert(select_value);

    var concept=select_value;
    document.getElementById("paymentConcept").value=concept;


}
function clubTeamRegistrationForm(idClub){
    window.location.hash="init";   
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "clubTeamRegistrationForm.php?idClub="+idClub, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            container1.innerHTML = ajax.responseText;
            scroll(0,0);
        }
    }
    ajax.send(null)
    
}

function rateDivisionChangeEnableInput(id){
    //alert(id);
    document.getElementById("rateDivisionChangeInput_"+id).disabled=false;
    document.getElementById("changeButton").style.display="none";
    document.getElementById("rateDivisionChangeInput_1").value="";
     document.getElementById("rateDivisionChangeInput_1").focus();
}

function rateDivisionChangeVerifyAmount(money){

    var rate=document.getElementById("rateDivisionChangeInput_1").value;
    //alert(rate+ " "+money);
    if(rate>money){
        document.getElementById("acceptButton").style.display="none";
         document.getElementById("acceptButtonDisabled").style.display="inline";
    }else{
        document.getElementById("acceptButton").style.display="inline";
         document.getElementById("acceptButtonDisabled").style.display="none";
    }
}
function clubTeamRegistrationInsert(idClub, idTeam, originalRate){
    window.location.hash="init";
    var rate=document.getElementById("rateDivisionChangeInput_"+idTeam).value;
    //var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "  clubTeamRegistrationInsert.php?idClub="+idClub+"&idTeam="+idTeam+"&originalRate="+originalRate+"&rate="+rate, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
          //alert(rate+" "+originalRate);
            if(ajax.responseText.length==0){
                
                if(rate!=originalRate){
                    clubTeamRegistrationRateDivisionChangeReason(idTeam, idClub);
                }else{
                    clubCashingInfo(idClub);
                }
            }else{
                alert(ajax.responseText);
            }
            scroll(0,0);
            
        }
    }
    ajax.send(null)
    
}
function clubTeamRegistrationRateDivisionChangeReason(idTeam, idClub){
    window.location.hash="init";
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "clubTeamRegistrationRateDivisionChangeReason.php?idTeam="+idTeam+"&idClub="+idClub, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            container1.innerHTML = ajax.responseText;
            scroll(0,0);
        }
    }
    ajax.send(null)

}

function clubTeamRegistrationRateDivisionChangeReasonUpdate(idTeam, idClub) {
    var reason=document.getElementById("reason").value;


    ajax = nuevoAjax();

    ajax.open ('POST', 'clubTeamRegistrationRateDivisionChangeReasonUpdate.php', true);
    ajax.onreadystatechange = function() {

        if (ajax.readyState==4){
            //alert(ajax.responseText);
            clubTeamRegistrationForm(idClub)

        }


    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("reason="+reason+"&idClub="+idClub+"&idTeam="+idTeam);
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
    window.location.hash="init";
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
                //alert(ajax.responseText);
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

function playerCardMarkAsPayed(idPlayer,idTeam,originalRate){
var rate=document.getElementById("rateDivisionChangeInput_1").value;
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "playerCardMarkAsPayed.php?idPlayer="+idPlayer+"&idTeam="+idTeam+"&originalRate="+originalRate+"&rate="+rate, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            if(rate!=originalRate){
                    playerCardRegistrationRateDivisionChangeReason(idPlayer, idTeam);
                }else{
                    //clubCashingInfo(idClub);
                     playersByTeamId(idTeam);
                }
           
        //  container1.innerHTML = ajax.responseText;
        //$("form.jqtransform").jqTransform();
        }
    }
    ajax.send(null);

}
function playerCardRegistrationRateDivisionChangeReason(idPlayer, idTeam){
    window.location.hash="init";
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "playerCardRegistrationRateDivisionChangeReason.php?idTeam="+idTeam+"&idPlayer="+idPlayer, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            container1.innerHTML = ajax.responseText;
            scroll(0,0);
        }
    }
    ajax.send(null)

}


function playerCardRegistrationRateDivisionChangeReasonUpdate(idPlayer, idTeam) {
    var reason=document.getElementById("reason").value;


    ajax = nuevoAjax();

    ajax.open ('POST', 'playerCardRegistrationRateDivisionChangeReasonUpdate.php', true);
    ajax.onreadystatechange = function() {

        if (ajax.readyState==4){
            //alert(ajax.responseText);
             playersByTeamId(idTeam);

        }


    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("reason="+reason+"&idTeam="+idTeam+"&idPlayer="+idPlayer);
}
function playerCardMarkAsRejected(idPlayer,idTeam){

    var w=420;
    var h=450;
    openModal(w,h);
    ajax = nuevoAjax();
    ajax.open("GET", "playerCardMarkAsRejected.php?idPlayer="+idPlayer+"&idTeam="+idTeam, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            document.getElementById("modal").innerHTML=ajax.responseText;
            adjustModal(w,h);
        }
    }
    ajax.send(null)

}

function playerCardMarkAsRejectedSave(idPlayer,idTeam){

    var text=document.getElementById("rejectionReason").value
    ajax = nuevoAjax();
    ajax.open("GET", "playerCardMarkAsRejectedSave.php?idPlayer="+idPlayer+"&idTeam="+idTeam+"&text="+text, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            playersByTeamId(idTeam);
            hideModal();
        }
    }
    ajax.send(null)

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
    var w=350;
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
    ajax.send(null);

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
           // alert(ajax.responseText);
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
            alert(ajax.responseText);
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