<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

$sql = "select *from rounds where idleague=" . $_GET['idleague'];
$res = mysql_query($sql) or die(mysql_error());
$rounds = mysql_num_rows($res);

$halfSeason = $rounds / 2;

$sql = "select idlocal, idvisitor, t.name as local, t2.name as visitor, r.id as round, r.name as roundName
  from matches m
    join rounds r on r.id=m.idround
    join teams t on t.id=m.idlocal
    join teams t2 on t2.id=m.idvisitor
where idleague=" . $_GET['idleague'];
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($res)) {
echo $row['roundName']." ".$row['local']."-".$row['visitor']."<br />";
$suma=$row['round']+$halfSeason;
echo $suma." ".$row['visitor']."-".$row['local']."<hr />";
$sql2="INSERT INTO matches (idround,idlocal,idvisitor) values ($suma,".$row['idvisitor'].",".$row['idlocal'].")";
echo $sql2;
mysql_query($sql2) or die(mysql_error());
}
?>
