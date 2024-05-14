<?
include("../../Classes/db.inc");
include("../../Classes/Competition_Class.php");
$cmpt = new Competition();
$cmpt->idMatch = $_GET['idMatch'];
$cmpt->idTeam = $_GET['idTeam'];
$cmpt->idPlayer = $_GET['idPlayer'];
$cmpt->isCaptain = $_GET['isCaptain'];
$cmpt->number = $_GET['number'];

$cmpt->rfrRefereesPlayerNumberUpdate();
?>
