function nuevoAjax() {
    var xmlhttp = false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch (e) {
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
var prevUlToShow;
function ulShow(ulToShow){
    if(prevUlToShow){
        document.getElementById(prevUlToShow).style.display="none";
        document.getElementById(prevUlToShow+"_a").className="nav-top-item";
    }
    document.getElementById(ulToShow).style.display="block";
    document.getElementById(ulToShow+"_a").className +=" current";

    prevUlToShow=ulToShow;
}

var prevIdClub;

//SECCIO NOTICIES

function newsNewForm(){
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "newsNewForm.php", true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            // document.getElementById("teamsList_"+idTeam).className='listCurrent';
            // prevTeam=idTeam;
            container1.innerHTML = ajax.responseText;
            $(function(){
                $('#matchCommentTextArea').wysiwyg();
            });
        }
    }
    ajax.send(null)

}



// SECCIO EQUIPS I CLUBS //
function teamsByClubId(idClub) {
    if(prevIdClub){
        document.getElementById("teamsByClubId_"+prevIdClub).style.display="none";

    }
    var container=document.getElementById("teamsByClubId_"+idClub);
    ajax = nuevoAjax();
    ajax.open("GET", "teamsByClubId.php?idClub="+idClub, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            container.style.display="block";
            container.innerHTML = ajax.responseText;
            prevIdClub=idClub;
            clubShowInfo(idClub);
        }
    }

    ajax.send(null)
}


function clubsNew(){
    scroll(0,0);

    var container1=document.getElementById("rightContent");
    ajax123 = nuevoAjax();
    ajax123.open("GET", "clubsNew.php", true);

    ajax123.onreadystatechange = function() {
        if (ajax123.readyState == 4) {

            container1.innerHTML = ajax123.responseText;

        }
    }
    ajax123.send(null)
}
function clubsNewSave(){
    var  name=document.getElementById("newClubNameInput").value;
    var  email=document.getElementById("newClubEmailInput").value;
    var  web=document.getElementById("newClubWebInput").value;
    var  city=document.getElementById("newClubCityInput").value;
    //alert(email+" "+idClub);
    var url = "clubsNewSave.php";
    var params = "name="+name+"&email="+email+"&web="+web+"&city="+city;
    //alert(params);
    ajax = nuevoAjax();
    ajax.open("POST", url, true);

    //Send the proper header information along with the request


    ajax.onreadystatechange = function() {//Call a function when the state changes.
        if(ajax.readyState == 4 && ajax.status == 200) {
            //alert(ajax.responseText);
            clubShowInfo(ajax.responseText);
        }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    ajax.send(params);

}
function clubShowInfo(idClub){
    scroll(0,0);

    var container1=document.getElementById("rightContent");
    ajax123 = nuevoAjax();
    ajax123.open("GET", "clubsShowInfo.php?idClub="+idClub, true);

    ajax123.onreadystatechange = function() {
        if (ajax123.readyState == 4) {
         
            container1.innerHTML = ajax123.responseText;

        }
    }
    ajax123.send(null)
}
function teamNameSwitch(idTeam){
    document.getElementById("teamName_"+idTeam).style.display="none";
    document.getElementById("teamInput_"+idTeam).style.display="block";
}

function teamInputSwitch(idTeam){
    document.getElementById("teamName_"+idTeam).style.display="block";
    document.getElementById("teamInput_"+idTeam).style.display="none";
}


function teamNameUpdate(idTeam){
    var  name=document.getElementById("teamInput_"+idTeam).value;

    //alert(email+" "+idClub);
    var url = "teamNameUpdate.php";
    var params = "name="+name+"&id="+idTeam;
    //alert(params);
    ajax = nuevoAjax();
    ajax.open("POST", url, true);

    //Send the proper header information along with the request


    ajax.onreadystatechange = function() {//Call a function when the state changes.
        if(ajax.readyState == 4 && ajax.status == 200) {
            document.getElementById("teamName_"+idTeam).innerHTML=name;
            //alert(ajax.responseText);
           // clubShowInfo(ajax.responseText);
        }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    ajax.send(params);

}
function clubNewUserAccount(idClub){
    var  email=document.getElementById("newUserAccount").value;
    //alert(email+" "+idClub);
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "clubNewUserAccount.php?idClub="+idClub+"&email="+email+"&idRole=1", true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)

}
function clubDeleteUserAccount(idUserAccount,idClub){

    ajax = nuevoAjax();
    ajax.open("GET", "clubDeleteUserAccount.php?idUserAccount="+idUserAccount, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            //container1.innerHTML = ajax.responseText;
            clubShowInfo(idClub);
        }
    }
    ajax.send(null)

}
var team;
var prevTeam;
function teamsShowInfo(idTeam){
    team=idTeam;
    if(prevTeam){
        document.getElementById("teamsList_"+prevTeam).className='';
    }
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "teamsShowInfo.php?idTeam="+idTeam, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            document.getElementById("teamsList_"+idTeam).className='listCurrent';
            prevTeam=idTeam;
            container1.innerHTML = ajax.responseText;
           
        }
    }
    ajax.send(null)
}

