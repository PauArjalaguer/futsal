<?php

session_start();
include ("includes/config.php");
include ("includes/funciones.php");
conectar();
$sql1 = "INSERT INTO tmpSeleccionadorAge (age,sessionId,datetime) values (" . $_GET['age'] . ",'" . session_id() . "',now())";
//echo $sql1;
mysql_query($sql1) or die(mysql_error());
 $sql2="select distinct age from tmpSeleccionadorAge tst where sessionId='" . session_id() . "'";
$res = mysql_query($sql2);
while ($row = mysql_fetch_array($res)) {
  $out .= " <div class=\"button\">
	<h3>".$row['age']."</h3>
	<p onClick='seleccionadorDeleteAge(".$row['age'].");'>Eliminar</p>
</div>";
}
echo utf8_encode($out);
?>
