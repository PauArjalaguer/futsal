<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

$sql = "Update clubs set ";
$sql .="Address='" . $_GET['clubAddress'];
$sql .="', City='" . $_GET['clubCity'];
$sql .="', Email='" . $_GET['clubEmail'];
$sql .="', Phone1='" . $_GET['clubPhone1'];
$sql .="', Phone2='" . $_GET['clubPhone2'];
$sql .="', Web='" . $_GET['clubWeb'];
$sql .="', Facebook='" . $_GET['clubFacebook'];
$sql .="', Twitter='" . $_GET['clubTwitter'];
$sql .="', Description='" . $_GET['clubHistory'];
$sql .="' where id=" . $_GET['idClub'];

echo $sql;
mysql_query($sql) or die(mysql_error());
?>