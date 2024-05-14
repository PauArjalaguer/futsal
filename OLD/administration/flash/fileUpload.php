<?php

function standarizeSize($imatge) {

    $nombre_archivo = "imatge.txt";

    $archivo = $nombre_archivo;
    $f = fopen($archivo, "w");
    $out .="Arxiu=" . $imatge . "--\n" . time();
    list($ample, $alt, $tipus, $atr) = getimagesize($imatge);
    $out .="Ample: $ample Alt: $alt Tipus= $tipus--\n";
    $relacio = $ample / $alt;
    $out .="Relacio: $relacio\n";


    if ($ample >= 2560) {
        $h = 2560;
        $v = abs(floor($h / $relacio));
        $out .=$h . "x" . $v . "\n";
    } else if ($ample >= 1280) {
        $h = 1280;
        $v = abs(floor($h / $relacio));
        $out .=$h . "x" . $v . "\n";
    } else if ($ample >= 640) {
        $h = 640;
        $v = abs(floor($h / $relacio));
        $out .=$h . "x" . $v . "\n";
    } else if ($ample >= 320) {
        $h = 320;
        $v = abs(floor($h / $relacio));
        $out .=$h . "x" . $v . "\n";
    } else {
        $h = 320;
        $v = abs(floor($h / $relacio));
        $out .=$h . "x" . $v . "\n";
    }


    $out .="GENERA IMATGE GRAN\n";
    $imagen_original = imagecreatefromjpeg($imatge);
    $out .="imagen original\n" . $imagen_original . "\n";
    $out .=$h . "x" . $v . "\n";
    $imagen_redimensionada = imagecreatetruecolor($h, $v);
    imagecopyresampled($imagen_redimensionada, $imagen_original, 0, 0, 0, 0, $h, $v, $ample, $alt);
    imagejpeg($imagen_redimensionada, $imatge);


    imagedestroy($imagen_original);

    imagedestroy($imagen_redimensionada);
    if ($_GET['fileType'] == "teamImage") {
        teamPageSize($imatge);
    }

    fputs($f, $out);
    fclose($f);
}

function teamPageSize($imatge) {
$target=str_replace("teamsImages/","teamsImages/thumbs/",$imatge);
 copy($imatge, $target);
   list($ample, $alt, $tipus, $atr) = getimagesize($target);
    $out .="Ample: $ample Alt: $alt Tipus= $tipus--\n";
    $relacio = $ample / $alt;
    $out .="Relacio: $relacio\n";
    $h2 = 575;
    $v2 = abs(floor($h2 / $relacio));
    $out .="GENERA IMATGE PETITA $target\n";
    $out .=$h2 . "x" . $v2 . " Ample:$ample Alt:$alt\n";
    $imagen_original2 = imagecreatefromjpeg($target);
    $out .="imagen original petita " . $imagen_original2 . "\n\n";
    $imagen_redimensionada2 = imagecreatetruecolor($h2, $v2);
    imagecopyresampled($imagen_redimensionada2, $imagen_original2, 0, 0, 0, 0, $h2, $v2, $ample, $alt);
    imagejpeg($imagen_redimensionada2,  $target);
}

//echo $_GET['idPlayer'];

include ("../../includes/config.php");
include ("../../includes/funciones.php");
conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$fn = $_GET['idPlayer'] . "_" . $_GET['fileType'] . "_" . mktime() . ".jpg";
$filename = "../../images/dynamic/playersImages/$fn";
$out2 .="Filetype=" . $_GET['fileType'] . "\n";
if ($_GET['fileType'] == "DNI") {
    $sql = "Update players set DNIscan='$fn' where id=" . $_GET['idPlayer'];
} else if ($_GET['fileType'] == "insurance") {
    $sql1 = "select id from player_insurance where idPlayer=" . $_GET['idPlayer'] . " and scan is not null and (expirationDate<now() or expirationDate is null)";
    $res1 = mysql_query($sql1);
    $row1 = mysql_fetch_array($res1);
    if (mysql_num_rows($res1) > 0) {
        $sql = "Update player_insurance set scan='$fn' where id=" . $row1['id'];
    } else {
        $sql = "Insert into player_insurance (idPlayer, scan) values (" . $_GET['idPlayer'] . ",'$fn')";
    }
} else if ($_GET['fileType'] == "teamImage") {
    $fn = $_GET['idTeam'] . "_" . $_GET['fileType'] . "_" . mktime() . ".jpg";
    $filename = "../../images/dynamic/teamsImages/$fn";

    $sql1 = "select image from team_image_season where idTeam=" . $_GET['idTeam'] . " and idSeason=$lastSeasonId";
    $out2.="SQL1 =$sql1 \n";


    $res1 = mysql_query($sql1);
    $row1 = mysql_fetch_array($res1);
    if (mysql_num_rows($res1) > 0) {
        $sql = "Update team_image_season set image='$fn' where idTeam=" . $_GET['idTeam'] . " and idSeason=$lastSeasonId";
    } else {
        $sql = "Insert into team_image_season (idTeam, image, idSeason) values (" . $_GET['idTeam'] . ",'$fn',$lastSeasonId)";
    }
} else {

    $sql = "Update players set image='$fn' where id=" . $_GET['idPlayer'];
}

$out2 .="SQL=" . $sql;
$file = "44.txt";
$f = fopen($file, "w");
fputs($f, $out2);
fclose($f);
mysql_query($sql);
copy($_FILES['Filedata']['tmp_name'], $filename);
standarizeSize($filename);
?>