function teamsInsertPlayer(idTeam){
    var playerName=document.getElementById("newPlayerName").value;
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "teamsInsertPlayer.php?idTeam="+idTeam+"&playerName="+playerName, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            teamsShowInfo(idTeam);
        //container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)
}

function teamsDeletePlayerConfirm(idPlayer, playerName){
    var conf=confirm("Segur que vols eliminar el jugador "+ playerName+" ?");
    if(conf==true){
        teamsDeletePlayer(idPlayer);

    }
}
function teamsDeletePlayer(idPlayer){
    alert("Eliminant jugador");
    
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "teamsDeletePlayer.php?idPlayer="+idPlayer, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            teamsShowInfo(idTeam);
        //alert(ajax.responseText);
        //container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)
}

function teamsEditPlayerName(idPlayer){
    document.getElementById("playerNameEditContainer_"+idPlayer).style.display="block";
}
function teamsUpdatePlayerNameConfirm(idPlayer){
    var newName=document.getElementById("playerNameEditInput_"+idPlayer).value;
    var oldName=document.getElementById("playerPreviousNameEditInput_"+idPlayer).value;
    var conf=confirm("Segur que vols modificar el nom del jugador "+ oldName+" per "+newName+" ?");
    if(conf==true){
        teamsUpdatePlayerName(idPlayer,newName);

    }
}

function teamsUpdatePlayerName(idPlayer,playerName){
    

    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "teamsUpdatePlayerName.php?idPlayer="+idPlayer+"&playerName="+playerName, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            teamsShowInfo(team);
        //alert(ajax.responseText);
        //container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)
}


//SECCIO COMPETICIO//

function classificationRecalculate(idLeague,idSeason) {
    //alert(idLeague);

    ajax123 = nuevoAjax();
    ajax123.open("GET", "classificationRecalculate.php?idLeague="+idLeague+"&idSeason="+idSeason, true);

    ajax123.onreadystatechange = function() {
        if (ajax123.readyState == 4) {
            //alert(ajax.responseText);

            alert(ajax123.responseText);

        }
    }
    ajax123.send(null)
}

var prevIdLeague;
function roundsByLeagueId(idLeague) {
    //alert(idLeague);
    if(prevIdLeague){
        document.getElementById("roundsByLeagueId_"+prevIdLeague).style.display="none";

    }
    var container=document.getElementById("roundsByLeagueId_"+idLeague);
    ajax = nuevoAjax();
    ajax.open("GET", "roundsByLeagueId.php?idLeague="+idLeague, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            container.style.display="block";
            container.innerHTML = ajax.responseText;
            prevIdLeague=idLeague;
        }
    }
    ajax.send(null)
}

var round;
var prevRound;
function roundsShowInfo(idRound){
    round=idRound;
    if(prevRound){
        document.getElementById("roundsList_"+prevRound).className='';
    }
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "roundsShowInfo.php?idRound="+idRound, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText)
            document.getElementById("roundsList_"+idRound).className='listCurrent';
            prevRound=idRound;
            container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)
}
function matchEdit(idMatch){

    //alert(idMatch);
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "matchEdit.php?idMatch="+idMatch, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            // alert(ajax.responseText);
            container1.innerHTML = ajax.responseText;
            $(function(){
                $('#matchCommentTextArea').wysiwyg();
            });

        }
    }
    ajax.send(null)
}

