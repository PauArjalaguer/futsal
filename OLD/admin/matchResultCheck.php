<?
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

mysql_query("update results set checked=1 where idMatch=" . $_GET['idMatch']) or die(mysql_error());
echo "1";
?>