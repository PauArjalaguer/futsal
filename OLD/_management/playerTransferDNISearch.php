<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

$lastSeason=lastSeason();
$lastSeasonId=$lastSeason[0];
$lastSeasonName=$lastSeason[1];
if(!empty($_GET['dni'])){
$sql = "select  id, name from players where dni='".$_GET['dni']."'";
}else{
    $sql = "select  id, name from players where dni='123123123'";
}
//echo $sql . "<br />";
$res = mysql_query($sql) or die(mysql_error());

while ($row = mysql_fetch_array($res)) {
   
    $out .= "<div  class='div' style='cursor:pointer;'><div  onClick='playersInsertIntoPlayerTeamSeason(".$row['id'].",".$_GET['idTeam'].");' style='width:90%; float:left;' >".$row['name']." ".$name;
   
    $out .="</div><div style='width:10%; float:left; text-align:right;'  ><img src='images/up.png'   valign=bottom></div><div style='clear:both;'></div></div>";
}

echo utf8_encode($out);
mysql_close();
?>