function matchDelete(idMatch){

    //alert(idMatch);

    ajax = nuevoAjax();
    ajax.open("GET", "matchDelete.php?idMatch="+idMatch, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            // alert(ajax.responseText);
            matchEdit(idMatch);

        }
    }
    ajax.send(null)
}
function matchStatusChange(idMatch,idStatus){
    ajax = nuevoAjax();
    ajax.open("GET", "matchStatusChange.php?idMatch="+idMatch+"&idStatus="+idStatus, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            matchEdit(idMatch);
        //container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)
}

function matchResultInsert(idMatch){
    var localResult=document.getElementById("localResultInput").value;
    var visitorResult=document.getElementById("visitorResultInput").value;
    var idLeague=document.getElementById("idLeague").value;
    var localId=document.getElementById("idLocal").value;
    var visitorId=document.getElementById("idVisitor").value;


    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "matchResultInsert.php?idMatch="+idMatch+"&local="+localResult+"&visitor="+visitorResult+"&idLeague="+idLeague+"&localId="+localId+"&visitorId="+visitorId, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            matchEdit(idMatch);
            container1.innerHTML = ajax.responseText;

        }
    }
    ajax.send(null)


}
function matchResultInsertFromIndexPage(idMatch){
    var localResult=document.getElementById("localResultInput_"+idMatch).value;
    var visitorResult=document.getElementById("visitorResultInput_"+idMatch).value;
    var idLeague=document.getElementById("idLeague_"+idMatch).value;
    var localId=document.getElementById("idLocal_"+idMatch).value;
    var visitorId=document.getElementById("idVisitor_"+idMatch).value;


    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "matchResultInsert.php?idMatch="+idMatch+"&local="+localResult+"&visitor="+visitorResult+"&idLeague="+idLeague+"&localId="+localId+"&visitorId="+visitorId, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
           // alert(ajax.responseText);
           // matchEdit(idMatch);
           // container1.innerHTML = ajax.responseText;
            document.getElementById("rowMatch_"+idMatch).style.display="none";

        }
    }
    ajax.send(null)


}

function matchChangePlayerStatus(idPlayer,idMatch,localId,visitorId,team){
    var check=document.getElementById("playerRadio_"+idPlayer+"_"+team).checked;
    if(check==true){
        var action="insert";
    }else{
        var action="delete";
    }
    if(team=="local"){
        var t=localId;
    }else{
        var t=visitorId;
    }
    ajax = nuevoAjax();

   
    ajax.open("GET", "matchChangePlayerStatus.php?idMatch="+idMatch+"&idPlayer="+idPlayer+"&action="+action+"&idTeam="+t, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            document.getElementById("goalPlayerUpdateSuccess_"+idPlayer).innerHTML="<img src='images/tick.png'>";
            matchGoalsAndCards(idMatch,localId,visitorId);

        }
    }
    ajax.send(null)


//alert(document.getElementById("playerRadio_"+idPlayer).checked);
}

function matchGoalsAndCards(idMatch,localId,visitorId){
    ajax = nuevoAjax();


    ajax.open("GET", "matchGoalsAndCards.php?idMatch="+idMatch+"&localId="+localId+"&visitorId="+visitorId+"&ajax="+ajax, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            document.getElementById("matchGoalsAndCards").innerHTML=ajax.responseText;
        //alert(ajax.responseText);


        }
    }
    ajax.send(null)
}

function matchSetTeamOnNextMatch(position, idTeam, idMatch){

    ajax = nuevoAjax();
    ajax.open("GET", "matchSetTeamOnNextMatch.php?position="+position+"&idTeam="+idTeam+"+&idMatch="+idMatch, true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
    //document.getElementById("goalUpdateSuccess_"+idGoal).innerHTML="<img src='images/tick.png'>";
    alert(ajax.responseText);

    }
    }
    ajax.send(null)
}
function goalsUpdateByPlayerIdAndMatchId(idPlayer,idMatch){ //alert(idPlayer+" "+idMatch);
    var number=document.getElementById("goalInput_"+idPlayer).value;
    var own=document.getElementById("ownGoalInput_"+idPlayer).value;
    ajax = nuevoAjax();
    ajax.open("GET", "goalsUpdateByPlayerIdAndMatchId.php?number="+number+"&own="+own+"&idPlayer="+idPlayer+"+&idMatch="+idMatch, true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
    //document.getElementById("goalUpdateSuccess_"+idGoal).innerHTML="<img src='images/tick.png'>";
    //alert(ajax.responseText);

    }
    }
    ajax.send(null)


}
function goalUpdatePlayerId(idGoal){
    var select=document.getElementById("playersListSelect_"+idGoal);
    var selectedI=select.selectedIndex;
    var idPlayer=select.options[selectedI].value;
   
    var lbl=select.options[selectedI].parentNode.label;
    ajax = nuevoAjax();
    if(lbl!="Gols"){
        var own=1;
    }


    ajax.open("GET", "goalUpdatePlayerId.php?idGoal="+idGoal+"&idPlayer="+idPlayer+"&own="+own, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {

    //container1.innerHTML =
    //alert(ajax.responseText);

    }
    }
    ajax.send(null)
   
}

