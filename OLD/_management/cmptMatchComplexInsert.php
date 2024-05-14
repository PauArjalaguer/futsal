<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx = conectar();
$idMatch = intval($_POST['idMatch']);
$res=mysql_query("INSERT into complex (complexName, complexAddress) values ('".$_POST['complexName']."','".$_POST['complexAddress']."')");
$lastInserted=mysql_insert_id();
mysql_query("INSERT INTO clubs_complex (idClub, idComplex) values (".$_POST['idClub'].", $lastInserted)");
$sql="update matches set place=$lastInserted where id=".$_POST['idMatch'];
echo $sql;
mysql_query($sql) or die(mysql_error());
?>

