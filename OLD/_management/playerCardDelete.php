<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx=conectar();
$sql="delete from player_team_season where id=".$_GET['idCard'];
echo $sql;
mysql_query($sql) or die(mysql_error());
mysql_close($idcnx);

?>
