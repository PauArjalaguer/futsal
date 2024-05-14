<?php

$date = $_GET['date'];
$d = str_replace("-", "", $date);

Header("Content-type: application/vnd.ms-word");
Header("Content-Disposition: filename=Rebuts$d.doc");
$fp = fopen("../Rebuts/Rebuts$d.doc", "w");

include ("../includes/config.php");
include ("../includes/funciones.php");
$mes=array(null,"Gener","Febrer","Març","Abril","Maig","Juny","Juliol","Agost","Setembre","Octubre","Novembre","Desembre");
conectar();
$out = "";
$date = $_GET['date'];
//$res = mysql_query("Select l.name from rounds r join leagues l on r.idleague=l.id join matches m on m.idround=r.id where initialdate='2010-10-23' or enddate='2010-10-23'") or die(mysql_error());
$sql = "select c.name as club, c.city, t1.name as local, t2.name as visitor, datetime, l.name as league, prefix, complexname, ro.enddate from matches m
     
       join teams t1 on t1.id=m.idlocal
       join teams t2 on t2.id=m.idvisitor         
       join clubs c on c.id=t1.idclub      
       join rounds ro on ro.id=m.idround      
       join leagues l on l.id=ro.idleague
       join divisions d on d.id=l.iddivision           
       left join complex cx on cx.id=m. place
where enddate='$date'
order by idleague";

//echo $sql . "<br /><br />";
$res = mysql_query($sql);
$idLeague = "";
$idMatch = "";
while ($row = mysql_fetch_array($res)) {
$out .="<table border=0 cellpadding=6 cellspacing=0 width=600 style='font-family:Calibri,Verdana; font-size:12px; border:1px solid #242424;'>";
$out .="<tr>";
$out .="<td ><img src='http://www.futsal.cat/admin/images/logo.png' ></td>";
$out .="<td  colspan=2>DELEGACIÓ DE BARCELONA<br />C/Guipuscoa 23-25 5è D <br /> 08018 Barcelona <br />Tel: 932444403 – Fax: 932473483</td>";
$out .="</tr>";
$out .="<tr>";
$out .="<td style='border-top:1px solid #242424;'>REBUT Nº x</td>";
$out .="<td style='border-top:1px solid #242424;'>LLOC DE LLIURAMENT: ".$row['city']."</td>";
if ($row['prefix'] == "DH") {
    $price= 165;
} elseif ($row['prefix'] == "DT") {
   $price= 68;
} elseif ($row['prefix'] == "DF") {
     $price= 38;
} elseif ($row['prefix'] == "DJ") {
     $price= 38;
}
$out .="<td style='border-top:1px solid #242424;'>EUROS : $price €</td>";
$out .="</tr>";
$out .="<tr>";

$d=explode("-",$row['enddate']);
$m=abs($d[1]);
$date= $d[2]." de ".$mes[$m]." de ".$d[0];
$out .="<td style='border-top:1px solid #242424;' colspan=2>DATA DE LLIURAMENT: $date . </td>";

$h=explode(" ",$row['datetime']);
$out .="<td style='border-top:1px solid #242424;' colspan=0>HORA: ".$h[3]."</td>";
$out .="</tr>";

$out .="<tr>";
$out .="<td style='border-top:1px solid #242424;' colspan=3>CATEGORIA: ".$row['league']."<br />";
$out .="PARTIT : ".$row['local']."-".$row['visitor']."<br />";
$out .="ADREÇA :".$row['complexname']."</td>";
$out ."</tr>";

$out .="<tr>";
$out .="<td style='border-top:1px solid #242424;'>CLUB: ".$row['club']."</td>";
$out .="<td style='border-top:1px solid #242424;' colspan=2>FEDERACIÓ CATALANA DE FUTBOL SALA</td>";
$out .="</tr>";


$out .="</table><br />";



    }





fwrite($fp, $out);
fclose($fp);

echo $out;
?>
