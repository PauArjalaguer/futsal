<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx=conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];

if($_GET['playerBirthDate']){
    $b=explode("-",$_GET['playerBirthDate']);
    $birthdate=$b[2]."-".$b[1]."-".$b[0];
   
}
$sql="Update players set name='".$_GET['playerName']."', birthdate='$birthdate', DNI='".$_GET['playerDNI']."', NIF='".$_GET['playerNIF']."',Address='".$_GET['playerAddress']."', AddressNumber='".$_GET['playerAddressNumber']."', Floor='".$_GET['playerAddressFloor']."',";
$sql .=" Door='".$_GET['playerAddressDoor']."', City='".$_GET['playerAddressCity']."', CP='".$_GET['playerCP']."', Province='".$_GET['playerAddressProvince']."', Nationality='".$_GET['playerNationality']."', CountryOfBirth='".$_GET['playerCountryOfBirth']."', ";
$sql .=" ProvinceOfBirth='".$_GET['playerProvinceOfBirth']."', Email='".$_GET['playerEmail']."', Notes='".$_GET['playerNotes']."'  where id=".$_GET['idPlayer'];

mysql_query($sql) or die(mysql_error());

$sql="Update player_team_season set updateddate=now(), isRejected=0  where idPlayer=".$_GET['idPlayer']." and idSeason=$lastSeasonId";
mysql_query($sql) or die(mysql_error());
echo $sql."\n<br />";
mysql_close($idcnx);
?>
