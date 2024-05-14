<?php

session_start();
include ("includes/config.php");
include ("includes/funciones.php");
conectar();
//cadena divisions
$out .="<table class='playersTable' width=100% cellpadding=5 cellspacing=0><tr><th>Foto</th><th>Nom</th><th>Data</th><th>Equip</th><th>Fitxa</th><th>Ciutat</th><th colspan=2>Alta fitxa</th></tr>";
$sql2 = "select distinct idDivision from tmpSeleccionadorDivisions tst join divisions d on d.id=tst.iddivision where sessionId='" . session_id() . "'";
$res = mysql_query($sql2);
$n = 0;
while ($row = mysql_fetch_array($res)) {
    if ($n == 0) {
        $dvString = $row['idDivision'];
    } else {
        $dvString .="," . $row['idDivision'];
    }
    $n++;
}


//cadena teams
$sql2 = "select distinct idTeam from tmpSeleccionadorTeams tst join teams t on t.id=tst.idteam where sessionId='" . session_id() . "'";
$res = mysql_query($sql2);
$n = 0;
while ($row = mysql_fetch_array($res)) {
    if ($n == 0) {
        $tmString .= $row['idTeam'];
    } else {
        $tmString .= "," . $row['idTeam'];
    }
    $n++;
}

//cadena city
$sql2 = "select distinct cityName from tmpSeleccionadorCity  where sessionId='" . session_id() . "'";
$res = mysql_query($sql2);
$n = 0;
while ($row = mysql_fetch_array($res)) {
    if ($n == 0) {
        $ciString .= "'" . $row['cityName'] . "'";
    } else {
        $ciString .= ",'" . $row['cityName'] . "'";
    }
    $n++;
}

//cadena anys
$sql2 = "select distinct age from tmpSeleccionadorAge  where sessionId='" . session_id() . "'";
$res = mysql_query($sql2);
$n = 0;
while ($row = mysql_fetch_array($res)) {
    if ($n == 0) {
        $ageString .= "'" . $row['age'] . "'";
    } else {
        $ageString .= ",'" . $row['age'] . "'";
    }
    $n++;
}


$sql = "select distinct p.id,p.name, p.birthdate, p.image, p.city,province,t.name as team, pp.position, c.phone1, c.phone2,c.email, paymentdate from players p
       join player_team_season pts on pts.idplayer=p.id
       join teams_divisions_per_season td on td.idteam=pts.idteam
       join teams  t on td.idteam=t.id
       join clubs c on c.id=t.idclub
       
      
       join playerPositions pp on pp.id=pts.position
where pts.idseason=8  and ispayed= 1 and statuspercent=100";

if (strlen($_GET['playerName']) >= 3) {
    $sql .=" and p.name like '%" . $_GET['playerName'] . "%' ";
}
if (strlen($dvString) > 0) {
    $sql .=" and td.idDivision in ($dvString) ";
}
if (strlen($tmString) > 0) {
    $sql .=" and td.idTeam in ($tmString) ";
}
//echo strlen($ciString);
if (strlen($ciString)>0) {
    $sql .=" and p.city in ($ciString) ";
}
if (strlen($ageString)>0) {
    $sql .=" and YEAR(birthdate) in  ($ageString) ";
}
if (strlen($_GET['startDate'])>0) {
    $d=explode("/",$_GET['startDate']);
    $startDate=$d[2]."-".$d[0]."-".$d[1];
    $sql .=" and paymentdate>= '".$startDate."'";
}
if (strlen($_GET['endDate'])>0) {
    $d=explode("/",$_GET['endDate']);
    $endDate=$d[2]."-".$d[0]."-".$d[1];
    $sql .=" and paymentdate<= '".$endDate."'";
}


$sql .=" order by t.name, pts.position
limit 0,1000 ";
//echo $sql;
$res = mysql_query($sql);
echo mysql_num_rows($res)." resultats<br />";
while ($row = mysql_fetch_array($res)) {
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    $out .="<tr>";
    $out .="<td class='zebra$n'><img src='http://www.futsal.cat/images/dynamic/playersImages/" . $row['image'] . "' width=50></td>";

    $out .="<td class='zebra$n'>" . $row['name'] . "<br />" . $row['id'] . "</td>";
     $out .="<td class='zebra$n'>" . invertdateformat($row['birthdate']) . "</td>";
    $out .="<td class='zebra$n'>" . $row['team'] . "</td>";
     $out .="<td class='zebra$n'>" . $row['position'] . "</td>";
   
    $out .="<td class='zebra$n'>" . $row['city'] . "</td>";
     $out .="<td class='zebra$n'>" .  substr($row['paymentdate'],0,10) . "</td>";
     $out .="<td class='zebra$n'><a href='administration/playerCardPrint.php?idPlayer=" . $row['id'] . "' target=_blank><img src='http://www.futsal.cat/administration/images/print.png' /></a></td>";
    $out .="</tr>";
}
$out .="</table>";
echo utf8_encode($out);
?>

