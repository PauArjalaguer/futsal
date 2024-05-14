<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$res = mysql_query("delete from  players where id=" . $_GET['idPlayer']) or die(mysql_error());


$res = mysql_query("delete from  player_team_season where idplayer=" . $_GET['idPlayer']) or die(mysql_error());
?>
