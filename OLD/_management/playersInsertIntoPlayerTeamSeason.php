<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx=conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];


$r = mysql_query("Select id from player_team_season where idPlayer=" . $_GET['idPlayer'] . " and idSeason=$lastSeasonId");
if (mysql_num_rows($r) == 0) {
    $sql = "INSERT INTO player_team_season (idPlayer, idTeam, idSeason, insertedDate, updatedDate) values (" . $_GET['idPlayer'] . "," . $_GET['idTeam'] . ",$lastSeasonId,now(),now())";
    $res = mysql_query($sql) or die(mysql_error());
}else{
    echo utf8_encode("Jugador ja introduït");
}
mysql_close($idcnx);

?>
