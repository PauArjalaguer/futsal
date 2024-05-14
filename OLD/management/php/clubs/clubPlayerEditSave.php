<?php
include("../../Classes/db.inc");
include("../../Classes/Clubs_Class.php");
$clubs = new Clubs();
$clubs->idPlayer=$_POST['idPlayer'];
$clubs->playerName = $_POST['playerName'];
$clubs->playerCategory= $_POST['playerCategory'];
$clubs->playerSurname = $_POST['playerSurname'];
$clubs->playerBirthDate= $_POST['playerBirthDate'];
$clubs->playerBirthCountry = $_POST['playerBirthCountry'];
$clubs->playerBirthProvince= $_POST['playerBirthProvince'];
$clubs->playerDNI = $_POST['playerDNI'];
$clubs->playerNIF= $_POST['playerNIF'];
$clubs->playerStreet = $_POST['playerStreet'];
$clubs->playerStreetNumber= $_POST['playerStreetNumber'];
$clubs->playerFloor = $_POST['playerFloor'];
$clubs->playerDoor= $_POST['playerDoor'];
$clubs->playerCP = $_POST['playerCP'];
$clubs->playerCity= $_POST['playerCity'];
$clubs->playerProvince = $_POST['playerProvince'];
$clubs->playerNotes= $_POST['playerNotes'];
$data=$clubs->clubPlayerEditSave();
echo $data;
?>
