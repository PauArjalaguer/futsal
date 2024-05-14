<?php

$d = explode("-", $_GET['date']);
$date = $d[2] . "-" . $d[1] . "-" . $d[0];

$hour = $_GET['time'];

include ("../includes/config.php");
include ("../includes/funciones.php");

$d = explode("-", $_GET['date']);
$date = $d[2] . "-" . $d[1] . "-" . $d[0];

conectar();
$sql = "update rounds set ".$_GET['field']."='$date' where id=" . $_GET['idRound'];

//echo $sql;
$res = mysql_query($sql) or die(mysql_error());
$sql = "update rounds set enddate=initialdate+1 where id=" . $_GET['idRound'];

//echo $sql;
$res = mysql_query($sql) or die(mysql_error());
$sql="select dayofweek(initialdate),initialdate as w from rounds where id=" . $_GET['idRound'];
$res = mysql_query($sql) or die(mysql_error());
$row=mysql_fetch_array($res);

echo strlen($row['playingComplex'])."---".$row['w'];

$sql="select * from teams where playingDay=7 and id in (select idlocal from matches where idround=".$_GET['idRound'].")";
echo $sql;
$res = mysql_query($sql) or die(mysql_error());
while($row=mysql_fetch_array($res)){
if(strlen($row['playingComplex'])<2){$row['playingComplex']=0;}
	echo "DISSABTE ".$row['name']."-".$row['playingDay']."-".$row['playingHour']."<br />";
	echo "DISSABTE update matches set place=".$row['playingComplex'].", datetime=\"".$date." ".$row['playingHour']."\", updateddatetime=\"".$date." ".$row['playingHour']."\" where idlocal=".$row['id']." and idround=".$_GET['idRound']."<br />";
	mysql_query("update matches set place=".$row['playingComplex'].", datetime=\"".$date." ".$row['playingHour']."\", updateddatetime=\"".$date." ".$row['playingHour']."\" where idlocal=".$row['id']." and idround=".$_GET['idRound']) or die(mysql_error());
}

$sql="select * from teams where playingDay=1 and id in (select idlocal from matches where idround=".$_GET['idRound'].")";
echo $sql;
$res = mysql_query($sql) or die(mysql_error());
while($row=mysql_fetch_array($res)){
if(strlen($row['playingComplex'])<2){$row['playingComplex']=0;}
	echo "DIUMENGE ".$row['name']."-".$row['playingDay']."-".$row['playingHour']."<br />";
	echo "DIUMENGE update matches set place=".$row['playingComplex'].",  datetime=\"$date ".$row['playingHour']."\", updateddatetime=\"".$date." ".$row['playingHour']."\" where idlocal=".$row['id']." and idround=".$_GET['idRound']."<br />";
	mysql_query("update matches set place=".$row['playingComplex'].",  datetime=\"$date ".$row['playingHour']."\", updateddatetime=\"".$date." ".$row['playingHour']."\" where idlocal=".$row['id']." and idround=".$_GET['idRound']) or die(mysql_error());
	mysql_query("update matches set datetime=date_add(datetime, INTERVAL 1 DAY), updateddatetime=date_add(updateddatetime, INTERVAL 1 DAY) where idlocal=".$row['id']." and idround=".$_GET['idRound']) or die(mysql_error());

}



?>
