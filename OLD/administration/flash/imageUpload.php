<?php


function redimensionar($imatge) {
    $destino = $imatge;
    $destino_temporal = tempnam("tmp/", "tmp");
    $r = explode("/", $imatge);
    //$ending_target=$r[0]."/thumb_".$r[1];
    $ending_target = $destino;
    list($ample, $alt, $tipus, $atr) = getimagesize($imatge);
    $relacio = $ample / $alt;
    //echo "$ample $alt $relacio";
    if ($relacio > 1) {
        $h = 640;
        $v = 480;
    } else {
        $h = 600;
        $v = 480;
    }
    redimensionar_jpeg($imatge, $destino_temporal, $h, $v, 100);

// guardamos la imagen
    $fp = fopen($ending_target, "w");
    fputs($fp, fread(fopen($destino_temporal, "r"), filesize($destino_temporal)));
    fclose($fp);
}

function redimensionar_jpeg($img_original, $img_nueva, $img_nueva_anchura, $img_nueva_altura, $img_nueva_calidad) {
    // crear una imagen desde el original
    $img = imagecreatefromjpeg($img_original);
    // crear una imagen nueva
    $thumb = imagecreatetruecolor($img_nueva_anchura, $img_nueva_altura);
    // redimensiona la imagen original copiandola en la imagen
    imagecopyresized($thumb, $img, 0, 0, 0, 0, $img_nueva_anchura, $img_nueva_altura, ImageSX($img), ImageSY($img));
    // guardar la nueva imagen redimensionada donde indicia $img_nueva
    imagejpeg($thumb, $img_nueva, $img_nueva_calidad);
    imagedestroy($img);
}

//echo $_GET['idPlayer'];

include ("../../includes/config.php");
include ("../../includes/funciones.php");
conectar();
$fn = mktime() . ".jpg";
$filename = "../../images/dynamic/playersImages/" . $fn;
$sql = "Update players set image='$fn' where id=" . $_GET['idPlayer'];
mysql_query($sql);
copy($_FILES['Filedata']['tmp_name'], $filename);


//redimensionar($filename);
?>