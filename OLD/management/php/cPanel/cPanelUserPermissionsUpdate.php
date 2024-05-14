<?

include ("../../Classes/db.inc");

include("../../Classes/cPanel_Class.php");

$cPanel = new cPanel();
$cPanel->idUser = $_GET['idUser'];
$cPanel->idSection = $_GET['idSection'];
$cPanel->action = $_GET['action'];
$cPanel->cPanelUserPermissionsUpdate();

?>