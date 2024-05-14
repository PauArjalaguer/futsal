<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

$lastSeason=lastSeason();
$lastSeasonId=$lastSeason[0];
$lastSeasonName=$lastSeason[1];

//CREAR CADENA AMB ELS EQUIPS ON HA JUGAT, TANT EL PRINCIPAL COM ELS CEDITS.
$teamsString = $_GET['idTeam'];
$sql = "select idTeamTransferer from teams_cession_relation where idTeamTransfered=".$_GET['idTeam']. " ";
$res = mysql_query($sql) or die(mysql_error());
$numOfTeams = mysql_num_rows($res);
while ($row = mysql_fetch_array($res)) {
    $teamsString .="," . $row['idTeamTransferer'];
}

$sql = "select  distinct p.id,p.name, t.name as teamName from players p
join  player_team_season pts on pts.idplayer=p.id
join teams t on t.id=pts.idTeam
where idteam in ($teamsString)  and p.name like '%" . $_GET['search'] . "%' and idSeason !=$lastSeasonId  order by p.name asc limit 0,10";

//echo $sql . "<br />";
$res = mysql_query($sql) or die(mysql_error());

while ($row = mysql_fetch_array($res)) {
    $name=str_ireplace($_GET['search'],"<span style='background-color:#cc0;font-weight:bold;'>".$_GET['search']."</span>",$row['name']);

    $out .= "<div  class='div'><div onClick='playersInsertIntoPlayerTeamSeason(".$row['id'].",".$_GET['idTeam'].");' style='width:90%; float:left;' >".$row['iad']." ".$name;
    if ($numOfTeams > 1) {
        $out .=" (" . $row['teamName'] . ")";
    }
    $out .="</div><div style='width:10%; float:left; text-align:right;'  ><img src='images/up.png'   valign=bottom></div><div style='clear:both;'></div></div>";
}

echo utf8_encode($out);
?>
