<?php

include("../../Classes/db.inc");
include("../../Classes/Clubs_Class.php");

$clubs = new Clubs();
$clubs->idClub = utf8_decode($_POST['idClub']);
$clubs->clubName = utf8_decode($_POST['clubName']);
$clubs->clubAddress = $_POST['clubAddress'];

$clubs->clubPhone1 = $_POST['clubPhone1'];
$clubs->clubPhone2 = $_POST['clubPhone2'];

$clubs->clubText = $_POST['clubText'];
$clubs->clubImage = $_POST['clubImage'];

$clubs->clubFacebook = $_POST['clubFacebook'];
$clubs->clubTwitter = $_POST['clubTwitter'];
$clubs->clubWeb = $_POST['clubWeb'];

$clubs->clubCity = $_POST['clubCity'];
$clubs->clubEmail = $_POST['clubEmail'];
$clubs->clubCode = $_POST['clubCode'];

//SI NO HI HA ID, ES NOTICIA NOVA
if ($_POST['idClub'] == 0) {
     $data=$clubs->clubsSaveInsert();
} else {
   $data= $clubs->clubsSaveUpdate();
   
}
echo $data;
?>
