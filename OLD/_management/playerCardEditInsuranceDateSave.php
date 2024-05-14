<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx=conectar();

$sql1 = "UPDATE player_insurance set expirationDate='" . $_GET['expirationDate'] . "' where id=" . $_GET['idInsurance'];
$res1 = mysql_query($sql1);

echo $sql1;
mysql_close($idcnx);
?>
