<?php

include("../../Classes/db.inc");
include("../../Classes/Clubs_Class.php");

$clubs = new Clubs();
$clubs->idPlayer = $_GET['idPlayer'];
$data = $clubs->clubsGetRatesByPlayer();

$clubs -> clubsTransferPlayer($_GET['idPlayer'], $_GET['idTeam'], $_GET['rate']);
?>
