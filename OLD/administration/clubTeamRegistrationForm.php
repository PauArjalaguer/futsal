<?php

header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<?php

//echo $_GET['idTeam'];
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar ();
$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];
//echo $lastSeasonId;

$sql = "
    select
        name from clubs c
 where c.id=" . $_GET ['idClub'];

$res = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($res);
$clubName = $row ['name'];

$out .= "<div class='contentBox'>";

$out .= "<div class='contentBoxHeader'>";
$out .= "<div style='width:50%; float:left;'><h2>Equips del club " . $clubName . "</h2></div>";
$out .= "<div style='width:50%; float:left; text-align:right;'><img class='pointer' onClick='clubCashingInfo(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/administration/images/euro.png' /> <img class='pointer' onClick='clubBallsBuyingForm(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/webImages/soccer.png' /> <img class='pointer' onClick='clubTeamRegistrationForm(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/webImages/page_edit.png' /fi></div><div style='clear:both;'></div>";
$out .= "</div>";
$out .= "<div class='contentBoxContent'>";
$out .= "<table class='playersTable' cellspacing=0 style='width:100%;' ><tr><th width=20%>Equip</th><th >Divisió</th><th >Preu drets</th><th width=20% >Data pagament</th></tr>";

$res1 = mysql_query("SELECT t.id, t.name, ate.datetime, d.name as league , rdst.rate, d.id as idDivision, adste.rate as newRate, reason  FROM teams t
left join admTeamEntries ate on ate.idteam=t.id and ate.idseason=$lastSeasonId
left join teams_divisions_per_season td on td.idteam=t.id and td.idseason=$lastSeasonId
left join divisions d  on d.id=td.iddivision
left join rate_division_season_per_team rdst on rdst.iddivision=td.iddivision and rdst.idseason=$lastSeasonId
left join admrate_division_season_per_teams_exceptions adste on adste.idteam=t.id and adste.idseason=$lastSeasonId
where idClub=" . $_GET['idClub']) or die(mysql_error());

while ($row1 = mysql_fetch_array($res1)) {
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    $date = explode(" ", $row1 ['datetime']);
    $d = invertdateformat($date [0]);

    $out .="<tr>";


    $out .= "<td class='zebra$n' nowrap >";
    $out .= $row1 ['name'];
    $out .= "</td>";
    $out .= "<td class='zebra$n' align=right>";
    $out .= $row1 ['league'];

    //$residu = $residu + $row1 ['amount'];
    $out .= "</td>";
    $out .= "<td class='zebra$n'>";
    if (!empty($row1['newRate'])) {

        $out .="<span style='color:red; text-decoration:line-through;'>" . $row1['rate'] . "</span> " . $row1['newRate'] . "</span>";
    $out .="<div style='margin:5px; padding:5px; background-color:#ddd; border:1px solid #fff;'>".$row1['reason']."</div>";

    } else {
        if (empty($row1['datetime'])) {
            $out .= "<input type='text' style='width:50px;' value='" . $row1['rate'] . "' id='rateDivisionChangeInput_" . $row1['id'] . "' disabled > <img style='vertical-align:baseline; cursor:pointer;' onClick='rateDivisionChangeEnableInput(" . $row1['id'] . ")' src='images/application_edit.png'> ";
        } else {
            $out .=$row1['rate'];
        }
    }
    $out .= "</td>";
    $out .= "<td class='zebra$n' >";
    if (trim($d) != "--") {
        $out .= trim($d);
    } else {
        if (!empty($row1['league'])) {
            $out .="<span onClick='clubTeamRegistrationInsert(" . $_GET['idClub'] . "," . $row1['id'] . "," . $row1['rate'] . ")' ><img src='http://www.futsal.cat/administration/images/euro.png' /></span>";
        }
    }

    $out .= "</td>";
    $out .= "</tr>";
    $m = $row1['month'];
}
if ($n == 1) {
    $n = 2;
} else {
    $n = 1;
}
$out .="</table>";


$out .= "<div style='margin-top:10px; background-color:#efefef; padding:10px; border:1px solid #ededed;'><img class='pointer' onClick='clubCashingInfo(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/administration/images/euro.png' /> <img class='pointer' onClick='clubBallsBuyingForm(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/webImages/soccer.png' /> <img class='pointer' onClick='clubTeamRegistrationForm(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/webImages/page_edit.png' /fi></div><div style='clear:both;'></div>";
$out .= "</div>";
$out .= "</div>";


echo utf8_encode($out);
?>
