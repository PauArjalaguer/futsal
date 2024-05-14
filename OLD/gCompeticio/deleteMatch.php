<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

$sql="select idLocal, idVisitor from matches where id=".$_GET['idMatch'];
$res=mysql_query($sql);
$row=mysql_fetch_array($res);
$s=$sql;
$sql = "SELECT name from rounds where idLeague=" . $_GET['idLeague'] . " order by id desc limit 0,1";
$res = mysql_query($sql);
$r = mysql_fetch_array($res);
$s .="\n".$sql;
//meitat de lliga
$halfSeason = $r['name'] / 2;
$tornada = $r2['name'] + $halfSeason;

$sql = "delete from matches  where id=" . $_GET['idMatch'];
$res = mysql_query($sql);
$s .="\n".$sql;

$sql = "delete from matches  where idLocal=".$row['idVisitor']." and idVisitor=".$row['idLocal']." and idRound=$tornada";
$res = mysql_query($sql);

$s .="\n".$sql;


echo $sql;
?>
