<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx = conectar();
$idMatch = intval($_POST['idMatch']);


$sql1 = "select t.name as visitor, t2.name as local,c.name, c2.image, ua.email, c2.name as localClub, r.name as round, m.datetime,  ua2.email as rfrEmail from matches m
join teams t on t.id=m.idvisitor
join clubs c on c.id=t.idClub
join usersAccounts ua on ua.idclub=c.id
join teams t2 on t2.id=m.idlocal
join clubs c2 on c2.id=t2.idclub
join rounds r on r.id=m.idround
join rfrRefereeLeaguesPerManagerAccount rfr on rfr.idleague=r.idleague
join usersAccounts ua2 on ua2.id=rfr.idManager
where m.id=$idMatch";
//echo $sql1;
$res1 = mysql_query($sql1) or die(mysql_error());
$row1 = mysql_fetch_array($res1);

$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];

//FORMATEJA HORA QUE ENVIEM
$date = $_POST['date'];
$time = $dt[1];
$d = explode("-", $date);
$date = $d[2] . "-" . $d[1] . "-" . $d[0];
$dt = $date . " " . $_POST['time'];
$dat=$dt."-";
//echo $row1['datetime']." ". $dt;
if ($row1['datetime'] != $dat) {

    $sql = "INSERT INTO cmptMatchDateChange (idTeam, idMatch, comment,datetime,approved, insertDatetime) values (" . $_POST['idTeam'] . "," . $_POST['idMatch'] . ",'" . utf8_decode($_POST['comment']) . "','$dt',1,now())";
//echo $sql;
    mysql_query($sql) or die(mysql_error());

    $sql = "update matches set datetime='$dt', updateddatetime='$dt' where id=$idMatch";
    mysql_query($sql);
    $mdc = mysql_insert_id();

//FORMATEJA HORA ORIGINAL
    $datetime = $row1['datetime'];
    $dt = explode(" ", $datetime);
    $date = $dt[0];
    $hTime = $dt[1];
    $d = explode("-", $date);
    $hDate = $d[2] . "-" . $d[1] . "-" . $d[0];
    $e = $row1['email'];
    $r=$row1['rfrEmail'];
    $email = $row1['email'] . "; $r; comite.arbitres@futsal.cat";
    //$email='pau@arjalaguer.cat';
    $clubName = $row1['name'];

    $subject = "Notificació de canvi d' horari " . $row1['local'] . " - " . $row1['visitor'];
    $out .="<div class=\"section\" style='font-weight:bold;'>Canvis d' horari </div>";
    $out .="<table width=\"100%\">";
    $out .="<tr>";
    $out .="<td width=\"45\"><img src=\"http://www.futsal.cat/webImages/clubsImages/" . $row1['image'] . "\" width=\"40\" /></td>";
    $out .="<td valign=\"top\"><span class=\"title\">" . $row1['local'] . "</span>,<br /> ha canviat l' horari del partit " . $row1['local'] . " - " . $row1['visitor'] . " de la jornada " . $row1['round'] . " del dia <span style='color:#3b3b3b; text-decoration:underline;'> $hDate a les $hTime h.</span> a <span style='color:#3b3b3b; text-decoration:underline;'>" . $_POST['date'] . " a les " . $_POST['time'] . "h. </span>.</td>";
    $arbitre = 1;
    if (!empty($_POST['comment'])) {
        $out .="</tr><tr><td>&nbsp;</td></tr><tr><td colspan=\"2\" style='border:1px solid #ddd; background-color:#eee; padding:10px;'>" . utf8_decode($_POST['comment']) . "</td>";
    }
    //$out .="<tr><td colspan=2 align=center><a href=\"http://www.futsal.cat/management/cmptMatchDateChangeAcceptFromEmail.php?mdc=$mdc&string=" . md5($e) . "&idMatch=" . $_POST['idMatch'] . "&email=" . $e . "\"> Acceptar</a>  <a href=\"http://www.futsal.cat/management/cmptMatchDateChangeDenyFromEmail.php?mdc=$mdc&string=" . md5($e) . "&idMatch=" . $_POST['idMatch'] . "&email=" . $e . "\"> Rebutjar</a></td></tr>";
    $out .=" </tr>";
    $out .="</table>";
    include ("../mailSender.php");
} else {
    echo "No es pot introduir la mateixa hora.";
}
?>

