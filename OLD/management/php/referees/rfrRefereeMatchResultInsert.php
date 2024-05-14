<?
include("../../Classes/db.inc");
include("../../Classes/News_Class.php");
include("../../Classes/Competition_Class.php");
$cmpt = new Competition();
$cmpt->idMatch = $_GET['idMatch'];
$cmpt->localResult = $_GET['localResult'];
$cmpt->visitorResult = $_GET['visitorResult'];

$cmpt->prevLocalResult = $_GET['prevLocalResult'];
$cmpt->prevVisitorResult = $_GET['prevVisitorResult'];

$cmpt->idLocal = $_GET['idLocal'];
$cmpt->idVisitor = $_GET['idVisitor'];

$cmpt->cmptResultInsert();
?>
