<?php

header("Content-Type: text/xml");

$salida = "<rss version=\"0.92\">\n";
$salida .="<channel>\n";
$salida .="\t<title>Federacio Catalana de Futbol Sala</title>\n";
$salida .="\t<link>http://www.futsal.cat</link>\n";
$salida .="\t<description>Federacio Catalana de Futbol Sala</description>\n";
//$salida .="\t<pubDate>Mon, 21 Dic 2009 04:00:00 GMT</pubDate>\n";
$salida .="\t<managingEditor >futsal@futsal.cat (Pau Arjalaguer)</managingEditor>\n";
$salida .="\t<webMaster>pau@arjalaguer.cat (Pau Arjalaguer)</webMaster>\n";
include ("../manteniment/config.php");
include ("../manteniment/funciones.php");
$mysqli=conectar();
$res1 = $mysqli->query("
    SELECT m.id as idMatch,l.id as idLeague, l.name as league, ro.name as round, t1.name as local, t2.name as visitor, r.localResult, r.visitorResult, m.updateddatetime , d.name as division  FROM futsal.results r
join matches m on r.idmatch=m.id 
join rounds ro on ro.id=m.idround
join leagues l on l.id=ro.idleague
join divisions d on d.id=l.iddivision
join teams t1 on t1.id=m.idlocal
join teams t2 on t2.id=m.idvisitor
where updateddatetime!='0000-00-00 00:00:00' and updateddatetime<now()
order by r.id desc limit 0,100");

while ($row = mysqli_fetch_array($res1)) {

    $di = explode(" ", $row['division']);
    $divisionName = $di[0];
    $row['local'] = ucwords(str_replace(" " . strtolower($divisionName), "", strtolower($row['local'])));
    $row['visitor'] = ucwords(str_replace(" " . strtolower($divisionName), "", strtolower($row['visitor'])));

    $salida .= "<item>\n<title> " . stripslashes($row['local']). " " . stripslashes($row['localResult']). " - " . stripslashes($row['visitor']). " " . stripslashes(utf8_encode($row['visitorResult'])) . " /// Jornada " . stripslashes(utf8_encode($row['round'])) . " de " . stripslashes($row['league']) . " de la @futsalcat </title>\n";
    $salida .= "<link>https://www.futsal.cat/competicio/acta/" . $row['idMatch'] . "</link>\n<url>https://www.futsal.cat/competicio/acta/" . $row['idMatch'] . "</url>\n<description>@futsalcat</description>\n<pubDate>".date('r', strtotime($row['updateddatetime']))."</pubDate>\n<guid>http://www.futsal.cat/acta/" . $row['idMatch'] . "</guid></item>\n";
    $conta++;
}


$salida .="</channel>\n</rss>";
echo $salida;
?>