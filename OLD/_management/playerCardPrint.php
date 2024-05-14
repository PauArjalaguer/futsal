<?
$serverUrl = "http://www.futsal.cat/";
include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx=conectar();
//$serverUrl = "http://localhost:8081/futsal2011/";

?>

<script src="http://cufon.shoqolate.com/js/cufon-yui.js" type="text/javascript"></script>
<script src="<? echo $serverUrl; ?>scripts/bebas-neue.cufonfonts.js" type="text/javascript"></script>

<?php
//require_once("dompdf/dompdf_config.inc.php");
//echo $_GET['idTeam'];



$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];


mysql_query("update player_team_season set prints=prints+1 where idPlayer=" . $_GET['idPlayer'] . " and idSeason=$lastSeasonId ");
$sql = "
  select
    p.id
    , birthdate
    ,p.name
    ,p.image
    ,DNI
    ,DNIscan
    ,NIF, Address
    ,AddressNumber
    ,Floor as AddressFloor
    ,Door as AddressDoor
    ,City as AddressCity
    ,Province as AddressProvince
    ,CP
    ,Nationality
    ,CountryOfBirth
    ,CityOfBirth
    ,ProvinceOfBirth
    ,Email as playerEmail
    ,notes as playerNotes
    ,pcw.text as rejectedReason
    ,tis.image as teamImage
    ,t.name as teamName
    ,d.name as divisionName
    ,d.prefix
    ,paymentDate
    ,pp.position
    ,s.name as seasonName

  from players p
    join player_team_season pts on p.id=pts.idplayer
join playerPositions pp on pts.position=pp.id
join seasons s on pts.idseason=s.id
    join teams t on pts.idTeam=t.id
    join teams_divisions_per_season td on t.id=td.idTeam and td.idseason=$lastSeasonId

    join divisions d on d.id=td.idDivision
    left join playerCards_warned pcw on pcw.idCard=pts.id
    left join team_image_season tis on tis.idTeam=pts.idteam and tis.idSeason=$lastSeasonId

  where p.id=" . $_GET['idPlayer']." and t.idClub=".$_COOKIE['idClub']." order by pts.id desc limit 0,1";
//echo $sql;

$res = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($res);

