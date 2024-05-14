<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>

<?

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
echo "update matches set comment='" . $_POST['comment'] . "' where  id=" . $_POST['idMatch'];
mysql_query("update matches set comment='" . $_POST['comment'] . "' where  id=" . $_POST['idMatch']) or die(mysql_error());

?>
