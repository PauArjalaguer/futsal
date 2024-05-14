<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();


//$sql = "insert into player_bans_round (idPlayer,idRound,rounds,money,comment) values (".$_GET['idPlayer'].",".$_GET['idRound'].",".$_GET['numberofrounds'].",".$_GET['money'].",'".$_GET['comment']."')";

$sql ="update player_bans_round set idPlayer=".$_GET['idPlayer'].", rounds=".$_GET['numberofrounds'].", money=".$_GET['money'].",comment='".$_GET['comment']."' where id=".$_GET['id'];

$resP = mysql_query($sql) or die(mysql_error());

?>