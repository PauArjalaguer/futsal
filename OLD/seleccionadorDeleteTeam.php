<?php

session_start();
include ("includes/config.php");
include ("includes/funciones.php");
conectar();
$sql1 = "DELETE from  tmpSeleccionadorTeams where idTeam=" . $_GET['idTeam'] . " and sessionId='" . session_id() . "'";
//echo $sql1;
mysql_query($sql1) or die(mysql_error());
 $sql2="select distinct idteam, t.name from tmpSeleccionadorTeams tst join teams t on t.id=tst.idteam where sessionId='" . session_id() . "'";
$res = mysql_query($sql2);
while ($row = mysql_fetch_array($res)) {
  $out .= " <div class=\"button\">
	<h3>".$row['name']."</h3>
	<p onClick='seleccionadorDeleteTeam(".$row['idteam'].");'>Eliminar</p>
</div>";
}
echo utf8_encode($out);
?>
