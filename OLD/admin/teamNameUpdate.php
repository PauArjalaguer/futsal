<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$pass = substr(md5(uniqid(rand())), 0, 7);

$sql = "update teams set name='" . utf8_decode($_POST['name']) . "' where id=" . $_POST['id'] ;
$res = mysql_query($sql) or die(mysql_error());


?>
