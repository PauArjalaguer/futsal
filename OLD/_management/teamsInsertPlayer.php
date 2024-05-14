<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx=conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];


$r = mysql_query("insert into players (name) values ('".ucwords($_GET['playerName'])."')") or die(mysql_error());
$lastInserted=mysql_insert_id();

$r2=mysql_query("insert into player_team_season (idplayer, idteam, idseason,inserteddate,updateddate) values (LAST_INSERT_ID(),".$_GET['idTeam'].",$lastSeasonId,now(),now())") or die(mysql_error());
echo $lastInserted;
mysql_close($idcnx);

?>
