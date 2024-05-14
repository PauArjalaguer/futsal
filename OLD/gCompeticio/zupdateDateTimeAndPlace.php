<?php

$d = explode("-", $_GET['date']);
$date = $d[2] . "-" . $d[1] . "-" . $d[0];

$hour = $_GET['time'];

include ("../includes/config.php");
include ("../includes/funciones.php");
if($date=="--"){
    $date="";
}
if($hour==":"){
    $hour="00:00";
}
conectar();
$sql = "update matches set datetime='$date $hour', place=" . $_GET['complex'] . " where id=" . $_GET['idMatch'];
$res = mysql_query($sql);

echo $sql;
?>
