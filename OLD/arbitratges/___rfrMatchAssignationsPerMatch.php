<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?php

//echo $_GET['idMatch'];
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];
$combo = array();
$comboSQL = "Select id, name, province FROM rfrReferees order by province asc, name asc";
$comboRes = mysql_query($comboSQL) or die(mysql_error());
while ($row = mysql_fetch_row($comboRes)) {
    array_push($combo, $row);
}

$rtCombo = array();
$rtComboSQL = "Select id, refereeTypeName FROM rfrRefereeTypes";
$rtComboRes = mysql_query($rtComboSQL) or die(mysql_error());
while ($row = mysql_fetch_row($rtComboRes)) {
    array_push($rtCombo, $row);
}
//print_r($combo);

$sql = "select m.id ,t1.name as local ,t2.name as visitor ,r.name as referee ,r.id as idReferee ,cmr.id as idCmr, cmr.idRefereeType,km,allowance, ro.idleague, rprds.price as rPrice, rpmds.price as mPrice, accepted 
FROM matches m
join teams t1 on t1.id=m.idlocal join teams t2 on t2.id=m.idvisitor
join rounds ro on ro.id=m.idround
join leagues l on l.id=ro.idleague
join cmptMatch_Referee cmr on cmr.idMatch=m.id
join rfrReferees r on r.id=cmr.idReferee
join rfrRefereeTypes rt on rt.id=cmr.idRefereeType
left join rfrPricePerRefereeByDivisionAndSeason rprds on rprds.idseason=$lastSeasonId
 and rprds.iddivision=l.iddivision and rprds.idRefereeType=cmr.idRefereeType
left join rfrPricePerMatchbyDivisionAndSeason rpmds on rpmds.idSeason=$lastSeasonId and rpmds.idDivision=l.iddivision
WHERE m.id=" . $_GET['idMatch'];
//echo "_____<br >$sql<br/>_______";

$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2 onClick='rfrMatchAssignationsPerMatch(" . $_GET['idMatch'] . ");'>Propers partits</h2></div>";
$out .="<div class='contentBoxContent'>";
$out .="<table class='playersTable' cellspacing=0><tr><th width=350>Arbitre</th><th>Funció</th><th>Kilometratge</th><th>Dieta</th><th>Preu</th></tr>";

$res = mysql_query($sql) or die(mysql_error());
if (mysql_num_rows($res) >= 1) {
    while ($row = mysql_fetch_array($res)) {
        if ($n == 1) {
            $n = 2;
        } else {
            $n = 1;
        }
        $out .="\n\t<tr>";
        $out .="\n\t\t<td class='zebra$n'>\n\t\t\t<select id='rfrMatchAssignationsUpdateByCmrId_" . $row['idCmr'] . "' onChange='rfrMatchAssignationsUpdateByCmrId(" . $row['idCmr'] . "," . $_GET['idMatch'] . ");'>";

        foreach ($combo as $referees) {
            if ($referees[2] != $province) {
                $out .="\n\t\t\t<option disabled>&bull; " . $referees[2] . "</option>";
            }
            $selected = "";
            if ($referees[0] == $row['idReferee']) {
                $selected = "selected";
            }
            $out .="\n\t\t\t<option $selected value=\"" . $referees[0] . "\" >" . $referees[10] . " " . $referees[1] . "</option>";
            $province = $referees[2];
        }
        $out .="<option disable>__________</option><option value=\"0\">Eliminar</option>";
        $out .="</select></td>";

        $out .="\n\t\t<td class='zebra$n'>\n\t\t\t<select id='rfrMatchAssignationsUpdateTypeByCmrId_" . $row['idCmr'] . "' onChange='rfrMatchAssignationsUpdateTypeByCmrId(" . $row['idCmr'] . "," . $_GET['idMatch'] . ");'>";

        foreach ($rtCombo as $rTypes) {

            $selected = "";
            if ($rTypes[0] == $row['idRefereeType']) {
                $selected = "selected";
            }
            $out .="\n\t\t\t<option $selected value=\"" . $rTypes[0] . "\" >" . $rTypes[1] . "</option>";
        }
        $out .="<option disable>__________</option><option value=\"0\">Eliminar</option>";
        $out .="</select></td>";
        $out .="<td class='zebra$n'><input style='width:40px; text-align:center;' type=\"text\" id=\"rfrMatchAssignationsUpdateKmByCmrId_" . $row['idCmr'] . "\" value=\"" . $row['km'] . "\" onKeyUp='rfrMatchAssignationsUpdateKmByCmrId(" . $row['idCmr'] . "," . $_GET['idMatch'] . ");'></td>";
        $out .="<td class='zebra$n'><input style='width:40px; text-align:center;' type=\"text\" id=\"rfrMatchAssignationsUpdateAllowanceByCmrId_" . $row['idCmr'] . "\" value=\"" . $row['allowance'] . "\" onKeyUp='rfrMatchAssignationsUpdateAllowanceByCmrId(" . $row['idCmr'] . "," . $_GET['idMatch'] . ");'>";
	
       
        $out .="<td class='zebra$n'>" . $row['rPrice'] . " ";
			if($row['accepted']==1){ $out .= " <span style='font-weight:bold; color:#090;'>ACCEPTAT</span>"; }
		$out .="</td></tr>";
        $sum = $sum + $row['rPrice']+$row['km']+$row['allowance'];
        $matchPrice = $row['mPrice'];
        $total=$matchPrice - $sum;

    }
}

$out .="\n\t\t<tr><td class='zebra2' colspan=4>\n\t\t\t<select id='rfrMatchAssignationsInsert' onChange='rfrMatchAssignationsInsert(" . $_GET['idMatch'] . ");'><option></option>";

foreach ($combo as $referees) {
    if ($referees[2] != $province) {
        $out .="\n\t\t\t<option disabled>&bull; " . $referees[2] . "</option>";
    }

    $out .="\n\t\t\t<option value=\"" . $referees[0] . "\" >" . $referees[10] . " " . $referees[1] . "</option>";
    $province = $referees[2];
}
$out .="</select></td></tr>";
$out .="<tr><td colspan=3 class='zebra1'>Suma</td><td class='zebra1'>$sum</td></tr>";
$out .="<tr><td colspan=3 class='zebra2'>Preu del partit</td><td class='zebra2'>$matchPrice</td></tr>";
$out .="<tr><td colspan=3 class='zebra1'>Retornar</td><td class='zebra1'>$total <br /><span style='cursor:pointer;' onClick='rfrMatchAssignationsPerMatch(" . $_GET['idMatch'] . ");'><img src='http://www.futsal.cat/administration/images/refresh.png' /></span></td>";

$out .="</tr>";

echo utf8_encode($out);
?>
