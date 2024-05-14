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
$out .="<table class='playersTable' cellspacing=0><tr><th width=20>&nbsp;</th><th width=300>Partit</th><th>Data</th><th  >Arbitres assignats</th><th width=10%>Accio</th></tr>";
$sql = "select
        distinct m.id
        , t1.name as local
        , t2.name as visitor
        , datetime
        , updateddatetime
        , '0'+r.name as round
        , (select count(1) from cmptMatch_Referee where idMatch=m.id) as refereesCount
,l.name as league
        from matches m
join teams t1 on t1.id=m.idlocal
join teams t2 on t2.id=m.idvisitor
join rounds r on r.id=m.idround
join leagues l on l.id=r.idleague

where l.idseason=$lastSeasonId and idleague=".$_GET['idLeague']." and datetime is not null and datetime<>'' and m.statusid<>4
order by l.id,round,updateddatetime asc, datetime asc --  limit 0,3300";

//echo $sql;
$res = mysql_query($sql) or die(mysql_error());
$n=0;
while ($row = mysql_fetch_array($res)) {

    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    if ($league != $row['league']) {
        $out .="<tr><td colspan=4><h2>" . $row['league'] . "</td></tr>";
        $a = 1;
    }
    if ($a <= 1000) {
        $out .="<tr>";
        $out .="<td class='zebra$n'>" . $row['round'] . "</td>";
        $out .="<td class='zebra$n'>" . $row['local'] . " - " . $row['visitor'] . "</td>";

        if ($row['updateddatetime'] == "0000-00-00 00:00:00") {
            $date = $row['datetime'];
        } else {
            $date = $row['updateddatetime'];
        }
        $h = explode(" ", $date);
        $hour = $h[1];
        $out .="<td class='zebra$n'>" . invertdateformat($date) . " $hour </td>";
        $out .="<td class='zebra$n' align=center>" . $row['refereesCount'] . "</td>";
        $out .="<td class='zebra$n pointer' align=center onClick='rfrMatchAssignationsPerMatch(" . $row['id'] . ");'>Assignacions</td>";

        $out .="</tr>";
        $a++;
    }
    $league = $row['league'];
}

echo utf8_encode($out);
?>
