<?

include ("../../Classes/db.inc");
include("../../Classes/Competition_Class.php");
echo "<label>Partit</label>";
$competition = new Competition();
if (isset($_GET['idRound'])) {
    $competition->idRound = $_GET['idRound'];
    $data = $competition->cmptGetMatchesByIdRound();
} else if (isset($_GET['search'])) {
    $competition->search = $_GET['search'];
    $data = $competition->cmptGetMatchesBySearch();
}
$out .="<select class=\"form-control\"  onChange='newsMatchSearchSelectMatch();' id=\"newsMatchSearchMatchSelect\">";
$out .="<option>Selecciona un partit</option>";
foreach ($data as $rounds) {
    $out .="<option value='" . $rounds[0] . "'> " . $rounds[1] . " - " . $rounds[2] . " ".$rounds[3]." Jor.".$rounds[4]."</option>\n";
}
$out .="</select>";

echo utf8_decode($out);
?>
