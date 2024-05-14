<?

include ("../../Classes/db.inc");
include("../../Classes/Files_Class.php");

$files = new Files();

$log .=chr(13) . chr(10) . "____________________________________________________________________________________________________________________" . chr(13) . chr(10);

$archivo = $_FILES["file"]['name'];
print_r($_FILES);
$prefijo = $_GET['idMatch'];

$ex=explode(".",$archivo);
print_r($ex);
$n=count($ex)-1;
$extension=$ex[$n];
$destino = "../../../Actes/$prefijo.$extension";
copy($_FILES["file"]['tmp_name'], $destino);
// move_uploaded_file($archivo, $destino);

$log .= date("d-m-Y h:m:s") . " ---->Nom:" . $archivo . "";
$log .=chr(13) . chr(10) . "               >> Arxiu:" . $_FILES["file"]['tmp_name'];
$log .=chr(13) . chr(10) . "               >> Destí: $destino";
$log .=chr(13) . chr(10) . "               >> Mida: $fileSize";
$log .=chr(13) . chr(10) . "               >> Extensió:  ".$e[1]." $extension $n";
$log .=chr(13) . chr(10) . "               >> IP:" . $_SERVER['REMOTE_ADDR'] . chr(13) . chr(10) . chr(13) . chr(10);
$fp = fopen("log.txt", "a+");
fwrite($fp, "$log");
fclose($fp);
echo $prefijo.".".$extension;

$files->matchId=$_GET['idMatch'];
$files->fileExtension=$extension;
$files->fileRefereeMinuteUploaderSave();

?>