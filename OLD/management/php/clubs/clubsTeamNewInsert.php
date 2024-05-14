<?php

include("../../Classes/db.inc");
include("../../Classes/Clubs_Class.php");

print_r($_POST);
$clubs = new Clubs();
$clubs->idClub = $_POST['idClub'];
$clubs->clubTeamName = utf8_decode($_POST['clubTeamName']);
$data = $clubs->clubsTeamNewInsert();

echo $data;
?>
