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

$sql="Select name from teams where id=".$_GET['idTeam'];
$res=mysql_query($sql);
$row=mysql_fetch_array($res);

$out .= "<div class='contentBox'>";

$out .= "<div class='contentBoxHeader'>";
$out .= "<div ><h2 onClick='clubTeamRegistrationRateDivisionChangeReason(".$_GET['idTeam'].",".$_GET['idClub'].")'>Canvi de preu de drets de competició de ".$row['name']."</h2></div>";

$out .= "</div>";
$out .= "<div class='contentBoxContent'>";
$out .="<textarea id=\"reason\" rows=10></textarea>";
$out .="<input type='button' value=\"Guardar\" onClick='clubTeamRegistrationRateDivisionChangeReasonUpdate(".$_GET['idTeam'].",".$_GET['idClub'].")' />";
$out .= "</div>";
$out .= "</div>";

echo utf8_encode($out);

?>