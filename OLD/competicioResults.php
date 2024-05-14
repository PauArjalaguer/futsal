<?

$out = "";
include ("includes/db.inc");
include ("includes/funciones.php");
include("Classes/Competition_class.php");
$competition = new Competition;
$competition->idLeague = $_GET['idLeague'];
$competition->idRound = $_GET['idRound'];
$data = $competition->getResultsByLeagueAndRound();

$roundNumberArray = $competition->getLastRoundWithResults();


$roundName = $competition->getNextRoundName();

$out .= "\n\n\n<table id=\"taulaclassificacio\" width=\"100%\" cellspacing=0 cellpadding=0 >\n\t<thead>\n\t\t<tr>\n\t\t\t<th colspan=3>";
if ($_GET['idRound'] > 1) {
    $prevNumber = $_GET['idRound'] - 1;

    $out .= "<a href='competicioPrint.php?idLeague=" . $_GET['idLeague'] . "&idRound=" . $_GET['idRound'] . "' target=_blank><img src='http://www.futsal.cat/webImages/print.png' ></a>$prevaNumber<!--<img class='button' onclick='competitionShowResultsByLeagueAndRound($prevNumber," . $_GET['idLeague'] . ");' src='http://www.futsal.cat/webImages/previous.png'>--> ";
}

$out .="Resultats jornada $roundaName";
$roundsData = $competition->getRoundsByIdLeague();
$out .= " <select id=\"roundSelection\" class='select' onchange='competitionShowResultsByLeagueAndRound(" . $_GET['idLeague'] . ");' >";
foreach ($roundsData as $round) {
    $sel = "";
    if ($round[0] == $_GET['idRound']) {
        $sel = "selected";
    }
    $out .= "<option value=\"$round[0]\" $sel >$round[1]</option>";
}
$out .= "</select>";

//$out .=" $nextNaumber<img class='button' onclick='competitionShowResultsByLeagueAndRound($nextNumber," . $_GET['idLeague'] . ");' src='http://www.futsal.cat/webImages/next.png'> ";
$out . "</th>\n\t\t</tr>\n\t</thead>\n\t<tbody>";




if (count($data) > 0) {

    foreach ($data as $match) {
        if ($n == 1) {
            $n = 2;
        } else {
            $n = 1;
        }
        if (empty($match[6])) {
            $match[6] = "c00";
        }
        $out .= "\n\t\t<tr>\n\t\t\t<td class='clasif zebra$n' style='width:12px;'>\n\t\t\t\t<div style='background-color:#" . $match[6] . "; width:6px; height:6px; padding:3px; border:1px solid #fff;'>&nbsp;</div>\n\t\t</td>\n\t\t";
        $out .="<td class='equip zebra$n'>";
        $out .= "<a href='" . $serverUrl . "equip/" . $match[7] . "-" . teamUrlFormat($match[0]) . "'>$match[0]</a> -";
        $out .= "<a href='" . $serverUrl . "equip/" . $match[8] . "-" . teamUrlFormat($match[1]) . "'>$match[1]</td>\n\t\t";
        $out .="<td class='equip zebra$n'>$match[2] - $match[3]</td>\n\t</tr>";
    }
} else {
    $out .="<tr><td class='equip' colspan=4>Resultats encara no disponibles</td></tr>";
}
$status = new Competition;

$sd = $status->getAllMatchStatus();

$out .= "\n\t<tr><td  class='td'>&nbsp;</td>\n\t\t<td colspan=7 class='td'>";
foreach ($sd as $status) {
    $out .= "<div style='float:left; margin-right:15px;'>\n\t\t\t<div style='background-color:#" . $status[2] . "; width:6px; height:6px; padding:3px; border:1px solid #fff; float:left;'>&nbsp;</div>&nbsp;" . $status[1] . "</div>\n\t\t";
}
$out .= "</td>\n\t</tr>";



$out .= "\n\t</tbody>\n</table>";
echo utf8_encode($out);
?>