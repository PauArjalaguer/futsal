<?

include ("../../Classes/db.inc");
include("../../Classes/Files_Class.php");
include("../../Classes/Clubs_Class.php");

$clubs = new Clubs();
$clubs->idPlayer=$_GET['idPlayer'];
$clubs->type=$_GET['type'];
$clubs->clubPlayerDocumentDelete();

?>