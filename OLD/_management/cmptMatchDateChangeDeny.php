<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx = conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];


echo $_GET['idTeam'] . " " . $_GET['idMatch'];
$sql = "update cmptMatchDateChange set denied=1 where id=" . $_GET['id'];
//echo $sql;

$res = mysql_query($sql) or die(mysql_error());
$idMatch = $_GET['idMatch'];
$sql1 = "select t.name as local, t2.name as visitor,c.name as localClub,c2.name as visitorClub, c.image as localImage, c2.image as visitorImage, ua.email as localEmail, ua2.email as visitorEmail,  r.name as round, m.datetime, mdc.datetime as newDate, l.name as league,  ua3.email as rfrEmail from matches m
join teams t on t.id=m.idlocal
join clubs c on c.id=t.idClub
join usersAccounts ua on ua.idclub=c.id
join teams t2 on t2.id=m.idvisitor
join clubs c2 on c2.id=t2.idclub
join usersAccounts ua2 on ua2.idclub=c2.id
join rounds r on r.id=m.idround
join leagues l on l.id=r.idleague

join cmptMatchDateChange mdc on mdc.idmatch=m.id and mdc.id=" . $_GET['id'] . "
join rfrRefereeLeaguesPerManagerAccount rfr on rfr.idleague=r.idleague
join usersAccounts ua3 on ua3.id=rfr.idManager
where m.id=$idMatch";
echo $sql;

$res1 = mysql_query($sql1) or die(mysql_error());
$row1 = mysql_fetch_array($res1);
$clubName = $row1['localClub'] . " i " . $row1['visitorClub'];
 $r=$row1['rfrEmail'];
$email = $row1['localEmail'] . ";" . $row1['visitorEmail'] . ";web@futsal.cat; $r; comite.arbitres@futsal.cat";
$datetime = $row1['newDate'];
$dt = explode(" ", $datetime);
$date = $dt[0];
$hTime = $dt[1];
$d = explode("-", $date);
$hDate = $d[2] . "-" . $d[1] . "-" . $d[0];
$subject = "Sol.licitut de canvi d' horari " . $row1['local'] . " - " . $row1['visitor'] . " rebutjada.";
$subject = $row1['visitor']." ha rebutjat la sol.licitut de canvi d' horari " . $row1['local'] . " - " . $row1['visitor'] . ".";
    
$out .="<div class=\"section\" style='font-weight:bold;'>Canvis d' horari </div>";
$out .="<table width=\"100%\">";
$out .="<tr>";
$out .="<td width=\"45\"><img src=\"http://www.futsal.cat/webImages/clubsImages/" . $row1['visitorImage'] . "\" width=\"40\" /></td>";
$out .="<td valign=\"top\"><span class=\"title\">" . $row1['visitor'] . "</span>,<br /> ha rebutjat canviar l' horari del partit " . $row1['local'] . " - " . $row1['visitor'] . " de la jornada " . $row1['round'] . " del dia <span style='color:#3b3b3b; text-decoration:underline;'> $hDate a les $hTime h.</span></td>";

$out .=" </tr>";
$out .="</table>";
include ("../mailSender.php");
?>

