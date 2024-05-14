<?php

if ($_GET['action'] == 'Enable') {
    $sql = "Insert into cPanelSections_users values (" . $_GET['idSection'] . "," . $_GET['idUser'] . ",now(),null)";
} else {
    $sql = "delete from cPanelSections_users where idSection=" . $_GET['idSection'] . " and idUser=" . $_GET['idUser'];
}
echo $sql;
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

$resPerm = mysql_query($sql);
?>

