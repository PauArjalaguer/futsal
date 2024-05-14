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
//if (date("H") == 8 or date("H") == 12 or date("H") == 16 or date("H") == 20  ) {
    $res1 = $mysqli->query("
    SELECT m.id as idMatch, l.id as idLeague, l.name as league, ro.name as round, t1.name as local, t2.name as visitor, m.updateddatetime ,TIMESTAMPDIFF(HOUR, updateddatetime, now()), d.name as division,ro.id as idRound FROM  matches m 
join rounds ro on ro.id=m.idround
join leagues l on l.id=ro.idleague
join divisions d on d.id=l.iddivision
join teams t1 on t1.id=m.idlocal
join teams t2 on t2.id=m.idvisitor
where updateddatetime>now()  
and ABS(TIMESTAMPDIFF(HOUR, updateddatetime, now())) <3 -- and datediff(updateddatetime,now())<=3
order by updateddatetime desc limit 0,1500");

    while ($row = mysqli_fetch_array($res1)) {
        $d = strtotime($row['updateddatetime']);
        $da = explode(" ", $row['updateddatetime']);
        
   
       
        $hour = $da[1];
        $hour = substr($hour, 0, -3);
        $dd = explode("-", $da[0]);
        $date = $hour." ".$dd[2] . "-" . $dd[1];
        $date =$hour;
        $di=explode(" ",$row['division']);
        $divisionName=$di[0];
        $row['local']=ucwords(str_replace(" ".strtolower($divisionName),"",strtolower($row['local'])));
        $row['visitor']=ucwords(str_replace(" ".strtolower($divisionName),"",strtolower($row['visitor'])));
        $salida .= "<item>\n<title> " . stripslashes($row['local']) . " - " . stripslashes($row['visitor']) . " " . stripslashes(utf8_encode($row['visitorResult'])) . " / " . stripslashes($row['league']) . " Jornada " . stripslashes(utf8_encode($row['round'])) . " / " . $date . "</title>\n";
        $guidDate=str_replace(":","",$row['updateddatetime']);
        $guidDate=str_replace("-","",$guidDate);
        $guidDate=str_replace(" ","",$guidDate);
        $salida .= "<link>http://www.futsal.cat/divisio/" . $row['idLeague'] . "/".$row['idRound']."</link>\n<description>@futsalcat</description>\n<pubDate>" . date("D", $d) . "," . date("d", $d) . " " . date("M", $d) . " " . date("Y", $d) . "  ".date("H", $d).":".date("i", $d).":00 +0100</pubDate>\n<guid>http://www.futsal.cat/divisio/" . $row['idLeague'] . "/".$row['idRound']."/".$row['idMatch']."</guid></item>\n";
        $conta++;
    }
//}

$salida .="</channel>\n</rss>";
echo $salida;
?>