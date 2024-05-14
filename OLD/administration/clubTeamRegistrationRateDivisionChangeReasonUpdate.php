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

mysql_query("UPDATE admrate_division_season_per_teams_exceptions set reason='".$_POST['reason']."' where idteam=".$_POST['idTeam']." and idSeason=$lastSeasonId") or die(mysql_error());

?>