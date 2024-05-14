<?
include("../../Classes/db.inc");
include("../../Classes/News_Class.php");
include("../../Classes/Competition_Class.php");
$cmpt = new Competition();
$cmpt->idMatch = $_GET['idMatch'];
$cmpt->idTeam = $_GET['idTeam'];
$cmpt->idPlayer = $_GET['idPlayer'];
$cmpt->isCaptain = $_GET['isCaptain'];

if ($_GET['action'] == "true") {
    $cmpt->cmptPlayerMatchInsertCaptain();
} else {
    $cmpt->cmptPlayerMatchDeleteCaptain();
}
?>
