<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx = conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];
$date = $_GET['date'];
$time = $dt[1];
$d = explode("-", $date);
$date = $d[2] . "-" . $d[1] . "-" . $d[0];
$dt = $date . " " . $_GET['time'];

echo $_GET['idTeam'] . " " . $_GET['idMatch'];
$sql = "update cmptMatchDateChange set approved=1 where id=" . $_GET['id'];
echo $sql;

$res = mysql_query($sql) or die(mysql_error());
$sql = "select datetime from cmptMatchDateChange where id=" . $_GET['id'];
echo $sql;

$res = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($res);


$res = mysql_query($sql) or die(mysql_error());
$sql = "update matches set updateddatetime='" . $row['datetime'] . "' where id=" . $_GET['idMatch'];
echo $sql;

$res = mysql_query($sql) or die(mysql_error());

$sql = "select t.name as local, t2.name as visitor, ua.email as localEmail, ua2.email as visitorEmail, c.image as localLogo, c2.image as visitorLogo, c.name as localClub, c2.name as visitorClub, m.updateddatetime, r.name as round, l.name as league ,  ua2.email as rfrEmail from matches m
join teams t on t.id=m.idlocal
join clubs c on c.id=t.`idClub`
join usersAccounts ua on ua.idclub=c.id
join teams t2 on t2.id=m.idvisitor
join clubs c2 on t2.idclub=c2.id
join usersAccounts ua2 on ua2.idclub=c2.id
join rounds r on r.id=m.idround
join leagues l on l.id=r.idleague
join rfrRefereeLeaguesPerManagerAccount rfr on rfr.idleague=r.idleague
join usersAccounts ua2 on ua2.id=rfr.idManager
where m.id= ".$_GET['idMatch'];

    $res = mysql_query($sql) or die(mysql_error());
    $row1 = mysql_fetch_array($res);
    $datetime = $row1['updateddatetime'];
    $dt = explode(" ", $datetime);
    $date = $dt[0];
    $hTime = $dt[1];
    $d = explode("-", $date);
    $hDate = $d[2] . "-" . $d[1] . "-" . $d[0];
     $r=$row1['rfrEmail'];
    $email = $row1['localEmail'] . ";" . $row1['visitorEmail'].";web@futsal.cat; $r; comite.arbitres@futsal.cat";
    $clubName=$row1['localClub']." i ".$row1['visitorClub'];


    $subject = "Actualitzat horari de  " . $row1['local'] . " - " . $row1['visitor'];
    $out .="<div class=\"section\" style='font-weight:bold;'>Canvis d' horari </div>";
    $out .="<table width=\"100%\">";
    $out .="<tr>";
    $out .="<td width=\"45\"><img src=\"http://www.futsal.cat/webImages/clubsImages/" . $row1['localLogo'] . "\" width=\"40\" /></td>";
    $out .="<td valign=\"top\">El partit <span class=\"title\">" . $row1['local'] . "</span> - <span class=\"title\">" . $row1['visitor'] . "</span> de la jornada " . $row1['round'] . " de " . $row1['league'] . " es jugarà el dia <span style='color:#3b3b3b; text-decoration:underline;'> $hDate a les $hTime h. </span></td>";

    $out .="<td width=\"45\"><img src=\"http://www.futsal.cat/webImages/clubsImages/" . $row1['visitorLogo'] . "\" width=\"40\" /></td>";


    $out .=" </tr>";
    $out .="</table>";
    include ("../mailSender.php");
?>

