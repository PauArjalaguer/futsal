<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();


$sql = "update cmptMatch_Referee set idRefereeType=" . $_GET['idRefereeType'] . " where id=" . $_GET['idCmr'];

echo $sql;
$res = mysql_query($sql) or die(mysql_error());

//mysql_query("DELETE FROM cmptMatch_Referee where idMatch=" . $row['idMatch'] . " and idReferee=" . $row['idReferee'] . " and id!=" . $_GET['idCmr']);
?>
