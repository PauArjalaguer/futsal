<?

include ("../../Classes/db.inc");
include("../../Classes/Files_Class.php");
include("../../Classes/Clubs_Class.php");
$files = new Files();

$log .=chr(13) . chr(10) . "____________________________________________________________________________________________________________________" . chr(13) . chr(10);

$destino = "../../../images/dynamic/playersImages/".$_GET['idPlayer'].".jpg";
$files->fileImageRotate("../../../images/dynamic/playersImages/".$_GET['idPlayer']. ".jpg", "../../../images/dynamic/playersImages/".$_GET['idPlayer']. ".jpg");

?>