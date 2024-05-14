<?

include ("../../Classes/db.inc");
include("../../Classes/Files_Class.php");

$files = new Files();

$log .=chr(13) . chr(10) . "____________________________________________________________________________________________________________________" . chr(13) . chr(10);

$archivo = $_FILES["file"]['name'];
//print_r($_FILES);
$prefijo = substr(md5(uniqid(rand())), 0, 6);
//$destino = "../../../images/dynamic/teamsImages/$prefijo.jpg";
$destino = "../../../webImages/clubsImages/$prefijo.jpg";

copy($_FILES["file"]['tmp_name'], $destino);
// move_uploaded_file($archivo, $destino);
$s = getimagesize($destino);
if ($s[0] >= 600) {
    $ratio = $s[0] / 600;
    $h = $s[1] / $ratio;
   // preg_match('/jpg/', $this->filename, $extension);
    if (preg_match("/jpg/i", $destino)) {
        //$files->fileRedimensionCreateJpg("../../../images/dynamic/teamsImages/" . $prefijo . ".jpg", "../../images/dynamic/" . $prefijo . ".jpg", 600, $h, 100);
    }
}
if (preg_match("/jpg/i", $destino)) {
   $files->fileRedimensionCreateJpg("../../../webImages/clubsImages/" . $prefijo . ".jpg", "../../../webImages/clubsImages/thumbs/" . $prefijo . ".jpg", 240, 120, 100);
    $files->fileRedimensionCreateJpg("../../../webImages/clubsImages/" . $prefijo . ".jpg", "../../../images/dynamic/teamsImages/micro/" . $prefijo . ".jpg", 50, 50, 100);
}

$e = explode(".", $archivo);
$n = count($e) - 1;
$extension = $e[$n];
/*
  $files = new Files;
  $files->name = $prefijo;
  $files->path = $prefijo;
  $files->ip = $_SERVER['REMOTE_ADDR'];
  $files->fileSize = $fileSize;
  $files->extension = $extension;
  $data = $files->filesUpload();
  $class_vars = get_class_vars(get_class($files));
  $c = count($class_vars);
  for ($a = 0; $a <= $c; $a++) {
  $log .=chr(13) . chr(10) . "->" . $class_vars[$a];
  }
 */

$log .= date("d-m-Y h:m:s") . " ---->Nom:" . $archivo . "";
$log .=chr(13) . chr(10) . "               >> Arxiu:" . $_FILES["file"]['tmp_name'];
$log .=chr(13) . chr(10) . "               >> Destí: $destino";
$log .=chr(13) . chr(10) . "               >> Mida: $fileSize";
$log .=chr(13) . chr(10) . "               >> Extensió: $extension $n";
$log .=chr(13) . chr(10) . "               >> IP:" . $_SERVER['REMOTE_ADDR'] . chr(13) . chr(10) . chr(13) . chr(10);
$fp = fopen("log.txt", "a+");
fwrite($fp, "$log");
fclose($fp);
echo $prefijo.".".$extension;

?>