<?php

function redimensiona($imatge) {
    $destino = $imatge;
    $destino_temporal = tempnam("tmp/", "tmp");
    $r = explode("/", $imatge);
//$ending_target=$r[0]."/thumb_".$r[1];
    $ending_target = $destino;
    list($ample, $alt, $tipus, $atr) = getimagesize($imatge);
   if($ample>200){
       $h=200;
       $v=$alt*(200/$ample);

    redimensiona_jpeg($imatge, $destino_temporal, $h, $v, 100);
   }
// guardamos la imagen
    $fp = fopen($ending_target, "w");
    fputs($fp, fread(fopen($destino_temporal, "r"), filesize($destino_temporal)));
    fclose($fp);
}

function redimensiona_jpeg($img_original, $img_nueva, $img_nueva_anchura, $img_nueva_altura, $img_nueva_calidad) {
    $fileName = 'redimensionar_jpeg.txt';
    $f = fopen($fileName, "w");
    $img = imagecreatefromjpeg($img_original);
    $l .=date("Y-m-d H:i:s") . " Imagecreatefromjpg $img_original\n";
    $thumb = imagecreatetruecolor($img_nueva_anchura, $img_nueva_altura);
    $l .=date("Y-m-d H:i:s") . " imagecreatetruecolor($img_nueva_anchura , $img_nueva_altura)\n";
    imagecopyresized($thumb, $img, 0, 0, 0, 0, $img_nueva_anchura, $img_nueva_altura, ImageSX($img), ImageSY($img));
    $l .=date("Y-m-d H:i:s") . " Imagecopyresized\n";
    imagecreatetruecolor($img_nueva_anchura, $img_nueva_altura);
    $l .=date("Y-m-d H:i:s") . "  imagecreatetruecolor\n";
    imagejpeg($thumb, $img_nueva, $img_nueva_calidad);
    $l .=date("Y-m-d H:i:s") . "  imagejpeg( $img_nueva)\n";
    imagedestroy($img);
    fputs($f, $l);
    fclose($f);
}


//print_r($HTTP_POST_FILES);
  $archivo = $HTTP_POST_FILES['userfile']['name'];
  //echo "..".$archivo;

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$fn = mktime() . ".jpg";
$filename = "../webImages/clubsImages/" . $fn;
$sql = "Update clubs set image='$fn' where id=" . $_GET['idClub'];
//echo $sql;
mysql_query($sql);
 move_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'], $filename);
 //move_uploaded_file($_FILES['Filedata']['tmp_name'], $destino);

//redimensiona($filename);
header ("Location: index.php");
?>