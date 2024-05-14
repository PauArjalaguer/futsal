<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

$res = mysql_query("UPDATE matches set ".$_GET['position']."=".$_GET['idTeam']." where id=" . $_GET['idMatch']) or die(mysql_error());

?>