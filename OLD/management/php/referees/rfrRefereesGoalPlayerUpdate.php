<?
include("../../Classes/db.inc");
include("../../Classes/Competition_Class.php");
$cmpt = new Competition();
$cmpt->idMatch = $_GET['idMatch'];
$cmpt->idGoal = $_GET['idGoal'];
$cmpt->idPlayer = $_GET['idPlayer'];
$cmpt->minute = $_GET['minute'];

$cmpt->rfrRefereesGoalPlayerUpdate();
?>
