<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();



$sql = "update rfrReferees set isDeleted=1 where id=" . $_POST['idReferee'];

echo $sql;
$res = mysql_query($sql) or die(mysql_error());

$sql = "update usersAccounts set password='deleted' where idReferee=" . $_POST['idReferee'];

echo $sql;
$res = mysql_query($sql) or die(mysql_error());

?>
