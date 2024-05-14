<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];

$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Propers partits</h2></div>";
$out .="<div class='contentBoxContent'>";
$out .="<table class='playersTable' cellspacing=0><tr><th width=20 colspan=2>&nbsp;</th><th width=250>Partit</th><th>Data</th><th  >Arbitres</th><th width=15%>Accio</th></tr>";
$sql = "select m.id,t1.name as local, t2.name as visitor, t1.id as idLocal, t2.id as idVisitor,km, m.datetime, m.updateddatetime, rprds.price, rpmds.price as mPrice, prefix, ro.name as round, accepted from cmptMatch_Referee cmr
join rfrReferees r on r.id=cmr.idreferee
join rfrRefereeTypes rt on rt.id=cmr.idRefereeType
join matches m on m.id=cmr.idmatch
join teams t1 on t1.id=m.idlocal
join teams t2 on t2.id=m.idvisitor
join rounds ro on ro.id=m.idround
join leagues l on l.id=ro.idleague
join divisions d on d.id=l.iddivision
join rfrPricePerMatchbyDivisionAndSeason rpmds on rpmds.iddivision=l.iddivision and rpmds.idseason=ro.idseason
join rfrPricePerRefereeByDivisionAndSeason rprds on rprds.idseason=rpmds.idseason and rprds.iddivision=l.iddivision and rprds.idRefereeType=cmr.idRefereeType
 where  idReferee=" . $_COOKIE['idReferee']." order by m.datetime desc";
echo $sql;
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($res)) {
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    $out .="<tr>";
    $out .="<td class='zebra$n'>" . $row['prefix'] . "</td>";
    $out .="<td class='zebra$n'><strong>" . $row['round'] . "</strong></td><td class='zebra$n' width=50> " . $row['local'] . " <br /> " . $row['visitor'] . "</td>";
    if ($row['updateddatetime'] == "0000-00-00 00:00:00") {
        $date = $row['datetime'];
    } else {
        $date = $row['updateddatetime'];
    }
    $h = explode(" ", $date);
    $out .="<td class='zebra$n'>" . dateformatCup($date) . " " . $h[1] . "</td>";
    $out .="<td class='zebra$n'>";
    $sql = " select r.name as referee, rt.refereeTypeName
FROM matches m

join cmptMatch_Referee cmr on cmr.idMatch=m.id
join rfrReferees r on r.id=cmr.idReferee
join rfrRefereeTypes rt on rt.id=cmr.idRefereeType
WHERE m.id=" . $row['id'];
    //echo $sql;
    $res1 = mysql_query($sql) or die(mysql_error());
    while ($r = mysql_fetch_array($res1)) {
       $out .= "<strong>".$r['referee']."</strong> (".$r['refereeTypeName'].")<br />";
    }
    $out .="</td>";
    //$out .="<td class='zebra$n' align=center>" . $row['price'] . " &euro; /".$row['mPrice']." &euro; </td>";
    $out .="<td class='zebra$n pointer' align=center ' nowrap><a style='color:#999;' target=_blank  href='bills.php?idMatch=" . $row['id'] . "'>Nomenament</a><br /><a target=_blank style='color:#999;' href='billsPerClub.php?idMatch=" . $row['id'] . "'>Rebut lliga</a><br /><a style='color:#999;'  target=_blank href='billsPerClub.php?idMatch=" . $row['id'] . "&idTeam=".$row['idLocal']."&t=local'>Rebut copa local</a><br /><a style='color:#999;' target=_blank href='billsPerClub.php?idMatch=" . $row['id'] . "&idTeam=".$row['idVisitor']."&t=visitor'> Rebut copa visitant</a><br />";
	if($row['accepted']==0){
	 $out .= "<button type=\"button\"  class=\"css3button\" onClick='rfrMatchAssignationAccept(".$row['id'].",".$_COOKIE['idReferee'].");'>ACCEPTAR</button>";}
	 $out .="</td>";

    $out .="</tr>";
}

echo utf8_encode($out);
?>
