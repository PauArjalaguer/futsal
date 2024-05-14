<?php

header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<?php
$out .= "<div class='contentBox'>";

$out .= "<div class='contentBoxHeader'>";
$out .= "<div ><h2>Rebuts</h2></div>";
$out .= "</div>";
$out .= "<div class='contentBoxContent'>";
$out .= "<table class='playersTable' cellspacing=0 style='width:100%;' ><tr><th width=10% >Data</th><th width=10%>Partit</th><th >Lliga</th><th >Jornada</th><th >Accio</th></tr>";

//echo $_GET['idTeam'];
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar ();
$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];
//echo $lastSeasonId;
$n=1;
$res1 = mysql_query("select m.id, t.id as idLocal, t.name as local, t2.id as idVisitor, t2.name as visitor, updateddatetime, r.name as round, l.name as league from matches m
join teams t on t.id=m.idlocal
join teams t2 on t2.id=m.idvisitor
join rounds r on r.id=m.idround
join leagues l on l.id=r.idleague
where t.idclub=".$_GET['idClub']." and l.idseason=$lastSeasonId and statusId=4
order by idleague, '0'+r.name
") or die(mysql_error());

while ($row1 = mysql_fetch_array($res1)) {
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    $date = explode(" ", $row1 ['updateddatetime']);
    $d = invertdateformat($date [0]);

    $out .= "<td class='zebra$n' >";
    $out .= trim($d);
    $out .= "</td>";
    $out .= "<td class='zebra$n' nowrap >";
    $out .= $row1 ['local']." - ".$row1['visitor'];
    $out .= "</td>";
    $out .= "<td class='zebra$n' align=right>";
    $out .= $row1 ['league'];

    $residu = $residu + $row1 ['amount'];
    $out .= "</td>";
    $out .= "<td class='zebra$n'>";
    $out .= $row1['round'];

    $out .= "</td>";
    $out .= "<td class='zebra$n'>";
    $out .= "<a style='color:#424242;'   target=_blank href='http://www.futsal.cat/arbitres/bills.php?idMatch=".$row1['id']."'>Nomenament</a><br />
        <a style='color:#424242;' target=_blank href='http://www.futsal.cat/arbitres/billsPerClub.php?idMatch=".$row1['id']."'>Rebut</a><br />
        <a style='color:#424242;' target=_blank href='http://www.futsal.cat/arbitres/billsPerClub.php?idMatch=".$row1['id']."&idTeam=".$row1['idLocal']."&t=local'>Local</a><br />
        <a style='color:#424242;' target=_blank href='http://www.futsal.cat/arbitres/billsPerClub.php?idMatch=".$row1['id']."&idTeam=".$row1['idVisitor']."&t=visitor'>Visitant</a>";

    $out .= "</td>";

    $out .= "</tr>";
    $m = $row1['month'];
}
if ($n == 1) {
    $n = 2;
} else {
    $n = 1;
}
$oaut .= "<tr>";
$oaut .= "<td class='zebra$n' style='border-top:1px solid #242424;'><input class='playerCardEditInput' type='text' id='paymentDate2' style='width:100px' value=\"" . date('d-m-Y') . "\"></td>";
$oaut .= "<td class='zebra$n' style='border-top:1px solid #242424;'><input class='playerCardEditInput' type='text' id='paymentConcept2' style='width:100px'></td>";
$oaut .= "<td style='border-top:1px solid #242424;' class='zebra$n'><input class='playerCardEditInput' type='text' id='paymentAmount2' style='width:100px'></td>";
$oaut .= "<td style='border-top:1px solid #242424;' class='zebra$n'><input type='button' value='Guardar' class='newPlayerNameButton' onClick='clubPaymentInsert(" . $_GET ['idClub'] . ")'></td>";
$out .="</tr></table>";


$out .= "<div style='margin-top:10px; background-color:#efefef; padding:10px; border:1px solid #ededed;'><img class='pointer' onClick='clubCashingInfo(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/administration/images/euro.png' /> <img class='pointer' onClick='clubBallsBuyingForm(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/webImages/soccer.png' /> <img class='pointer' onClick='clubTeamRegistrationForm(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/webImages/page_edit.png' /fi></div><div style='clear:both;'></div>";
$out .= "</div>";
$out .= "</div>";


echo utf8_encode($out);
?>
