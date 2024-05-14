<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?
//echo $_GET['idMatch'];




//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx=conectar();

$res = mysql_query("select id,matchWinnerLocal, matchWinnerVisitor from matches where matchWinnerLocal=".$_GET['idMatch']." or matchWinnerVisitor=".$_GET['idMatch']." ") or die(mysql_error());
$row = mysql_fetch_array($res);
//echo $row['id']."-".$row['matchWinnerLocal']."-".$row['matchWinnerVisitor'];
if($_GET['idMatch']==$row['matchWinnerLocal']){
    $position="idlocal";
}else{
    $position="idvisitor";
}
$nextMatch=$row['id'];

$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];
$idSeson=$lastSeasonId;
//Nom equip
//echo $_GET['idMatch'];
$res = mysql_query("SELECT t1.name as local, t2.name as visitor,localResult, visitorResult, idMatch, m.statusId, ms.color,t1.id as localId, t2.id as visitorId,ro.id as roundId,ro.name as roundName,l.id as idLeague,l.name as leagueName,m.comment   from matches m
			left join results r on m.id=r.idMatch
			join teams t1 on t1.id=m.idLocal
			join teams t2 on t2.id=m.idvisitor
			join rounds ro on ro.id=m.idround
			join leagues l on l.id=ro.idleague
			left join matchstatus ms on m.statusid=ms.id where m.id=" . $_GET['idMatch']) or die(mysql_error());
$row = mysql_fetch_array($res);
$nRes=mysql_num_rows($res);
//echo $row['statusId'];

$out .= "<h1 onClick='matchEdit(" . $_GET['idMatch'] . ");'>Partit  " . $row['local'] . " - " . $row['visitor'] . " de la " . $row['roundName'] . "ª jornada de " . $row['leagueName'] . "</h1>";

$n = 1;
if($row['localResult']==$row['visitorResult']){
    $w="30";
}else{
    $w="10";
}
//Jugadors
$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Resultat</h2></div>";
$out .="<div class='contentBoxContent'>";
$out .="<table class='playersTable' cellspacing=0><tr><th width=20>&nbsp;</th><th >Equip Local</th><th>Equip visitant</th><th style='text-align:center;'>Marcador</th><th width=$w colspan=2>&nbsp;</th></tr>";

$out .="<tr>";
$out .="<td class='zebra$n' ><div style='width:15px; height:15px; border:1px solid #424242; background-color:#" . $row['color'] . "'>";
$out .="<td class='zebra$n' >" . $row['local'] . "</td><td class='zebra$n' >" . $row['visitor'] . "</td>";
$out .="<td class='zebra$n' style='text-align:center;' ><input type='text' id='localResultInput' class='resultInput' value='" . $row['localResult'] . "'> -  <input type='text' id='visitorResultInput' class='resultInput' value='" . $row['visitorResult'] . "'>";

$out .="</td>";
if($row['localResult']==$row['visitorResult']){
    $out .="<td class='zebra$n'>
    <span style='cursor:pointer;' onClick=\"matchSetTeamOnNextMatch('".$position."',".$row['localId'].",".$nextMatch."); \" >
    Passa ".$row['local']."</span><br />
    <span style='cursor:pointer;' onClick=\"matchSetTeamOnNextMatch('".$position."',".$row['visitorId'].",".$nextMatch."); \" >
    Passa ".$row['visitor']."</span></td>";
}
$out .="<input type='hidden' id='idLeague' value='" . $row['idLeague'] . "'><input type='hidden' id='idLocal' value='" . $row['localId'] . "'><input type='hidden' id='idVisitor' value='" . $row['visitorId'] . "'>";

//si no te gols introduits a la taula els crea
/* $resGV = mysql_query("select count(*) as gols from player_goals_match where idMatch=" . $_GET['idMatch']);

  $rowGV = mysql_fetch_array($resGV);
  if ($rowGV['gols'] == 0) {
  //echo "Inserta gols".$row['localResult']." ".$row['visitorResult'];

  for ($a = 1; $a <= $row['localResult']; $a++) {
  //echo "Gol local:" . $a . "<br />";
  mysql_query("insert into player_goals_match (idMatch,idTeam) values (" . $_GET['idMatch'] . "," . $row['localId'] . ")") or die(mysql_error());
  }
  for ($a = 1; $a <= $row['visitorResult']; $a++) {
  //echo "Gol visitant:" . $a . "<br />";
  mysql_query("insert into player_goals_match (idMatch,idTeam) values (" . $_GET['idMatch'] . "," . $row['visitorId'] . ")") or die(mysql_error());
  }
  } */


if ($row['statusId']!=4) {
    //echo "empty";
    $out .="<td class='zebra$n'><input type='button' class=\"playerNameEditButton\" onClick=\"matchResultInsert(" . $_GET['idMatch'] . ")\" value=\"Guardar\"></td>";
} else {
    //$out .="<td class='zebra$n'><input type='button' class=\"playerNameEditButton\" onClick=\"matchResultUpdate(" . $_GET['idMatch'] . ")\" value=\"Actualitzar\"></td>";
    $out .="<td class='zebra$n'>&nbsp;</td>";
}

$out .="</tr>";
$out .= "</table>";
$out .="</div>";

$out .="</div>";
$out .="<div class='contentBoxSpacer'></div>";




if ($row['statusId']==4) {
//Targetes


    $out .="<div class='contentBox'>";
    $out .="<div class='contentBoxHeader'><h2>Gols i Targetes</h2></div>";
    $out .="<div class='contentBoxContent' id='matchGoalsAndCards'>";
    include "matchGoalsAndCards.php";

    $out .="</div>";
    $out .="<div class='contentBoxSpacer'></div>";

    //LLISTA DE JUGADORS DEL PARTIT
    $out .="<div class='contentBox'>";
    $out .="<div class='contentBoxHeader'><h2>Plantilla</h2></div>";
    $out .="<div class='contentBoxContent'>";
    $out .="<div style='width:50%; float:left;'>";
    $out .="<h2>" . $row['local'] . "</h2>";

    $resPlayersL = mysql_query("
        select p.id
            ,p.name
            ,number
            ,(select count(*) from matches_players where idPlayer=p.id and idMatch=" . $_GET['idMatch'] . ") as played
            
        from players p
        join player_team_season pts on pts.idplayer=p.id
         
        where (idTeam=" . $row['localId'] . ")
        and pts.idseason=$lastSeasonId and ispayed=1 and isdeleted!=1 order by p.name") or die(mysql_error());
    $playersLocalArray = array();
 
    while ($rowPlayersL = mysql_fetch_array($resPlayersL)) {
        $checked = "";
        if ($n == 1) {
            $n = 2;
        } else {
            $n = 1;
        }

        if ($rowPlayersL['played'] > 0) {
            $checked = "checked";
        }
        //$localList .="<option value=\"" . $rowPlayersL['id'] . "\">" . $rowPlayersL['name'] . "</option>";
        array_push($playersLocalArray, $rowPlayersL);
        if ($teamName != $rowPlayersL['teamName']) {
            $out .="<div style='font-weight:bold;margin:10px 0;'>" . $rowPlayersL['teamName'] . "</div>";
        }
        $out .="<div class='playerWithRadioDiv zebra$n' ><input type='checkbox' $checked  id='playerRadio_" . $rowPlayersL['id'] . "_local' onChange='matchChangePlayerStatus(" . $rowPlayersL['id'] . "," . $_GET['idMatch'] . "," . $row['localId'] . "," . $row['visitorId'] . ",\"local\");'>  " . $rowPlayersL['name'] . " " . $rowPlayersL['teamName'] . " <span id=\"goalPlayerUpdateSuccess_" . $rowPlayersL['id'] . "\"></span></div>";
        $teamName = $rowPlayersL['teamName'];
    }
    $resPlayersL = mysql_query("
        select distinct p.id
            ,p.name
            ,number
            ,(select count(*) from matches_players where idPlayer=p.id and idMatch=" . $_GET['idMatch'] . ") as played
            ,t.name as teamName
        from players p
        join player_team_season pts on pts.idplayer=p.id
        join teams_cession_relation tcr on tcr.idTeamTransfered=" . $row['localId'] . "
        right join teams t on t.id=tcr.idTeamTransferer
        where (idTeam=tcr.idTeamTransferer)
        and pts.idseason=$lastSeasonId and ispayed=1 and isdeleted!=1 order by tcr.idTeamTransferer,p.name") or die(mysql_error());

   $playersLocalArray = array();
    while ($rowPlayersL = mysql_fetch_array($resPlayersL)) {
        $checked = "";
        if ($n == 1) {
            $n = 2;
        } else {
            $n = 1;
        }

        if ($rowPlayersL['played'] > 0) {
            $checked = "checked";
        }
        //$localList .="<option value=\"" . $rowPlayersL['id'] . "\">" . $rowPlayersL['name'] . "</option>";
        array_push($playersLocalArray, $rowPlayersL);
        if ($teamName != $rowPlayersL['teamName']) {
            $out .="<div style='font-weight:bold;margin:10px 0;'>" . $rowPlayersL['teamName'] . "</div>";
        }
        $out .="<div class='playerWithRadioDiv zebra$n' ><input type='checkbox' $checked  id='playerRadio_" . $rowPlayersL['id'] . "_local' onChange='matchChangePlayerStatus(" . $rowPlayersL['id'] . "," . $_GET['idMatch'] . "," . $row['localId'] . "," . $row['visitorId'] . ",\"local\");'>  " . $rowPlayersL['name'] . " <span id=\"goalPlayerUpdateSuccess_" . $rowPlayersL['id'] . "\"></span></div>";
        $teamName = $rowPlayersL['teamName'];
    }
    $out .="</div>";
    $out .="<div style='width:50%; float:left;'>";
    $out .="<h2>" . $row['visitor'] . "</h2>";
    $resPlayersV = mysql_query("
        select
        p.id
        ,p.name
        ,number
        ,(select count(*) from matches_players where idPlayer=p.id and idMatch=" . $_GET['idMatch'] . ") as played
        from players p
        join player_team_season pts on pts.idplayer=p.id
        where idTeam=" . $row['visitorId'] . "
        and pts.idseason=$lastSeasonId and ispayed=1 and isdeleted!=1
        order by p.name") or die(mysql_error());
    $playersVisitorArray = array();
    while ($rowPlayersV = mysql_fetch_array($resPlayersV)) {
        $checked = "";
        if ($n == 1) {
            $n = 2;
        } else {
            $n = 1;
        }

        if ($rowPlayersV['played'] > 0) {
            $checked = "checked";
        }
        //$visitorList .="<option value=\"" . $rowPlayersV['id'] . "\">" . $rowPlayersV['name'] . "</option>";
        array_push($playersVisitorArray, $rowPlayersV);
        $out .="<div class='playerWithRadioDiv zebra$n' ><input id='playerRadio_" . $rowPlayersV['id'] . "_visitor' type='checkbox' $checked onChange='matchChangePlayerStatus(" . $rowPlayersV['id'] . "," . $_GET['idMatch'] . "," . $row['localId'] . "," . $row['visitorId'] . ",\"visitor\");'>" . $rowPlayersV['name'] . " <span id=\"goalPlayerUpdateSuccess_" . $rowPlayersV['id'] . "\"></span></div>";
    }
    $resPlayersV = mysql_query("
        select distinct p.id
            ,p.name
            ,number
            ,(select count(*) from matches_players where idPlayer=p.id and idMatch=" . $_GET['idMatch'] . ") as played
            ,t.name as teamName
        from players p
        join player_team_season pts on pts.idplayer=p.id
         join teams_cession_relation tcr on tcr.idTeamTransfered=" . $row['visitorId'] . "
        right join teams t on t.id=tcr.idTeamTransferer
        where (idTeam=tcr.idTeamTransferer)
        and pts.idseason=$lastSeasonId and ispayed=1 and isdeleted!=1 order by tcr.idTeamTransferer,p.name") or die(mysql_error());

    while ($rowPlayersV = mysql_fetch_array($resPlayersV)) {
        $checked = "";
        if ($n == 1) {
            $n = 2;
        } else {
            $n = 1;
        }

        if ($rowPlayersV['played'] > 0) {
            $checked = "checked";
        }
        //$localList .="<option value=\"" . $rowPlayersL['id'] . "\">" . $rowPlayersL['name'] . "</option>";
        array_push($playersLocalArray, $rowPlayersL);
        if ($teamName != $rowPlayersV['teamName']) {
            $out .="<div style='font-weight:bold;margin:10px 0;'>" . $rowPlayersV['teamName'] . "</div>";
        }
        $out .="<div class='playerWithRadioDiv zebra$n' ><input type='checkbox' $checked  id='playerRadio_" . $rowPlayersV['id'] . "_visitor' onChange='matchChangePlayerStatus(" . $rowPlayersV['id'] . "," . $_GET['idMatch'] . "," . $row['localId'] . "," . $row['visitorId'] . ",\"visitor\");'>  " . $rowPlayersV['name'] . "  <span id=\"goalPlayerUpdateSuccess_" . $rowPlayersV['id'] . "\"></span></div>";
        $teamName = $rowPlayersV['teamName'];
    }
    $out .="</div>";
    $out .="<div style='clear:both;'></div>";

    $out .="</div>";
    $out .="</div>";
    $out .="<div class='contentBoxSpacer'></div>";

//Assignació de gols
    /*
      $out .="<div class='contentBox'>";
      $out .="<div class='contentBoxHeader'><h2>Gols</h2></div>";
      $out .="<div class='contentBoxContent'>";
      $out .="<div style='width:50%; float:left;'>";
      $out .="<h2>" . $row['local'] . "</h2>";
      $resGoals = mysql_query("Select id,idPlayer, minute, own from  player_goals_match where idMatch=" . $_GET['idMatch'] . " and idTeam=" . $row['localId']) or die(mysql_error());

      while ($rowGoals = mysql_fetch_array($resGoals)) {
      $out .="<div><select id=\"playersListSelect_" . $rowGoals['id'] . "\" onChange='goalUpdatePlayerId(" . $rowGoals['id'] . ");'><option disabled>Seleccionar jugador</option>";
      $out .="<optgroup label=\"Gols\">";
      //$out .=$localList;

      foreach ($playersLocalArray as $p) {
      if ($rowGoals['idPlayer'] == $p[0]) {
      $selected = " selected";
      } else {
      $selected = "";
      }
      $out .="<option value=\"" . $p[0] . "\" $selected>" . $p[1] . "</option>";
      }
      $out .="</optgroup>";
      $out .="<optgroup label=\"Propia porta\">";
      foreach ($playersVisitorArray as $p) {
      if ($rowGoals['idPlayer'] == $p[0]) {
      $selected = " selected";
      } else {
      $selected = "";
      }
      $out .="<option value=\"" . $p[0] . "\" $selected>" . $p[1] . " (pp)</option>";
      }
      $out .="</optgroup>";
      $out .="</select> <input type='text' class='minuteInput' id='goalMinuteInput_" . $rowGoals['id'] . "' onChange='goalUpdateMinute(" . $rowGoals['id'] . ");' value='" . $rowGoals['minute'] . "'> <span id=\"goalUpdateSuccess_" . $rowGoals['id'] . "\"></span></div>";
      }
      $out .="</div>";
      $out .="<div style='width:50%; float:left;'>";
      $out .="<h2>" . $row['visitor'] . "</h2>";
      $resGoals = mysql_query("Select id,idPlayer, minute, own from  player_goals_match where idMatch=" . $_GET['idMatch'] . " and idTeam=" . $row['visitorId']) or die(mysql_error());

      while ($rowGoals = mysql_fetch_array($resGoals)) {
      $out .="<div><select id=\"playersListSelect_" . $rowGoals['id'] . "\" onChange='goalUpdatePlayerId(" . $rowGoals['id'] . ");'><option disabled>Seleccionar jugador</option>";
      $out .="<optgroup label=\"Gols\">";
      foreach ($playersVisitorArray as $p) {
      if ($rowGoals['idPlayer'] == $p[0]) {
      $selected = " selected";
      } else {
      $selected = "";
      }
      $out .="<option value=\"" . $p[0] . "\" $selected>" . $p[1] . "</option>";
      }
      $out .="</optgroup>";
      $out .="<optgroup label=\"Propia porta\">";
      foreach ($playersLocalArray as $p) {
      if ($rowGoals['idPlayer'] == $p[0]) {
      $selected = " selected";
      } else {
      $selected = "";
      }
      $out .="<option value=\"" . $p[0] . "\" $selected>" . $p[1] . " (pp)</option>";
      }
      $out .="</optgroup>";
      $out .="</select> <input type='text' class='minuteInput' id='goalMinuteInput_" . $rowGoals['id'] . "' onChange='goalUpdateMinute(" . $rowGoals['id'] . ");' value='" . $rowGoals['minute'] . "'> <span id=\"goalUpdateSuccess_" . $rowGoals['id'] . "\"></span></div>";
      }
      $out .="</div>";
      $out .="<div style='clear:both;'></div>";
      $out .="</div>";
      $out .="</div>";
      $out .="<div class='contentBoxSpacer'></div>"; */


// COMENTARI DEL PARTIT

    $out .="<div class='contentBox'>";
    $out .="<div class='contentBoxHeader'><h2>Comentari del partit</h2></div>";
    $out .="<div class='contentBoxContent'>";
    $out .="<textarea id=\"matchCommentTextArea\">" . $row['comment'] . "</textarea><input type='button' onClick='matchCommentUpdate(" . $_GET['idMatch'] . ");' value='Enviar' />";
    $out .="</div>";
    $out .="</div>";
} else {
    $out .="<div class='contentBoxSpacer'></div>";
    $out .="<div class='contentBox'>";
    $out .="<div class='contentBoxHeader'><h2>Estat del partit</h2></div>";
    $out .="<div class='contentBoxContent'>";

    $resStatus = mysql_query("Select id,status,color from  matchstatus") or die(mysql_error());

    while ($rowStatus = mysql_fetch_array($resStatus)) {
        $out .="<div onclick=\"matchStatusChange(" . $_GET['idMatch'] . "," . $rowStatus['id'] . ");\" style='width:15%; padding:6px; float:left; cursor:pointer;'><div style='width:10px; height:10px; background-color:#" . $rowStatus['color'] . "; float:left; margin-right:5px; '></div> " . $rowStatus['status'] . "</div>";
    }
    $out .="<div style='clear:both;'></div></div></div>";
// COMENTARI DEL PARTIT
    $out .="<div class='contentBoxSpacer'></div>";
    $out .="<div class='contentBox'>";
    $out .="<div class='contentBoxHeader'><h2>Comentari del partit</h2></div>";
    $out .="<div class='contentBoxContent'>";
    $out .="<textarea id=\"matchCommentTextArea\">" . $row['comment'] . "</textarea>";
    $out .="</div>";
    $out .="</div>";
}
 $out .="<div class='contentBoxSpacer'></div>";
    $out .="<div class='contentBox'>";
    $out .="<div class='contentBoxHeader'><h2>Codis del partit</h2></div>";
 $out .="<div class='contentBoxContent'>";
 $out .="<strong>Codi partit:</strong> ".$_GET['idMatch']."<br />";
 $out .="<strong>Codi ".$row['local'].":</strong>".$row['localId']."<br />";
  $out .="<strong>Codi ".$row['visitor'].":</strong>".$row['visitorId']."<br />";
 $out .="</div>";

$out .="<div class='contentBoxSpacer'></div>";
$out .="<div><span class='pointer' onClick='roundsShowInfo(" . $row['roundId'] . ")'><img src='images/control-rewind.gif'></span></div>";



echo utf8_encode($out);
mysql_close($idcnx);
?>
