<?php
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();


mysql_query("delete from  usersAccounts where id=".$_GET['idUserAccount']) or die(mysql_error());
$lastId=  mysql_insert_id();

?>
