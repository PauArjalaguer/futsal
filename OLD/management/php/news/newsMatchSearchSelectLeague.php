<?

include ("../../Classes/db.inc");
include("../../Classes/Competition_Class.php");
echo "<label>Jornada</label>";
$competition = new Competition();
$competition->idLeague = $_GET['idLeague'];
$data = $competition->cmptGetRoundsByIdLeague();
$out .="<select class=\"form-control\"  onChange='newsMatchSearchSelectRound();' id=\"newsMatchSearchRoundSelect\">";
$out .="<option>Selecciona una jornada</option>";
foreach ($data as $rounds) {
    $out .="<option value='" . $rounds[0] . "'>Jornada " . utf8_encode($rounds[1]) . "</option>\n";
}


$out .="</select>";

echo utf8_decode($out);
?>
