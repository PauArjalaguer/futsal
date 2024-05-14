<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?
$out ="";
//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx=conectar();

//Nom equip
$res = mysql_query("select r.id,r.name,l.name as leagueName from rounds r join leagues l on l.id=r.idLeague where r.id=". $_GET['idRound']) or die(mysql_error());
$row = mysql_fetch_array($res);
$out .= "<h1>Jornada " . $row['name'] . " de ".$row['leagueName']." ".$_GET['idRound']."</h1>";


//Jugadors
$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Partits</h2></div>";
$out .="<div class='contentBoxContent'>";
$out .="<table class='playersTable' cellspacing=0 width=100%><tr><th width=20>&nbsp;</th><th >Equip Local</th><th>Equip visitant</th><th style='text-align:center;'>Marcador</th><th>&nbsp;</th></tr>";
$res = mysql_query("SELECT t1.name as local, t2.name as visitor,localResult, visitorResult, m.id as idMatch, m.statusId, ms.color,t1.id as localId, t2.id as visitorId   from matches m
			left join results r on m.id=r.idMatch
			join teams t1 on t1.id=m.idLocal
			join teams t2 on t2.id=m.idvisitor
			join rounds ro on ro.id=m.idround
			left join matchstatus ms on m.statusid=ms.id where m.idround=".$_GET['idRound']) or die(mysql_error());
$n=1;
while ($row = mysql_fetch_array($res)) {
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    $out .="<tr><td class='zebra$n' ><div style='width:15px; height:15px; border:1px solid #424242; background-color:#".$row['color']."'><td class='zebra$n' >" . $row['local'] . "</td><td class='zebra$n' >" . $row['visitor'] . "</td><td class='zebra$n' style='text-align:center;' >" . $row['localResult'] . " - ".$row['visitorResult']."</td><td class='zebra$n' ><img src='images/pencil.png' class='pointer' onClick='matchEdit(" . $row['idMatch'] . ");' > &nbsp;<img src='images/cross.png' class='pointer' onClick='matchDelete(" . $row['idMatch'] . ");' > &nbsp;</td></tr>";
   

}
$out .= "</table>";
$out .="</div>";
$out .="</div>";
$out .="<div class='contentBoxSpacer'></div>";


echo utf8_encode($out);
mysql_close($idcnx);
?>
