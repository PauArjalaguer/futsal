<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

if(strlen($_GET['date'])>1){
    $d=explode("-",$_GET['date']);
    $date=" '".$d[2]."-".$d[1]."-".$d[0]."' ";
}else{
    $date=" now() ";
}
$sql="INSERT INTO admClubPayments (amount,datetime,code,idClub,idPaymentType) values (".$_GET['amount'].",$date,'".$_GET['concept']."',".$_GET['idClub'].",".$_GET['paymentType'].")";

echo $sql;
mysql_query($sql);


$sql = "INSERT INTO  `admNotifications` (
`id` ,
`idClub` ,
`notificationDate`,
`notificationType`,
`notificationText`
)
VALUES (
NULL ,  '" . $_GET['idClub'] . "',  $date,'payment','".$_GET['concept'].": ".$_GET['amount']." euros'
);";

$res = mysql_query($sql) or die(mysql_error());
echo $sql;
?>
