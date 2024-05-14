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
$sql = "update matches set datetime='$date $hour', updateddatetime='$date $hour', place=" . $_GET['complex'] . " where id=" . $_GET['idMatch'];
$res = mysql_query($sql);


$sql = "delete from calendar where idmatch is not null";
$res = mysql_query($sql);


$sql="insert into calendar (name,description,datetime, lloc,idMatch, idComplex)
select
     concat(t1.name,' - ',t2.name) as name

     ,concat(' Partit entre ',t1.name,' i ', t2.name ,' de ',r.name, ' de ',l.name) as description
     ,datetime
     ,null
     , m.id
     ,c.id
from matches m join rounds r on m.idround=r.id join teams t1 on t1.id=m.idLocal join teams t2 on t2.id=m.idvisitor join complex c on m.place=c.id join leagues l on r.idLeague=l.id  where datetime is not null and idleague in (24,25,26,27,28,29,30,31,32) order by datetime ";
$res = mysql_query($sql) or die(mysql_error());


echo $sql;
?>
