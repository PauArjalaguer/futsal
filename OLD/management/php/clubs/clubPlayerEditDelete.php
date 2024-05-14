<?php
include("../../Classes/db.inc");
include("../../Classes/Clubs_Class.php");
$clubs = new Clubs();
$clubs->idPlayer=$_POST['idPlayer'];

$data=$clubs->clubPlayerEditDelete();
echo $data;
?>
