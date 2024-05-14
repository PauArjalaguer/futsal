<?php

$folder = $_POST['cropType'];


$filename = "../images/dynamic/$folder/" . $_POST['img'];
if ($folder == "playersImages") {
    $new_filename = "../images/dynamic/$folder/" . $_POST['img'];
} else {
    $fn = $_POST['idPlayer'] . "_image_" . mktime() . ".jpg";
    $new_filename = "../images/dynamic/$folder/$fn";
    $copy_filename = "../images/dynamic/playersImages/$fn";
}
//echo $filename . "<br />" . $new_filename;
// Get dimensions of the original image
list($current_width, $current_height) = getimagesize($filename);

// The x and y coordinates on the original image where we
// will begin cropping the image, taken from the form
$percent = floor($_POST['percent']);
if ($percent == 0) {
    $percent = 1;
}
$x1 = ($_POST['x1'] * $percent) / 100;
$y1 = ($_POST['y1'] * $percent) / 100;
$x2 = ($_POST['x2'] * $percent) / 100;
;
$y2 = ($_POST['y2'] * $percent) / 100;
;
$w = ($_POST['w'] * $percent) / 100;
;
$h = ($_POST['h'] * $percent) / 100;
;

//die(print_r($_POST));
//echo "percent: $percent $x1 $y1 $w $h";
// This will be the final size of the image
$crop_width = 320;
$crop_height = 480;

// Create our small image
$new = imagecreatetruecolor($crop_width, $crop_height);
// Create original image
$current_image = imagecreatefromjpeg($filename);
// resamling (actual cropping)
imagecopyresampled($new, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $w, $h);
// creating our new image
imagejpeg($new, $new_filename, 95);

if ($folder == "teamsImages") {

    include ("../includes/config.php");
    include ("../includes/funciones.php");
    conectar();

    copy($new_filename, $copy_filename);
    mysql_query("Update players set image='$fn' where id=" . $_POST['idPlayer']) or die(mysql_error());
    unlink($new_filename);
   mysql_close();
}


header("Location: index.php?f=playerCardEdit&idPlayer=" . $_POST['idPlayer'] . "&idTeam=" . $_POST['idTeam']);
?>
