<?php

session_start();
include ("includes/config.php");
include ("includes/funciones.php");
conectar();
$sql1 = "INSERT INTO tmpSeleccionadorCity (cityName,sessionId,datetime) values ('" . $_GET['idCity'] . "','" . session_id() . "',now())";
//echo $sql1;
mysql_query($sql1) or die(mysql_error());
 $sql2="select distinct cityName from tmpSeleccionadorCity tst where sessionId='" . session_id() . "'";
$res = mysql_query($sql2);
while ($row = mysql_fetch_array($res)) {
  $out .= " <div class=\"button\">
	<h3>".stripslashes($row['cityName'])."</h3>
	<p onClick='seleccionadorDeleteCity(\"".$row['cityName']."\");'>Eliminar</p>
</div>";
}
echo utf8_encode($out);
?>