function goalUpdateMinute(idGoal){
    var minute=document.getElementById("goalMinuteInput_"+idGoal).value;
    
    ajax = nuevoAjax();



    ajax.open("GET", "goalUpdateMinute.php?idGoal="+idGoal+"&minute="+minute, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            document.getElementById("goalUpdateSuccess_"+idGoal).innerHTML="<img src='images/tick.png'>";
            

        //container1.innerHTML =
        //alert(ajax.responseText);

        }
    }
    ajax.send(null)


}

function matchCardsUpdate(idPlayer,idMatch,idRound){
    var yellowCards=document.getElementById("matchYellowCardsInput_"+idPlayer).value;
    var blueCards=document.getElementById("matchBlueCardsInput_"+idPlayer).value;

    ajax = nuevoAjax();
    ajax.open("GET", "matchCardsUpdate.php?idPlayer="+idPlayer+"&idMatch="+idMatch+"&yellowCards="+yellowCards+"&blueCards="+blueCards, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
          
            if(confirm(ajax.responseText)==true)
            {
                matchCardsUpdateConfirm(idPlayer,idMatch,yellowCards,blueCards,idRound)
            }
           

            
        }
    }
    ajax.send(null)
}
function  matchCardsUpdateConfirm(idPlayer,idMatch,yellowCards,blueCards,idRound)  {
    var yellowCards=document.getElementById("matchYellowCardsInput_"+idPlayer).value;
    var blueCards=document.getElementById("matchBlueCardsInput_"+idPlayer).value;

    ajax1 = nuevoAjax();
    ajax1.open("GET", "matchCardsUpdateConfirm.php?idPlayer="+idPlayer+"&idMatch="+idMatch+"&yellowCards="+yellowCards+"&blueCards="+blueCards+"&idRound="+idRound, true);

    ajax1.onreadystatechange = function() {
        if (ajax1.readyState == 4) {
    //alert(ajax1.responseText);
    }

    }

    ajax1.send(null)
}


function  matchBlueCardsUpdate(idPlayer,idMatch,yellowCards,blueCards,idRound)  {
    var yellowCards=document.getElementById("matchYellowCardsInput_"+idPlayer).value;
    var blueCards=document.getElementById("matchBlueCardsInput_"+idPlayer).value;

    ajax = nuevoAjax();
    ajax.open("GET", "matchBlueCardsUpdate.php?idPlayer="+idPlayer+"&idMatch="+idMatch+"&yellowCards="+yellowCards+"&blueCards="+blueCards+"&idRound="+idRound, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {

    }
    }
    ajax.send(null)
}
function matchCommentUpdate(idMatch){
    var url = "matchCommentUpdate.php";
    var comment=document.getElementById("matchCommentTextArea").value;
    var params = "idMatch="+idMatch+"&comment="+comment;
    //alert(params);
    ajax = nuevoAjax();
    ajax.open("POST", url, true);

    //Send the proper header information along with the request


    ajax.onreadystatechange = function() {//Call a function when the state changes.
        if(ajax.readyState == 4 && ajax.status == 200) {
    //alert(ajax.responseText);
    }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    ajax.send(params);
}
function comiteeShowInfo(date){
    //alert(date);
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "comiteeShowInfo.php?date="+date, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            container1.innerHTML =ajax.responseText;
        }
    }
    ajax.send(null)
}
function comiteeNewBan(idRound,date){
    //alert(idRound+" "+date);
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "comiteeNewBan.php?idRound="+idRound+"&date="+date, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            container1.innerHTML =ajax.responseText;
        }
    }
    ajax.send(null)
}


