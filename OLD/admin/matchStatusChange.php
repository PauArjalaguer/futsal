<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>

<?

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

$sql = "update matches set statusId=".$_GET['idStatus']." where id=" . $_GET['idMatch'];
echo $sql;

$res = mysql_query($sql) or die(mysql_error());
?>
