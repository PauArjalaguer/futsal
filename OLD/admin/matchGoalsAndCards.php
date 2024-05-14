<?php

if ($_GET['ajax']) {
    include ("../includes/config.php");
    include ("../includes/funciones.php");
    conectar();
    $localId = $_GET['localId'];
    $visitorId = $_GET['visitorId'];
} else {
    $localId = $row['localId'];
    $visitorId = $row['visitorId'];
}
$out .="<div style='width:50%; float:left;'>";
$out .="<h2>" . $row['local'] . "</h2>";
$out .="<table class='playersTable' cellspacing=0>";
$out .="<tr><th>Jugador</th><th width=10>Gols</th><th width=10>PP</th><th width=10 align=center><div style='background-color:#ffcc00; width:15px; height:20px;' >&nbsp;</div></th><th width=10 align=center><div style='background-color:#2d59a2; width:15px; height:20px;'>&nbsp;</div></th></tr>";
$sql1 = "select
    p.id
    ,p.name
    ,pcm.yellowCards
    ,pcm.blueCards
    ,pgm.number
    ,pgm.own
    ,m.idround
    from players p
      
    left join player_card_match pcm on p.id=pcm.idplayer and pcm.idmatch=" . $_GET['idMatch'] . "
    left join player_goals_match pgm on p.id=pgm.idplayer and pgm.idmatch=" . $_GET['idMatch'] . "
    inner join matches_players mp on mp.idmatch=" . $_GET['idMatch'] . "
        join matches m on m.id=mp.idmatch
    and mp.idplayer=p.id
    and mp.idTeam=" . $localId;
//echo $sql1;
$resPlayersL = mysql_query($sql1) or die(mysql_error());

//echo $sql1;
$n = 2;
while ($rowPlayersL = mysql_fetch_array($resPlayersL)) {
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    if (!$rowPlayersL['yellowCards']) {
        $rowPlayersL['yellowCards'] = 0;
    }
    if (!$rowPlayersL['blueCards']) {
        $rowPlayersL['blueCards'] = 0;
    }
    if (!$rowPlayersL['number']) {
        $rowPlayersL['number'] = 0;
    }
    if (!$rowPlayersL['own']) {
        $rowPlayersL['own'] = 0;
    }

    $idRound = $rowPlayersL['idround'];

    $out .="<tr>";
    $out .="<td class=\"zebra$n\">" . $rowPlayersL['name'] . " " . $rowPlayersL['id'] . "</td>";
    $out .="<td class=\"zebra$n\"><input class=\"cardInput\" id='goalInput_" . $rowPlayersL['id'] . "' type='text' value='" . $rowPlayersL['number'] . "' onChange='goalsUpdateByPlayerIdAndMatchId(" . $rowPlayersL['id'] . "," . $_GET['idMatch'] . ");' /></td>";
    $out .="<td class=\"zebra$n\"><input class=\"cardInput\" id='ownGoalInput_" . $rowPlayersL['id'] . "' type='text' value='" . $rowPlayersL['own'] . "' onChange='goalsUpdateByPlayerIdAndMatchId(" . $rowPlayersL['id'] . "," . $_GET['idMatch'] . ");' /></td>";

    $out .="<td class=\"zebra$n\"><input class=\"cardInput\" id='matchYellowCardsInput_" . $rowPlayersL['id'] . "' type='text' value='" . $rowPlayersL['yellowCards'] . "' onChange='matchCardsUpdate(" . $rowPlayersL['id'] . "," . $_GET['idMatch'] . ",$idRound);' /></td>";
    $out .="<td class=\"zebra$n\"><input class=\"cardInput\" id='matchBlueCardsInput_" . $rowPlayersL['id'] . "' type='text' value='" . $rowPlayersL['blueCards'] . "' onChange='matchBlueCardsUpdate(" . $rowPlayersL['id'] . "," . $_GET['idMatch'] . ",$idRound);'></td>";
    $out .="</tr>";
}
$out .="</table>";
$out .="</div>";
$out .="<div style='width:50%; float:left;'>";
$out .="<h2>" . $row['visitor'] . "</h2>";
$out .="<table class='playersTable' cellspacing=0>";
$out .="<tr><th>Jugador</th><th width=10>Gols</th><th width=10>PP</th><th width=10 align=center><div style='background-color:#ffcc00; width:15px; height:20px;' >&nbsp;</div></th><th width=10 align=center><div style='background-color:#2d59a2; width:15px; height:20px;'>&nbsp;</div></th></tr>";

$sql2 = "select
    p.id
    ,p.name
    ,pcm.yellowCards
    ,pcm.blueCards
    ,pgm.number
    ,pgm.own
     ,m.idround
    from players p

    left join player_card_match pcm on p.id=pcm.idplayer and pcm.idmatch=" . $_GET['idMatch'] . "
    left join player_goals_match pgm on p.id=pgm.idplayer and pgm.idmatch=" . $_GET['idMatch'] . "
    inner join matches_players mp on mp.idmatch=" . $_GET['idMatch'] . "
         join matches m on m.id=mp.idmatch
    and mp.idplayer=p.id
    and mp.idTeam=" . $visitorId;
$resPlayersV = mysql_query($sql2) or die(mysql_error());
$n = 2;
while ($rowPlayersV = mysql_fetch_array($resPlayersV)) {
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    if (!$rowPlayersV['yellowCards']) {
        $rowPlayersV['yellowCards'] = 0;
    }
    if (!$rowPlayersV['blueCards']) {
        $rowPlayersV['blueCards'] = 0;
    }
    if (!$rowPlayersV['number']) {
        $rowPlayersV['number'] = 0;
    }
    if (!$rowPlayersV['own']) {
        $rowPlayersV['own'] = 0;
    }
    $idRound = $rowPlayersV['idround'];
    $out .="<tr>";
    $out .="<td class=\"zebra$n\">" . $rowPlayersV['name'] . " " . $rowPlayersV['id'] . "</td>";
    $out .="<td class=\"zebra$n\"><input class=\"cardInput\" id='goalInput_" . $rowPlayersV['id'] . "' type='text' value='" . $rowPlayersV['number'] . "' onChange='goalsUpdateByPlayerIdAndMatchId(" . $rowPlayersV['id'] . "," . $_GET['idMatch'] . ");' /></td>";
    $out .="<td class=\"zebra$n\"><input class=\"cardInput\" id='ownGoalInput_" . $rowPlayersV['id'] . "' type='text' value='" . $rowPlayersV['own'] . "' onChange='goalsUpdateByPlayerIdAndMatchId(" . $rowPlayersV['id'] . "," . $_GET['idMatch'] . ");' /></td>";


    $out .="<td class=\"zebra$n\"><input class=\"cardInput\" id='matchYellowCardsInput_" . $rowPlayersV['id'] . "' type='text' value='" . $rowPlayersV['yellowCards'] . "' onChange='matchCardsUpdate(" . $rowPlayersV['id'] . "," . $_GET['idMatch'] . ",$idRound);' /></td>";
    $out .="<td class=\"zebra$n\"><input class=\"cardInput\" id='matchBlueCardsInput_" . $rowPlayersV['id'] . "' type='text' value='" . $rowPlayersV['blueCards'] . "' onChange='matchBlueCardsUpdate(" . $rowPlayersV['id'] . "," . $_GET['idMatch'] . ",$idRound);'></td>";
    $out .="</tr>";
}
$out .="</table>";
$out .="</div>";
$out .="<div style='clear:both;'></div></div>";
if ($_GET['ajax']) {
    echo utf8_encode($out);
}
?>
