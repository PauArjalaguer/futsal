<?php
print_r($_POST);
include("../../Classes/db.inc");
include("../../Classes/Clubs_Class.php");
$clubs = new Clubs();
$clubs->complexName=utf8_decode(addslashes($_POST['complexName']));
$clubs->complexAddress = utf8_decode(addslashes($_POST['complexAddress']));
$clubs->idClub = $_COOKIE['idClub'];
$data=$clubs->clubComplexInsert();
?>
