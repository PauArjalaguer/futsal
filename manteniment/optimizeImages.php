<?php

set_time_limit(0);
//function readimensionar_jpeg($img_original, $img_nueva, $img_nueva_anchura, $img_nueva_altura, $img_nueva_calidad) {

include "config.php";
include "funciones.php";
$mysqli = conectar();

$sql2 = "select distinct image from player_team_season pts
join players p on p.id=pts.idPlayer
where isPayed=1 and length(image)>1";

$res2 = $mysqli->query($sql2);
while ($row2 = mysqli_fetch_array($res2)) {$n++;
    $fullPath = "../images/dynamic/playersImages/" . $row2['image'];
    $fullPathOpt = "../images/dynamic/playersImages/opt/" . $row2['image'];
    $fullThumbPath = "../images/dynamic/playersImages/thumb/" . $row2['image'];
    $fullMicroOpt = "../images/dynamic/playersImages/micro/" . $row2['image'];
    echo "<hr />" . $fullPath . "";
    if (!file_exists($fullPathOpt)) {
        echo "<br />$n Existeix";
        if (file_exists($fullPath)) {
            redimensionar_jpeg($fullPath, $fullPathOpt, 600, 300, 60);
            redimensionar_jpeg($fullPath, $fullThumbPath, 150, 300, 40);
            redimensionar_jpeg($fullPath, $fullMicroOpt, 50, 300, 40);
        }
    } else {
        //echo "<br />No existeix";
    }
}