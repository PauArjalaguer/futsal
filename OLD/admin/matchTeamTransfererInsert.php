<?php
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

$sql="insert into teams_cession_relation (idTeamTransfered, idTeamTransferer) values (".$_GET['idTeam'].",".$_GET['idTeamT'].")";
echo $sql;
mysql_query($sql) or die(mysql_error());
$lastId=  mysql_insert_id();

?>
