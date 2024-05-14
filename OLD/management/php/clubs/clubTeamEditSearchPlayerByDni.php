<?
include("../../Classes/db.inc");
include("../../Classes/Clubs_Class.php");
$clubs = new Clubs();
$clubs->dni = $_GET['dni'];
$data = $clubs->clubTeamEditSearchPlayerByDni();
//print_r($data);
foreach ($data as $team) {
    echo "<tr >";
    echo "<td class='pointer' onClick='clubPlayerActivateOldLicense(" . $team[0] . ",".$_GET['idTeam'].");'>" . utf8_decode($team[1]) . "</td>";
    echo "</tr>";
}
?>  
