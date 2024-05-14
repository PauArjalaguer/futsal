<?php

include ("config.php");
include ("funciones.php");
conectar();
$sql = "select distinct idmatch from cmptMatch_Referee order by idmatch";

$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($res)) {$refereeString="";
    echo "<br />" . $row['idmatch'] . "<br />";
    $sql2 = " select name from cmptMatch_Referee cmr
join rfrReferees r on r.id=cmr.idReferee
where idMatch=" . $row['idmatch'];
    $res2 = mysql_query($sql2) or die(mysql_error());
    while ($row2 = mysql_fetch_array($res2)) {
      $refereeString .= $row2['name'] . ", ";
    }
    $sql3=" update matches set refereeString='" . addslashes($refereeString) . "'
where id=".$row['idmatch'];
    echo $sql3."<br />";
    mysql_query($sql3);
}