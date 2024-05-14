<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx = conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];
//echo $_GET['idTeam'] . " " . $_GET['idMatch'];


$idClub=$row['idclub'];
$idComplex=$row['place'];
$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2 onClick=\"playerCardEdit(" . $_GET['idPlayer'] . "," . $_GET['idTeam'] . ")\";>Canvi d' horari de partit " . $row['local'] . " - " . $row['visitor'] . "</h2></div>";
$out .="<div class='contentBoxContent'><table>";
$datetime = $row['datetime'];
$dt = explode(" ", $datetime);
$date = $dt[0];
$hTime = $dt[1];
$d = explode("-", $date);
$hDate = $d[2] . "-" . $d[1] . "-" . $d[0];

$out .="<tr><td><strong>Hora original</strong></td><td>" . $hDate . " " . $hTime . "</td><td></td></tr>";

$sql1 = "select id, datetime, approved, denied from cmptMatchDateChange  where idMatch=" . $_GET['idMatch'];
// echo $sql;

$res1 = mysql_query($sql1) or die(mysql_error());
$n = 1;
while ($row1 = mysql_fetch_array($res1)) {
    $approved = "";
    $denied = "";
    $dt = explode(" ", $row1['datetime']);
    $date = $dt[0];
    $time = $dt[1];
    $d = explode("-", $date);
    $date = $d[2] . "-" . $d[1] . "-" . $d[0];

    if ($row1['approved'] == 1) {
        $approved = "<img src='http://www.futsal.cat/management/images/accept.png' />";
    }
    if ($row1['denied'] == 1) {
        $denied = "<img src='http://www.futsal.cat/management/images/cross.png' />";
        $out .="<tr><td><strong>Proposta $n</strong></td><td> L' equip rival ha rebutjat jugar el dia " . $date . " a les " . $time . " h. " . $approved . "$denied</td></tr>";
    } else {
        $out .="<tr><td><strong>Proposta $n</strong></td><td> " . $date . " a les " . $time . "h. " . $approved . "$denied</td></tr>";
    }


    $n++;
}
if ($row['dies'] >= 9) {
    if (empty($approved)) {
        $out .="<tr><td colspan=4>Falten " . $row['dies'] . " dies, pots sol.licitar canvi d' horari fins 9 dies abans.</td></tr>";

        $out .="<tr><td>Nova data</td><td><input type='text' value='$hDate' id='match_date'></input>\n\t Hora <input type='text' value='$hTime' id='match_time'></input>&nbsp;<input id='cmptMatchDateChangeInsertButton' type='button' onClick='cmptMatchDateChangeInsert(" . $_GET['idTeam'] . "," . $_GET['idMatch'] . ");' value=Enviar /></td></tr>";
        $out .="<tr><td>Motiu</td><td colspan=2><textarea rows=10 id='matchChangeComment'></textarea></td></tr>";
    }
} else {
    $out .="<tr><td colspan=4>Ja no es pot sol.licitar ajornament del partit, només falten " . $row['dies'] . " dies. Posa't en contacte amb l' altre equip i la Federació per a sol.licitar el canvi.</td></tr>";
}
$out .="</table>";

$out .="<hr><table><tr><td>Canvi de pavelló</td><td><select>";
$sql2="select c.id, complexName from clubs_complex cc join complex c on c.id=cc.idcomplex where idclub=".$idClub;
//echo $sql2;
$res2=mysql_query($sql2) or die(mysql_error());
while($row2=  mysql_fetch_array($res2)){
    if($row2['id']==$idComplex){
        $selected="selected";
    }else{
        $selected="";
    }
    $out .="<option $selected value=\"".$row2['id']."\">".$row2['complexName']."</option>";
}

$out .="</option></select></td></tr></table><hr />";
$out .="<div id=\"cmptMatchComplexNew\"><h2>Crear nou pavelló</h2><br />
    Nom del pavelló : <input id='cmptComplexName' type='text'> Adreça  : <input id='cmptComplexAddress' type='text'> <input type='button' value='Guardar' onClick='cmptMatchComplexInsert(".$idClub.",".$_GET['idTeam'].",".$_GET['idMatch'].");'><!--<input type='button' value='Vista previa' onClick='cmptMatchComplexPreview(".$idClub.",".$_GET['idMatch'].");'/>-->";
$out .="</div><div id='mapPreview'></div>";

echo utf8_encode($out);
?>

