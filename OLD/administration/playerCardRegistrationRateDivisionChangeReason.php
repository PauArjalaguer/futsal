<?php

header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<?php

//echo $_GET['idTeam'];
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar ();
$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];

$sql="Select name from players where id=".$_GET['idPlayer'];
$res=mysql_query($sql);
$row=mysql_fetch_array($res);

$out .= "<div class='contentBox'>";

$out .= "<div class='contentBoxHeader'>";
$out .= "<div ><h2 onClick='playerCardRegistrationRateDivisionChangeReason(".$_GET['idPlayer'].",".$_GET['idTeam'].")'>Canvi de preu de mutualitat de ".$row['name']."</h2></div>";

$out .= "</div>";
$out .= "<div class='contentBoxContent'>";
$out .="<textarea id=\"reason\" rows=10></textarea>";
$out .="<input type='button' value=\"Guardar\" onClick='playerCardRegistrationRateDivisionChangeReasonUpdate(".$_GET['idPlayer'].",".$_GET['idTeam'].")' />";
$out .= "</div>";
$out .= "</div>";

echo utf8_encode($out);

?>