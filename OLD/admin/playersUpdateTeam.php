<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?><?

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
//print_r($_GET);
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];
$temporadaActual = $lastSeasonId;

$sql3 = "select pts.idPlayer, rds.rate as rate, adse.rate as exceptionRate, pts.idSeason from player_team_season pts
join `teams_divisions_per_season` tds on tds.`idTeam`=pts.idTeam and tds.idSeason=pts.idSeason
join rate_division_season rds on rds.iddivision=tds.`idDivision` and rds.idSeason=pts.`idseason`
left join admrate_division_season_exceptions adse on adse.idplayer=pts.idplayer and adse.idSeason=pts.idseason
where pts.idplayer=" . $_GET['idPlayer'] . " and pts.idSeason=" . $temporadaActual;
//echo $sql3."<br />";
$res3 = mysql_query($sql3) or die(mysql_error());

$row = mysql_fetch_array($res3);
//print_r($row);
if (empty($row['exceptionRate'])) {
    echo "Insertar excepció a admrate_division_season_exceptions";
    $sql4 = "Insert into admrate_division_season_exceptions values (null,'Traspàs jugador per acumulació de partits a equip inferior'," . $row['rate'] . "," . $row['idPlayer'] . "," . $row['idSeason'] . ",now())";
    //echo $sql4;
    $res4 = mysql_query($sql4) or die(mysql_error());
}
$sql = "update player_team_season set matchesPlayedWithAnotherTeam=0,idTeam=" . $_GET['idTeam'] . " where idPlayer=" . $_GET['idPlayer'] . " and idSeason=$temporadaActual";
//echo $sql;

$res = mysql_query($sql) or die(mysql_error());
echo $row['idPlayer'];
?>