<?

include ("../../Classes/db.inc");
include("../../Classes/Files_Class.php");
include("../../Classes/Clubs_Class.php");
$files = new Files();

$log .=chr(13) . chr(10) . "____________________________________________________________________________________________________________________" . chr(13) . chr(10);

$archivo = $_FILES["file"]['name'];
//print_r($_FILES);
$prefijo = $_GET['idPlayer']."_".substr(md5(uniqid(rand())), 0, 6);
$prefijo = $_GET['idPlayer'];

$destino = "../../../images/dynamic/playersImages/".$_GET['idPlayer']."_".$_GET['type'].".jpg";

copy($_FILES["file"]['tmp_name'], $destino);
// move_uploaded_file($archivo, $destino);
$s = getimagesize($destino);
if ($s[0] >= 1000) {
    $log .= chr(13) . chr(10) . "L' arxiu fa més de 1000px:".$s[0];
    $ratio = $s[0] / 1000;
    $h = floor($s[1] / $ratio);
   // preg_match('/jpg/', $this->filename, $extension);
    if (preg_match("/jpg/i", $destino)) {
        $log .= chr(13) . chr(10) . "Entrem a la funció de resize 1000/$h";
        $files->fileRedimensionCreateJpg($destino, $destino, 1000, $h, 100);
   }
}
$e = explode(".", $archivo);
$n = count($e) - 1;
$extension = $e[$n];

$log .= date("d-m-Y h:m:s") . " ---->Nom:" . $archivo . "";
$log .=chr(13) . chr(10) . "               >> Arxiu:" . $_FILES["file"]['tmp_name'];
$log .=chr(13) . chr(10) . "               >> Destí: $destino";
$log .=chr(13) . chr(10) . "               >> Mida:". $s[0];
$log .=chr(13) . chr(10) . "               >> Extensió: $extension $n";
$log .=chr(13) . chr(10) . "               >> IP:" . $_SERVER['REMOTE_ADDR'] . chr(13) . chr(10) . chr(13) . chr(10);
$fp = fopen("documentlog.txt", "a+");
fwrite($fp, "$log");
fclose($fp);
$clubs = new Clubs();
$clubs->idPlayer=$_GET['idPlayer'];
$clubs->type=$_GET['type'];
$clubs->clubPlayerDocumentUpdate();

?>