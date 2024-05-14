<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
//echo $_GET['idTeam']."\"";
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar ();
$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];
$clubCashingBalance = clubCashingBalance($_GET['idClub'], 3);
//saber preu de la pilota aquesta temporada
if ($_GET['rate'] != $_GET['originalRate']) {
    $total = $_GET['rate'];
} else {
    $total = $_GET['originalRate'];
}
// echo "TOTAL".$total. "Club:".$clubCashingBalance;
if ($total > $clubCashingBalance) {
    echo "El saldo de drets de competició del club és de ".utf8_encode($clubCashingBalance);
} else {
    $sql1="INSERT INTO admTeamEntries (idTeam, datetime, idSeason) values (" . $_GET['idTeam'] . ",now(),$lastSeasonId)";
    //echo $sql1;
    mysql_query($sql1) or die(mysql_error());
    

    if ($_GET['rate'] != $_GET['originalRate']) {
        mysql_query("INSERT INTO admrate_division_season_per_teams_exceptions (idTeam,rate, reason, datetime, idSeason) values (" . $_GET['idTeam'] . "," . $_GET['rate'] . ",'" . $_GET['reason'] . "',now(),$lastSeasonId)") or die(mysql_error());
    }
}
?>