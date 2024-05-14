<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx=conectar();

$sql = "Update clubs set ";
$sql .="Address='" . utf8_decode($_POST['clubAddress']);
$sql .="', City='" . utf8_decode($_POST['clubCity']);
$sql .="', Email='" . utf8_decode($_POST['clubEmail']);
$sql .="', Phone1='" . utf8_decode($_POST['clubPhone1']);
$sql .="', Phone2='" . utf8_decode($_POST['clubPhone2']);
$sql .="', Web='" . utf8_decode($_POST['clubWeb']);
$sql .="', Facebook='" . utf8_decode($_POST['clubFacebook']);
$sql .="', Twitter='" . utf8_decode($_POST['clubTwitter']);
$sql .="', Description='" . utf8_decode($_POST['clubHistory']);
$sql .="' where id=" . $_POST['idClub'];

echo $sql;
mysql_query($sql) or die(mysql_error());

$res=mysql_query("Select * from club_billing_info where idclub=".$_POST['idClub']);
if(mysql_num_rows($res)>0){

    $sqlUpdate="Update club_billing_info set name='".utf8_decode($_POST['billingName'])."' , nif='".utf8_decode($_POST['billingNif'])."', address='".utf8_decode($_POST['billingAddress'])."', city='".utf8_decode($_POST['billingCity'])."' where idclub=".$_POST['idClub'];
echo $sqlUpdate;
mysql_query($sqlUpdate);

}else{
     $sqlInsert="INSERT INTO club_billing_info (idclub,name, nif, address, city) values (".$_POST['idClub'].",'".utf8_decode($_POST['billingName'])."' ,'".utf8_decode($_POST['billingNif'])."','".utf8_decode($_POST['billingAddress'])."', '".utf8_decode($_POST['billingCity'])."')";
echo $sqlInsert;
mysql_query($sqlInsert);
}
mysql_close($idcnx);
?>