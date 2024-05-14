<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];

if($_GET['playerBirthDate']){
    $b=explode("-",$_GET['playerBirthDate']);
    $birthdate=$b[2]."-".$b[1]."-".$b[0];

}
$sql="insert into player_team_season (idplayer, idteam,idseason) values (".$_GET['idPlayer'].",".$_GET['idTeam'].",$lastSeasonId)";
echo $sql."\n<br />";
mysql_query($sql) or die(mysql_error());

mysql_query("Update player_team_season set position=".$_GET['playerPosition'].", number=".$_GET['playerNumber']." where id=".$_GET['idCard']) or die(mysql_error());


?>