$html = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html>
    <head>
        <style>
            body{font-family:Helvetica; color:#626262;font-size:10px; width: 560px;}
            h1{
                font-size:20px; text-transform: uppercase;}

            table{
           widtH:750px;
                background-image: url('http://www.futsal.cat/maanagement/cardBackground.jpg');
                background-repeat:no-repeat;
                background-position:left top;
                border-collapse: collapse;
                margin:0px;
                padding:0px;

            }
            td{font-size:12px;}
            .td{
                border-bottom:1px solid #969696; font-family:Helvetica; color:#626262;font-size:12px;
            }
            .td1{width:380px; font-weight: bold; text-transform: uppercase; border-left:1px solid #969696; height:35px;}
            .td2{width:200px;}
            .td3{width:180px;font-weight: bold; text-align:center;}
            .td4{width:250px;}
            .td5{width:200px;}
            .tdrightborder{border-right: 1px solid #969696;}
            .tdtopborder{border-top: 1px solid ;}

        </style>
        <title></title>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\">
    </head>
    <body style='width:800px;'>";
$html .="\n\n<table  border=\"0\" cellspacing=\"0\" cellpadding=\"1\" >";
$html .="\n\t<tr>";
$html .="\n\t\t<td colspan=3 id=\"sectionTitle\" style='font-size:25px;'>Federació Catalana de Futbol Sala</td>";
$html .="\n\t\t<td colspan=2 id=\"sectionTitle\" style='font-size:25px;' align=right>" . $row['position'] . "</td>";
$html .="\n\t</tr>";

$imageToMask = "../images/dynamic/playersImages/" . $row['image'];
$html .="\n\t<tr>";
$html .="\n\t\t<td class=\"td td1 tdtopborder tdrightborder\">&nbsp;  NOM:</td>";
$html .="\n\t\t<td class=\"td td2 tdrightborder tdtopborder\">&nbsp; " . ucwords(strtolower($row['name'])) . "</td>";
$html .="\n\t\t<td class=\"td3 tdtopborder tdrightborder\" rowspan=\"6\"> <img  style='padding:10px;width:120px; position:relative; height:180px;' src=\"playerImageMask.php?src=" . $row['image'] . "\" /></td>";
//$html .="\n\t\t<td class=\"td3 tdtopborder tdrightborder\" rowspan=\"6\" valign=top>&nbsp; SIGNATURA I SEGELL CLUB: &nbsp;</td>";
$html .="\n\t\t<td class=\"td td1 tdrightborder tdtopborder\" align=center> &nbsp; Vàlid des de: </td>";
$html .="\n\t</tr>";
$html .="\n\t<tr>";

$html .="\n\t\t<td class=\"td td1 tdtopborder tdrightborder\">&nbsp;  DATA DE NAIXEMENT:</td>";
$b = explode("-", $row['birthdate']);
$birthdate = $b[2] . "-" . $b[1] . "-" . $b[0];

$pa = explode(" ", $row['paymentDate']);
$p = explode("-", $pa[0]);


$date = $p[2] . "-" . $p[1] . "-" . $p[0];

$html .="\n\t\t<td class=\"td td2 tdrightborder tdtopborder\">&nbsp; " . $birthdate . "</td>";
$html .="\n\t\t<td class=\"td td1 tdrightborder\" align=center> &nbsp;$date</td>";
$html .="\n\t</tr>";
$html .="\n\t<tr>";
$html .="\n\t\t<td class=\"td td1 tdrightborder\">&nbsp;  ADREÇA: </td>";
$html .="\n\t\t<td class=\"td tdrightborder tdtopborder\"> &nbsp; " . ucwords(strtolower($row['Address'])) . ", " . $row['AddressNumber'] . " " . $row['AddressFloor'] . " " . $row['AddressDoor'] . "</td>";

$html .="\n\t\t<td class=\"td td1 tdrightborder\" align=center rowspan=4>";
$html .="\n\t\t\t<img src='http://www.futsal.cat/webImages/LOGO.png' width=100 />";
$html .="\n\t\t</td>";

$html .="\n\t</tr>";
$html .="\n\t<tr>";
$html .="\n\t\t<td class=\"td td1 tdrightborder\">&nbsp;  POBLACIÓ: </td>";
$html .="\n\t\t<td class=\"td tdrightborder\"> &nbsp; " . ucwords(strtolower($row['AddressCity'])) . "</td>";
$html .="\n\t</tr>";
$html .="\n\t<tr>";
$html .="\n\t\t<td class=\"td td1 tdrightborder\">&nbsp; PROVINCIA: </td>";
$html .="\n\t\t<td class=\"td tdrightborder\"> &nbsp; " . $row['CP'] . " " . strtoupper($row['AddressProvince']) . "</td>";
$html .="\n\t</tr>";
$html .="\n\t<tr>";
$html .="\n\t\t<td class=\"td td1 tdrightborder\">&nbsp;  DNI:</td>";
$html .="\n\t\t<td class=\"td tdrightborder\"> &nbsp; " . $row['DNI'] . "-" . $row['NIF'] . "</td>";
$html .="\n\t</tr>";
$html .="\n\t<tr>";
$html .="\n\t\t<td class=\"td td1 tdrightborder\">&nbsp;  EQUIP:</td>";
$html .="\n\t\t<td class=\"td tdrightborder tdtopborder\" colspan=4>&nbsp; <strong style='font-size:18px;'>" . strtoupper($row['teamName']) . "</strong></td>";
//$html .="\n\t\t<td class=\"td tdtopborder tdrightborder\" colspan=2>&nbsp;</td>";
$html .="\n\t</tr>";
$html .="\n\t<tr>";
$html .="\n\t\t<td class=\"td td1 tdrightborder\" rowspan=3>&nbsp;  DNI:</td>";
$html .="\n\t\t<td class=\"td td1 tdrightborder\"  colspan=2 >";
$html .="\n\t\t\t<img  style='padding:10px;' width=320 height=220 src=\"http://www.futsal.cat/images/dynamic/playersImages/" . $row['DNIscan'] . "\" />";
$html .="\n\t\t</td>";
$html .="\n\t\t<td class=\"td3 tdtopborder tdrightborder\" rowspan=\"3\" valign=top>&nbsp; SIGNATURA I SEGELL CLUB: &nbsp;</td>";

//$html .="\n\t\t<td class=\"td td1 tdrightborder\" align=center> &nbsp; Vàlid des de: </td>";
$html .="\n\t</tr>";
$html .="\n\t<tr>";
//$html .="\n\t\t<td class=\"td td1 tdrightborder\" align=center> &nbsp;$date</td>";
$html .="\n\t</tr>";
$html .="\n\t<tr>";
//$html .="\n\t\t<td class=\"td td1 tdrightborder\" align=center>";
//$html .="\n\t\t\t<img src='http://www.futsal.cat/webImages/LOGO.png' width=100 />";
//$html .="\n\t\t</td>";
$html .="\n\t</tr>";
$html .="\n\t<tr>";
$html .="\n\t\t<td class=\"td td1 tdrightborder \">&nbsp;  LLICÈNCIA:</td>";
$html .="\n\t\t<td class=\"td tdrightborder\"> &nbsp;";

$c = strlen($_GET['idPlayer']);
$html .= $row['prefix'];
for ($a = 6;
$a > $c;
$a--) {
$html .="0";
}
$html .= $_GET['idPlayer'];

$html .="\n\t\t</td>";
$html .="\n\t\t<td class=\"td tdtopborder tdrightborder\" colspan=2 align=right > &nbsp;  <strong>" . strtoupper($row['divisionName']) . " TEMP. " . $row['seasonName'] . "&nbsp;</strong></td>";
$html .="\n\t</tr>";
$html .="\n</table>
    </body>
</html>";
//
/*
  $dompdf = new DOMPDF();
  $dompdf->load_html($html);
  $dompdf->render();
  $dompdf->stream("sample.pdf"); */
echo $html;
mysql_close($idcnx);
?>

<script>
    function printAndGetOut(){
        window.print();
        //self.close();
    }

    Cufon.replace('#sectionTitle', { fontFamily: 'Bebas Neue', hover: true });
    Cufon.replace('.charis_sil_bold', { fontFamily: 'Charis SIL Bold', hover: true });
    
    var timeOut=setTimeout("printAndGetOut()",8000);

</script>