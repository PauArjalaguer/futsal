<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$sql = "INSERT INTO rfrReferees (name) values ('".$_GET['name']."')";
$res = mysql_query($sql) or die(mysql_error());
$lastInserted=mysql_insert_id();
echo $lastInserted;
?>
