<?

header('content-type: image/jpeg');

function watermarkText($SourceFile, $WaterMarkText, $DestinationFile) {
    list($width, $height) = getimagesize("../images/dynamic/playersImages/" . $SourceFile);
    $image_p = imagecreatetruecolor($width, $height);
    $image = imagecreatefromjpeg("../images/dynamic/playersImages/" . $SourceFile);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);
    $black = imagecolorallocate($image_p, 150, 30, 30);
    $font = 'No-move.ttf';
    $font_size = 65;
    imagettftext($image_p, $font_size, 0, 65, 70, $black, $font, $WaterMarkText);
    if ($DestinationFile <> '') {
        imagejpeg($image_p, $DestinationFile, 100);
    } else {
        header('Content-Type: image/jpeg');
        imagejpeg($image_p, null, 100);
    };
    imagedestroy($image);
    imagedestroy($image_p);
}

;

function watermarkImage($src) {
    $imageSrc = "../images/dynamic/playersImages/" . $src;
    list($ample, $alt, $tipus, $atr) = getimagesize($imageSrc);
    $imagen_original = imagecreatefromjpeg($imageSrc);
    $imagen_redimensionada = imagecreatetruecolor(320, 480);
    imagecopyresampled($imagen_redimensionada, $imagen_original, 0, 0, 0, 0, 320, 480, $ample, $alt);
    imagejpeg($imagen_redimensionada, "polla.jpg");

    //echo "..".$imatge;

    $photo = imagecreatefromjpeg("polla.jpg");
    $watermark = imagecreatefrompng("mask.png");
// This is the key. Without ImageAlphaBlending on, the PNG won't render correctly.
    imagealphablending($photo, true);
// Copy the watermark onto the master, $offset px from the bottom right corner.
    $offset = 10;
    imagecopy($photo, $watermark, 0, 0, 0, 0, imagesx($photo), imagesy($photo));
// Output to the browser
    //header("Content-Type: image/jpeg");
    imagejpeg($photo);
     imagedestroy("polla.jpg");
}

watermarkImage($_GET['src']);
?>