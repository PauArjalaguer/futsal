<?php

include ("includes/config.php");
include ("includes/funciones.php");
conectar();

$sql = "Select m.id as matchid,initialdate, enddate, datetime, t1.name as Local, t2.name as Visitor,complexName,complexAddress, l.name as leagueName,r.name as roundName from matches m join rounds r on m.idround=r.id join teams t1 on t1.id=m.idLocal join teams t2 on t2.id=m.idvisitor join complex c on m.place=c.id join leagues l on r.idLeague=l.id order by m.id";
$res = mysql_query($sql);
$a = 1;
while ($row = mysql_fetch_array($res)) {
    $d = explode(" ", $row['datetime']);

    $n = count($d) - 1;
    $hour = str_replace("h", "", $d[$n]);
    //echo $row['Local']."-".$row['Visitor']." ".$row['initialdate']." ".$row['datetime']." $hour<br />";
    $name = $row['Local'] . " - " . $row['Visitor'];
    $description = "Partit entre " . $row['Local'] . " i " . $row['Visitor'] . " de la jornada " . $row['roundName'] . " de " . $row['leagueName'];

    if (substr_count($row['datetime'], "Diumenge") > 0) {

        $datetime = $row['enddate'] . " " . $hour;
        $d = "______";
    } else {
        $d = "";
        $datetime = $row['initialdate'] . " " . $hour;
    }
    $sql2="Insert into calendar (name, description,datetime,lloc) values ('" . addslashes($name) . "','" . addslashes($description) . "','" . $datetime . "','" . addslashes($row['complexAddress']) . "')";
    echo $sql2."<br />";
    mysql_query($sql2) or die(mysql_error());
    //echo $a ." ".$row['matchid']. " " . $name . " " . $description . "<br />";
    $a++;
}
?>
