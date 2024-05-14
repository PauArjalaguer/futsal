<?php

session_start();
include ("includes/config.php");
include ("includes/funciones.php");
conectar();
$sql1 = "DELETE from  tmpSeleccionadorDivisions where idDivision=" . $_GET['idDivision'] . " and sessionId='" . session_id() . "'";
//echo $sql1;
mysql_query($sql1) or die(mysql_error());
 $sql2="select distinct idDivision, d.name from tmpSeleccionadorDivisions tst join divisions d on d.id=tst.iddivision where sessionId='" . session_id() . "'";
$res = mysql_query($sql2);
while ($row = mysql_fetch_array($res)) {
  $out .= " <div class=\"button\">
	<h3>".$row['name']."</h3>
	<p onClick='seleccionadorDeleteDivision(".$row['idDivision'].");'>Eliminar</p>
</div>";
}
echo utf8_encode($out);
?>
