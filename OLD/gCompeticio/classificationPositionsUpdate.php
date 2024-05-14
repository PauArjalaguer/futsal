<?php
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$sql="select count(*) from classificationPosition_item_league where idleague=".$_GET['idleague']." and position=".$_GET['position'];
echo $sql;
$res=  mysql_query($sql) or die(mysql_error());
$row=  mysql_fetch_row($res);


if ($row[0]==0) {
  $sql="insert into classificationPosition_item_league values (null,".$_GET['idleague'].",".$_GET['position'].",'".$_GET['name']."','".$_GET['class']."')";
          
} else {
   $sql="update classificationPosition_item_league set name='".$_GET['name']."', className='".$_GET['class']."' where idleague=".$_GET['idleague']." and position=".$_GET['position'];
   
}
echo "<br />".$sql;

$resPerm = mysql_query($sql) or die(mysql_error());

?>

