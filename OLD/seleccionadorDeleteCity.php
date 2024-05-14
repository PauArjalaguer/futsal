<?php

session_start();
include ("includes/config.php");
include ("includes/funciones.php");
conectar();
$sql1 = "DELETE from  tmpSeleccionadorCity where cityName='" . $_GET['idCity'] . "' and sessionId='" . session_id() . "'";
//echo $sql1;
mysql_query($sql1) or die(mysql_error());
 $sql2="select distinct cityName  from tmpSeleccionadorCity where  sessionId='" . session_id() . "'";
$res = mysql_query($sql2);
while ($row = mysql_fetch_array($res)) {
  $out .= " <div class=\"button\">
	<h3>".$row['cityName']."</h3>
	<p onClick='seleccionadorDeleteCity(\"".$row['cityName']."\");'>Eliminar</p>
</div>";
}
echo utf8_encode($out);
?>
