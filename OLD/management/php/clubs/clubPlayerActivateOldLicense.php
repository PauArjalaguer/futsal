<?php
include("../../Classes/db.inc");
include("../../Classes/Clubs_Class.php");
$clubs = new Clubs();
$clubs->idPlayer = $_GET['idPlayer'];
$clubs->idTeam= $_GET['idTeam'];
$data=$clubs->clubPlayerActivateOldLicense();
//echo $data;
?>
