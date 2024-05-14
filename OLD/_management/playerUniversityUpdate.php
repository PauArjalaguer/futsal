<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx=conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];

$sql="update player_team_season set idUniversity='".$_GET['playerUniversity']."'  where id=".$_GET['idCard'];
echo $sql."\n<br />";
mysql_query($sql) or die(mysql_error());
mysql_close($idcnx);

?>
