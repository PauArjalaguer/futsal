<?php

$date = date("y") . date("m") . date("d") . date("H") . date("i") . date("s");
//Header("Content-type: application/vnd.ms-word");
//Header("Content-Disposition: filename=file$date.doc");

$fp = fopen("amit.doc", "w");

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$out = "";
$date = $_GET['date'];
//$res = mysql_query("Select l.name from rounds r join leagues l on r.idleague=l.id join matches m on m.idround=r.id where initialdate='2010-10-23' or enddate='2010-10-23'") or die(mysql_error());
$sql = "select m.id as matchId, t2.name as localName, t3.name as visitorName,l.id as idLeague, l.name as leagueName, m.id as idMatch, p.name as playerName,yellowcards,bluecards, t1.id as idTeam,t1.name as teamName from player_card_match pcm ";
$sql .="join players p on p.id=pcm.idplayer ";
$sql .="join matches m on pcm.idmatch=m.id ";
$sql .="join rounds r on r.id=m.idround ";
$sql .="join player_team_season pts on pts.idplayer=pcm.idplayer and pts.idseason=r.idSeason ";
$sql .="join teams t1 on t1.id=pts.idteam ";
$sql .="join teams t2 on t2.id=m.idlocal ";
$sql .="join teams t3 on t3.id=m.idvisitor ";
$sql .="join leagues l on l.id=r.idleague ";
$sql .="where initialdate='2010-10-13' or enddate='2010-10-13' ";
$sql .="order by idchampionship, r.idleague, idround, idmatch, idTeam";
echo $sql . "<br /><br />";
$res = mysql_query($sql);
$idLeague = "";
$idMatch = "";
while ($row = mysql_fetch_array($res)) {

    if ($row['idLeague'] != $idLeague) {
        $out .= "<h1>" . $row['leagueName'] . "</h1>";
    }
    if ($row['idMatch'] != $idMatch) {
        $out .= "<h2>" . $row['localName'] . "-" . $row['visitorName'] . "</h2>";
    }
    if ($row['idTeam'] != $idTeam) {
        $out .= "<br />";
        $teamMoney = "";
    }
    $money = ($row['yellowcards'] * 15) + ($row['bluecards'] * 30);
    $teamMoney = $teamMoney + $money;
    $out .= "Sancionar al " . $row['teamName'] . " amb $money &euro;  per  per " . $row['yellowcards'] . " targetes grogues";
    if ($row['bluecards'] > 0) {
        $out .=" i " . $row['bluecards'] . " tarjetes blaves";
    }

    $out .=" de " . $row['playerName'] . ".<br />";
    $idLeague = $row['idLeague'];
    $idMatch = $row['idMatch'];
    $idTeam = $row['idTeam'];
}


echo $out;

//fwrite($fp, $out);

//fclose($fp);
?>
