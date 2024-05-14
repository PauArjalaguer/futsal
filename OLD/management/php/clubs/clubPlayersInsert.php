<?php
include("../../Classes/db.inc");
include("../../Classes/Clubs_Class.php");
$clubs = new Clubs();
$clubs->playerName = $_POST['playerName'];
$clubs->idTeam= $_POST['idTeam'];
$data=$clubs->clubPlayersInsert();
echo $data;
?>
