<?

include ("../../Classes/db.inc");
include("../../Classes/Files_Class.php");
$files = new Files();

$archivo = utf8_decode($_FILES["file"]['name']);
$archivo=str_replace(" ","", $archivo);
$prefijo = substr(md5(uniqid(rand())), 0, 6);
$destino = "../../../documentacio/$archivo";

copy($_FILES["file"]['tmp_name'], $destino);
 //move_uploaded_file($archivo, $destino);

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
$files->fileToUpload=$archivo;
$data=$files->filesUploadDocument();
echo $data;
$log .= date("d-m-Y h:m:s") . " ---->Nom:" . $archivo . "";
$log .=chr(13) . chr(10) . "               >> Arxiu:" . $_FILES["file"]['tmp_name'];
$log .=chr(13) . chr(10) . "               >> Desti: $destino";
$log .=chr(13) . chr(10) . "               >> Mida: $fileSize";
$log .=chr(13) . chr(10) . "               >> Extensio: $extension $n";
$log .=chr(13) . chr(10) . "               >> IP:" . $_SERVER['REMOTE_ADDR'] . chr(13) . chr(10) . chr(13) . chr(10);
$fp = fopen("log.txt", "a+");
fwrite($fp, "$log");
fclose($fp);
?>