<?php

include ("includes/config.php");
include ("includes/funciones.php");
conectar();

$res = mysql_query("Select name, initialDate, endDate from rounds where idLeague=" . $_GET['copyFrom']);
while($row=  mysql_fetch_array($res)){

    $sql="Update rounds set ";
    $sql .="initialDate='".$row['initialDate']."', ";
    $sql .="endDate='".$row['endDate']."' ";
    $sql .="where idLeague=".$_GET['copyTo'];
    $sql .=" and name=".$row['name'];
echo $sql."<br />";
mysql_query($sql) or die(mysql_error());
}
?>
