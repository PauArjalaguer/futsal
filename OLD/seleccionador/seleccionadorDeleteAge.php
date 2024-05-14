<?php

session_start();
include ("includes/config.php");
include ("includes/funciones.php");
conectar();
$sql1 = "DELETE from  tmpSeleccionadorAge where age=" . $_GET['age'] . " and sessionId='" . session_id() . "'";
//echo $sql1;
mysql_query($sql1) or die(mysql_error());
 $sql2="select distinct age  from tmpSeleccionadorAge where  sessionId='" . session_id() . "'";
$res = mysql_query($sql2);
while ($row = mysql_fetch_array($res)) {
  $out .= " <div class=\"button\">
	<h3>".$row['age']."</h3>
	<p onClick='seleccionadorDeleteAge(".$row['age'].");'>Eliminar</p>
</div>";
}
echo utf8_encode($out);
?>
