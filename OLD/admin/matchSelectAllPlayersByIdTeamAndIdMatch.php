<?php
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];
$sql="insert into matches_players 
select ".$_GET['idMatch'].",idplayer,".$_GET['idTeamMatch']." from player_team_season where idteam=".$_GET['idTeam']." and idseason=$lastSeasonId and ispayed=1";
echo $sql;
mysql_query($sql) or die(mysql_error());
//$lastId=  mysql_insert_id();

?>
