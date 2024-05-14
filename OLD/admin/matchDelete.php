<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

 mysql_query("Delete from results  where idMatch=" . $_GET['idMatch']) or die(mysql_error());
mysql_query("update matches set statusId=1 where id=".$_GET['idMatch']) or die(mysql_error());

?>
