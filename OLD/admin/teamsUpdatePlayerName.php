<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$res = mysql_query("update  players set name='".$_GET['playerName']."' where id=" . $_GET['idPlayer']) or die(mysql_error());

?>
