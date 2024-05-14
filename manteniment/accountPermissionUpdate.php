<?php

if ($_GET['action'] == 'Enable') {
    $sql = "Insert into cPanelSections_users values (" . $_GET['idSection'] . "," . $_GET['idUser'] . ",now(),null)";
} else {
    $sql = "delete from cPanelSections_users where idSection=" . $_GET['idSection'] . " and idUser=" . $_GET['idUser'];
}
echo $sql;
include ("config.php");
include ("funciones.php");
conectar();

$resPerm = mysql_query($sql);
?>

