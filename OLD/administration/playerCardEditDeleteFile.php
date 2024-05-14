<?php
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
print_r($_GET);

if($_GET['item']=="DNI"){
 $sql = "Update players set DNIscan=NULL where id=" . $_GET['idPlayer'];
}else if ($_GET['item']=="insurance"){
     $sql = "DELETE FROM player_insurance where id=" . $_GET['idItem'];
     $sql = "Update players set insurancescan=NULL where id=" . $_GET['idPlayer'];
}
echo $sql;
mysql_query($sql);



?>
