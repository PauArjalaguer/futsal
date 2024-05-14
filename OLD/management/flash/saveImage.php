<?php

if (isset($GLOBALS["HTTP_RAW_POST_DATA"])) {
    $jpg = $GLOBALS["HTTP_RAW_POST_DATA"];
    $img = $_GET["img"];
    $fn = mktime(). ".jpg";
    $filename = "../../images/dynamic/playersImages/" . $fn ;
    file_put_contents($filename, $jpg);
    include ("../../includes/config.php");
    include ("../../includes/funciones.php");
    conectar();
    $sql = "Update players set image='$fn' where id=" . $_GET['idPlayer'];

    mysql_query($sql) or die(mysql_error());
} else {
    echo"Encoded JPEG information not received.";
}
?>