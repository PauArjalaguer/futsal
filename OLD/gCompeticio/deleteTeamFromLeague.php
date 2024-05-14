<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];

$sql="Delete from teams_leagues_per_season where idTeam=".$_GET['idTeam']." and idSeason=".$lastSeasonId;
$res=mysql_query($sql);

$s=$sql;
$sql = "Delete from teams_divisions_per_season where idTeam=" . $_GET['idTeam'] ." and idSeason=".$lastSeasonId;
$res = mysql_query($sql);

$s .="\n".$sql;

$sql = "Delete from matches  where (idLocal=" . $_GET['idTeam']." or idVisitor=".$_GET['idTeam'].") and idRound in (Select id from rounds where idSeason=$lastSeasonId)";
//$res = mysql_query($sql);

$s .="\n".$sql;
echo $s;
$sql="delete from classification where idleague=$l";
/// echo "<br />$sql";
mysql_query($sql);


$sql="insert into classification (idTeam,idLeague,playedMatches,wonMatches,drawMatches,lostMatches,goalsMade,goalsReceived)
select id, $l,0,0,0,0,0,0 from teams where id in(
select idLocal from matches m
join rounds r on r.id=m.idround
where idLeague=$l)";
// echo "<br />$sql";
mysql_query($sql);

?>
