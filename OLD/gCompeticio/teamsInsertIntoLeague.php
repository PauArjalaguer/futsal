<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$idTeam = $_GET['idTeam'];
$l = $_GET['l'];
$s = $_GET['s'];
$d = $_GET['d'];

mysql_query("insert into teams_leagues_per_season (idTeam,idLeague,idSeason)
values
($idTeam,$l,$s)");
$sql2 = "SELECT * from teams_divisions_per_season where idteam=" . $idTeam . " and idDivision=" . $d . " and idSeason=" . $s;
//echo $sql2 . "<br />";
$res2 = mysql_query($sql2);
if (mysql_num_rows($res2) == 0) {
    $sql3 = "INSERT INTO teams_divisions_per_season (idTeam, idDivision, idSeason) values (" . $idTeam . "," . $d . "," . $s . ")";
    mysql_query($sql3);
    //echo $sql3 . "<br />";
}
$sql="delete from classification where idleague=$l";
/// echo "<br />$sql";
mysql_query($sql);


$sql="insert into classification (idTeam,idLeague,playedMatches,wonMatches,drawMatches,lostMatches,goalsMade,goalsReceived)
select id, $l,0,0,0,0,0,0 from teams where id in(
select idLocal from matches m
join rounds r on r.id=m.idround
where idLeague=$l)";
//echo "<br />$sql";
mysql_query($sql);

 header("Location: index.php?l=$l&s=$s&d=$d");
?>
