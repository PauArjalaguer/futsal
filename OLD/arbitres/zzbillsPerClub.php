<?php

$saldo = "";
$total = "";
$subtotal = "";
$out = "";
$amount = "";
$seasonName = "";
$out .="<style>
    .contentBox{ font-size:10px; font-family:Arial; width:600px;}
     th{font-weight:bold; text-align:left;font-size:10px; padding:3px;  }
     td{ font-size:10px; padding:3px 5px;  border-top:1px solid #000;border-left:1px solid #000; text-transform:uppercase;}
    .tdRight{ border-right:1px solid #000;}
     .tdLeft{ border-left:1px solid #000;}
    .tdBottom{ border-bottom:1px solid #000;}
    .tdTop{ border-top:0px solid #000;}
    .noBorder{border:0px solid;}
    .zeropadding{ padding:0; text-align:left; }
    .bold{font-weight:bold; }
    h4{  padding:0px; margin:0px; font-size:16px; text-align:center;}
    h2{font-size:20px;}

</style>";
//echo $row['idTeam'];


include ("../includes/config.php");
include ("../includes/funciones.php");

conectar ();
$month = 8;
$year = 2012;

//include_once('../includes/phpToPDF.php');


$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];

if($_GET['t']=='visitor'){
    $t="t2";
}else{
    $t="t1";
}

//dades de facturació

$sql = "SELECT c.name, c.address,r.name as round, datetime,d.name as division, t1.name as local, t2.name as visitor, cx.complexName, cx.complexAddress, cbi.name as billing_name, nif,l.name as league
FROM `matches` m
join teams t1 on t1.id=m.idlocal
join teams t2 on t2.id=m.idvisitor
join rounds r on r.id=m.idround
join leagues l on l.id=r.idleague
join divisions d on d.id=l.iddivision
left join complex cx on cx.id=m.place
join clubs c on c.id=".$t.".idclub
left join `club_billing_info` cbi on cbi.idclub=t1.idclub
 WHERE m.id=" . $_GET['idMatch'];
$res = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($res);
$h = explode(" ", $row['datetime']);
$team = $row['local'];
$hour = $h[1];



$out .= "<div class='contentBox'>";

$out .= "<div class='contentBoxHeader'>";
$out .= "<div style='width:20%; float:left;'><img src='http://www.futsal.cat/webImages/logoPetit.png' width=80' /></div>";
$out .= "<div style='width:50%; float:left; text-align:center;'><h4>FEDERACIÓ CATALANA DE FUTBOL SALA</h4><br />CIF: G17102823<br /> APROVADA I INSCRITA PER LA SECRETARIA GRAL. DE L'ESPORT<br />REGISTRE NÚM. 4.604 - 5 MAIG 1986</div>";
$out .= "<div style='width:30%; float:left; text-align:center;'>C/ Rogent, 54 entresòl 2a<br />08026 Barcelona<br />Telf.: 93 244 44 03<br/ >Fax: 93 247 34 83</div>";

$out .="<div style='clear:both; margin-bottom:5px; height:20px;'>&nbsp;</div>";
$out .= "</div>";
$out .= "<div class='contentBoxContent'>";
$out .= "<table class='playersTable' cellspacing=0 cellpadding=3 style='width:100%;' border=0 >";

$out .="<tr><td  class='noBorder zeropadding' colspan=12><h2>Rebut arbitral " . $row['local'] . "-" . $row['visitor'] . "</h2></td></tr>";
$out .="<tr><td  class='noBorder zeropadding'>&nbsp;</td></tr>";
$out .="<tr><td  class='noBorder zeropadding bold'>Nom:</td><td colspan=4 class='noBorder zeropadding'>" . $row['name'] . "</td></tr>";
$out .="<tr><td  class='noBorder zeropadding bold'>Adreça:</td><td colspan=4  class='noBorder zeropadding'>" . $row['address'] . "," . $row['city'] . "</td></tr>";
//$out .="<tr><td  class='noBorder zeropadding bold'>NIF:</td><td colspan=4  class='noBorder zeropadding'>" . $row['nif'] . "</td></tr>";


$out .="<tr><td class='noBorder zeropadding'>&nbsp;</td></tr>";
$out .="<tr><td  class='noBorder zeropadding'>&nbsp;</td><td  class='noBorder zeropadding bold'>Jornada:</td><td class='noBorder zeropadding bold'>DATA</td><td class='noBorder zeropadding bold'>DIVISIÓ</td><td class='noBorder zeropadding'>&nbsp;</td></tr>";
$out .="<tr><td  class='noBorder zeropadding'>&nbsp;</td><td class='noBorder zeropadding'>" . $row['round'] . "</td><td class='noBorder zeropadding'>" . invertdateformat($row['datetime']) . " $hour</td><td class='noBorder zeropadding'>" . $row['league'] . "</td><td class='noBorder zeropadding'>&nbsp;</td></tr>";
$out .="<tr><td  class='noBorder zeropadding'>&nbsp;</td><td class='noBorder zeropadding'>&nbsp;</td></tr>";


$out .="<tr><th width=5% >Quantitat</th><th width=50% colspan=5>Descripció</th><th width=10% >Import</th></tr>";

//consulta drets de competicio
$sql = "select r.name as referee,m.id ,t1.name as local ,t2.name as visitor ,r.name as referee ,r.id as idReferee ,cmr.id as idCmr, cmr.idRefereeType,km, ro.idleague, rprds.price as rPrice, rpmds.price as mPrice, rt.refereeTypeName, d.name as division, allowance, updateddatetime, l.name as league, cupprice
FROM matches m
join teams t1 on t1.id=m.idlocal join teams t2 on t2.id=m.idvisitor
join rounds ro on ro.id=m.idround
join leagues l on l.id=ro.idleague
join divisions d on d.id=l.iddivision
join cmptMatch_Referee cmr on cmr.idMatch=m.id
join rfrReferees r on r.id=cmr.idReferee
join rfrRefereeTypes rt on rt.id=cmr.idRefereeType
left join rfrPricePerRefereeByDivisionAndSeason rprds on rprds.idseason=$lastSeasonId
 and rprds.iddivision=l.iddivision and rprds.idRefereeType=cmr.idRefereeType
left join rfrPricePerMatchbyDivisionAndSeason rpmds on rpmds.idSeason=$lastSeasonId and rpmds.idDivision=l.iddivision
WHERE m.id=" . $_GET['idMatch'];
//echo $sql;
$res1 = mysql_query($sql) or die(mysql_error());

while ($row1 = mysql_fetch_array($res1)) {
    $seasonName = $row1['season'];
    $rowCounter++;
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }

    $date = explode(" ", $row1 ['updateddatetime']);
    $d = invertdateformat($date [0]);
    if (preg_match("/Copa/", $row1['league'])) {
        //echo "COPA";
        $matchPrice = $row1['cupprice'];
    } else {
        $matchPrice = $row1['mPrice'];
    }
    $division = $row1['division'];
    $allowance = $allowance + $row1['allowance'];
    /*   $out .="<tr>";

      $out .= "<td class='zebra$n' align=center >1";

      $out .= "</td>";
      $out .= "<td class='zebra$n' nowrap colspan=5 >";
      //  $out .= $row1['referee'] . " - <strong>" . $row1['refereeTypeName'] . "</strong>";
      $out .="&nbsp;";
      $out .= "</td>";

      $out .= "<td class='tdRight' align=right> ";
      $out .= "0";
      $total = $total + $row1['rPrice'];
      $km = $km + $row1['km'];
      $sum = $sum + $row1['rPrice'] + $row1['km'];
      $out .=" &euro;</td>";



      $out .= "</tr>";

     */

    $subtotal = "";
}
$out .="<tr><td class='zebra$n' align=center >1</td><td class='zebra$n' nowrap colspan=5  >Arbitratge $division</td><td class='tdRight' align=right>$matchPrice</td></tr>";
for ($a = $rowCounter; $a <= 12; $a++) {

    $out .="<tr><td class='zebra$n' align=center >&nbsp;</td><td class='zebra$n' nowrap colspan=5>&nbsp;</td><td class='tdRight' align=right>0 &euro;</td></tr>";
}

$out .="<tr><td class='' align=center>&nbsp;</td><td class='' nowrap colspan=5 class=''>&nbsp;</td><td class='tdRight ' align=right>0 &euro;</td></tr>";


$total = $matchPrice + $allowance;
$out .="<tr><td class='tdBottom' align=center>&nbsp;</td><td class='tdBottom' nowrap colspan=5 class='tdBottom'>Dietes</td><td class='tdRight ' align=right>$allowance &euro;</td></tr>";

$out .="<tr><td colspan=5 class=' noBorder tdTop' style='border-left:0;'>&nbsp;</td><td class=' tdBottom' style='border-top:0;'  align=right>TOTAL</td><td class='tdRight tdBottom'  style='font-weight:bold;' align=right>$total &euro;</td></tr>";


$out .="<tr><td class='zebra$n noBorder' align=center colspan=5>&nbsp;</td></tr>";

$out .="<tr><td class='noBorder'>&nbsp;</td></tr>";
//$out .="<tr><td class='noBorder'>&nbsp;</td><td class='noBorder' align=center style='font-weight:bold; font-size:14px;' colspan=3 >ACTIVITAT EXEMPTA D' IVA SEGONS ARTICLE 20.13 DE LA LLEI 37/92 DE 28 DE DESEMBRE DE 1992</td><td colspan=3 style='font-weight:bold; font-size:24 px; color:#c00; border:0; text-align:center;' align=center>COBRAT</td></tr>";
$out .="</table></div>";
$random = md5(treuAccents($clubName));
$path = $_GET['idMatch'] . "_" . treuAccents($team) . "_" . $month . "_" . $year . "_" . $random;
//phptopdf_html(utf8_encode($out), '../Rebuts/', "$path.pdf");
//$sql = "Insert into admBills (idClub, path, datetime) values ($idClub, '$path',now())";
//echo $sql;
//mysql_query("Insert into admBills (idClub, path, datetime) values ($idClub, '$path',now())");
echo $out;
$saldo = "";
$total = "";
$subtotal = "";
$out = "";

//include("billMailSender.php");
?>