function comiteeNewBanSave(idRound,date){
    var select=document.getElementById("comiteeNewBanPlayerSelect");
    var selectedI=select.selectedIndex;
    var idPlayer=select.options[selectedI].value;
    var numberofrounds=document.getElementById('comiteeNewBanNumberOfMatches').value;
    var money=document.getElementById('comiteeNewBanMoney').value;
    var comment=document.getElementById('comiteeNewBanComment').value;
    ajax = nuevoAjax();
    ajax.open("GET", "comiteeNewBanSave.php?idPlayer="+idPlayer+"&numberofrounds="+numberofrounds+"&idRound="+idRound+"&comment="+comment+"&money="+money, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            comiteeShowInfo(date);

        }
    }
    ajax.send(null)
}

function comiteeEditBan(id,idRound,date){
    //alert(idRound+" "+date);
    var container1=document.getElementById("rightContent");
    ajax = nuevoAjax();
    ajax.open("GET", "comiteeEditBan.php?id="+id+"&idRound="+idRound+"&date="+date, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            container1.innerHTML =ajax.responseText;
        }
    }
    ajax.send(null)
}

function comiteeEditBanSave(id,idRound,date){
    var select=document.getElementById("comiteeNewBanPlayerSelect");
    var selectedI=select.selectedIndex;
    var idPlayer=select.options[selectedI].value;
    var numberofrounds=document.getElementById('comiteeNewBanNumberOfMatches').value;
    var money=document.getElementById('comiteeNewBanMoney').value;
    var comment=document.getElementById('comiteeNewBanComment').value;
    ajax = nuevoAjax();
    ajax.open("GET", "comiteeEditBanSave.php?id="+id+"&idPlayer="+idPlayer+"&numberofrounds="+numberofrounds+"&idRound="+idRound+"&comment="+comment+"&money="+money, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
            comiteeShowInfo(date);

        }
    }
    ajax.send(null)
}
function comiteeGenerateWord(date){
    ajax = nuevoAjax();
    ajax.open("GET", "comiteeGenerateWord.php?date="+date, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            document.getElementById("comiteeResult").innerHTML=ajax.responseText;


            //container1.innerHTML =
            //alert(ajax.responseText);
            var url="../Actes/ActaComite"+date.replace(/-/gi,"")+".doc";
            window.open(url);

        }
    }
    ajax.send(null)

}
function playersUpdateTeam(idPlayer){
     var select=document.getElementById("playersUpdateTeamSelect_"+idPlayer);
    var selectedI=select.selectedIndex;
    var idTeam=select.options[selectedI].value;

    ajax = nuevoAjax();
    ajax.open("GET", "playersUpdateTeam.php?idTeam="+idTeam+"&idPlayer="+idPlayer, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
           
           // document.getElementById("rowPlayer_"+ajax.responseText).style.display="none";
            document.getElementById("rowPlayer_"+ajax.responseText).style.display="none";

        }
    }
    ajax.send(null)
}

function matchTeamTransfererInsert(idTeam, idClub, idMatch){
     var select=document.getElementById("matchTeamTransfererInsertSelect_"+idClub);
    var selectedI=select.selectedIndex;
    var idTeamT=select.options[selectedI].value;

    ajax = nuevoAjax();
    ajax.open("GET", "matchTeamTransfererInsert.php?idTeam="+idTeam+"&idClub="+idClub+"&idTeamT="+idTeamT, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            //alert(ajax.responseText);
           
           // document.getElementById("rowPlayer_"+ajax.responseText).style.display="none";
            //document.getElementById("rowPlayer_"+ajax.responseText).style.display="none";
            matchEdit(idMatch);

        }
    }
    ajax.send(null)
}


function matchSelectAllPlayersByIdTeamAndIdMatch(idMatch, idTeam, idTeamMatch){
    
    ajax = nuevoAjax();
    ajax.open("GET", "matchSelectAllPlayersByIdTeamAndIdMatch.php?idMatch="+idMatch+"&idTeam="+idTeam+"&idTeamMatch="+idTeamMatch, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
                        matchEdit(idMatch);

        }
    }
    ajax.send(null)
}