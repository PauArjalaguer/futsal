<?php
$startDate=$_GET['startDate'];
$endDate= $_GET['endDate'];
$expeditionDate=$_GET['expeditionDate'];
$saldo = "";
$total = "";
$subtotal = "";
$out = "";
$amount = "";
$seasonName = "";
$out .="<style>
    .contentBox{ font-size:10px; font-family:Arial;}
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
    h2{font-size:22px;}

</style>";
//echo $row['idTeam'];


include ("../includes/config.php");
include ("../includes/funciones.php");
$idClub = $_GET['idClub'];
conectar ();
$month = 8;
$year = 2012;

include_once('../includes/phpToPDF.php');


$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];
 if(!isset($_GET['billNumber'])){
//numero de factura
$sql = "select
            number
       FROM admBillNumber"
;

$res = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($res);
$billNumber = $row['number'];}else{
    $billNumber=$_GET['billNumber'];
}


//dades de facturaci�
$sql = "select
            c.name
            , c.address
            , c.city
            , c.email
            , clubcode
            , cbi.name as billing_name
            , cbi.address as billing_address
            , cbi.city as billing_city
            , nif from clubs c
        left join  club_billing_info cbi on cbi.idclub=c.id
        where c.id=" . $idClub;

$res = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($res);
if (empty($row['billing_name'])) {
    $name = $row['name'];
} else {
    $name = $row['billing_name'];
}

if (empty($row['billing_address'])) {
    $address = $row['address'];
} else {
    $address = $row['address'];
}
if (empty($row['billing_city'])) {
    $city = $row['city'];
} else {
    $city = $row['city'];
}

$clubName = $row ['name'];
$clubCode = $row['clubcode'];
//$email = $row['email'] . "; web@futsal.cat; futsal@futsal.cat";
$email = "web@futsal.cat; futsal@futsal.cat";



$out .= "<div class='contentBox'>";

$out .= "<div class='contentBoxHeader'>";
$out .= "<div style='width:20%; float:left;'><img src='http://www.futsal.cat/webImages/logoPetit.png' width=80' /></div>";
$out .= "<div style='width:50%; float:left; text-align:center;'><h4>FEDERACI� CATALANA DE FUTBOL SALA</h4><br />CIF: G17102823<br /> APROVADA I INSCRITA PER LA SECRETARIA GRAL. DE L'ESPORT<br />REGISTRE N�M. 4.604 - 5 MAIG 1986</div>";
$out .= "<div style='width:30%; float:left; text-align:center;'>Rambla Guipuscoa 23-25 5� D <br />08018 Barcelona <br />Telf.: 93 244 44 03<br/ >Fax: 93 247 34 83</div>";

$out .="<div style='clear:both; margin-bottom:5px; height:20px;'>&nbsp;</div>";
$out .= "</div>";
$out .= "<div class='contentBoxContent'>";
$out .= "<table class='playersTable' cellspacing=0 cellpadding=3 style='width:100%;' border=0 >";

$out .="<tr><td  class='noBorder zeropadding'><h2>Factura</h2></td></tr>";
$out .="<tr><td  class='noBorder zeropadding'>&nbsp;</td></tr>";
$out .="<tr><td  class='noBorder zeropadding bold'>Nom:</td><td colspan=4 class='noBorder zeropadding'>" . $name . "</td></tr>";
$out .="<tr><td  class='noBorder zeropadding bold'>Domicili:</td><td colspan=4  class='noBorder zeropadding'>" . $address . "," . $city . "</td></tr>";
$out .="<tr><td  class='noBorder zeropadding bold'>Nif:</td><td colspan=4  class='noBorder zeropadding'>" . $row['nif'] . "</td></tr>";
$out .="<tr><td class='noBorder zeropadding'>&nbsp;</td></tr>";
$out .="<tr><td  class='noBorder zeropadding'>&nbsp;</td><td  class='noBorder zeropadding bold'>N� Client:</td><td class='noBorder zeropadding bold'>DATA</td><td class='noBorder zeropadding bold'>N� Factura</td><td class='noBorder zeropadding'>&nbsp;</td></tr>";
$out .="<tr><td  class='noBorder zeropadding'>&nbsp;</td><td class='noBorder zeropadding'>" . $row['clubcode'] . "</td><td class='noBorder zeropadding'>$expeditionDate</td><td class='noBorder zeropadding'>CAT - $billNumber</td><td class='noBorder zeropadding'>&nbsp;</td></tr>";
$out .="<tr><td  class='noBorder zeropadding'>&nbsp;</td><td class='noBorder zeropadding'>&nbsp;</td></tr>";


$out .="<tr><th width=5% >Quantitat</th><th width=50% colspan=4>Descripci�</th><th width=10% >P.Unitari</th><th width=10% >Import</th></tr>";

//consulta drets de competicio
$res1 = mysql_query("
    SELECT t.name, rdst.rate, d.name as division,s.name as season,prefix, adste.rate as newRate
        FROM  `admTeamEntries` ate
        JOIN teams t ON t.id = ate.idteam
        JOIN teams_divisions_per_season td ON td.idteam = t.id and td.idseason=ate.idseason 
        JOIN divisions d ON d.id = td.iddivision
        JOIN rate_division_season_per_team rdst ON rdst.iddivision = td.iddivision  and rdst.idseason=ate.idseason

        JOIN seasons s on td.idseason=s.id
        left join admrate_division_season_per_teams_exceptions adste on adste.idteam=t.id and adste.idseason=td.idseason

    WHERE idclub =" . $idClub . "
        AND td.idseason =$lastSeasonId
        and ate.datetime>='$startDate' and ate.datetime<='$endDate'
       --  AND DATE_FORMAT( DATETIME,  '%m' ) =$month
        -- AND DATE_FORMAT( DATETIME,  '%Y' ) =$year
    ORDER BY ate.DATETIME ASC ") or die(mysql_error());

while ($row1 = mysql_fetch_array($res1)) {
    $seasonName = $row1['season'];
    $rowCounter++;
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    if (isset($row1['newRate'])) {
        $r = $row1['newRate'];
    } else {
        $r = $row1['rate'];
    }
    $date = explode(" ", $row1 ['datetime']);
    $d = invertdateformat($date [0]);
    if ($r != 0) {
        $out .="<tr>";

        $out .= "<td class='zebra$n' align=center >1";

        $out .= "</td>";
        $out .= "<td class='zebra$n' nowrap colspan=4 >";
        $outa .= "Drets de competici� de " . $row1['name'] . " per a " . $row1['division'] . " t" . $seasonName;
        $out .= "Drets de competici� de " . $row1['prefix'] . " - t. " . $seasonName;

        $out .= "</td>";
        $out .= "<td class='zebra$n' align=center>";
        $out .= $r;

        $residu = $residu + $row1 ['amount'];
        $out .= "</td>";
        $out .= "<td class='tdRight' align=right>";
        $out .= $r;
        $total = $total + $r;
        $out .= "&euro;</td>";

        $out .= "</tr>";
    }
}
$subtotal = "";
//consulta fitxes
/* $res1 = mysql_query("
  SELECT COUNT( * ) AS amount, rate, d.name, s.name as season,prefix
  FROM player_team_season pts
  JOIN teams t ON t.id = pts.idteam
  JOIN teams_divisions_per_season td ON td.idteam = t.id
  AND td.idseason =$lastSeasonId
  JOIN divisions d ON d.id = td.iddivision
  JOIN rate_division_season rds ON rds.iddivision = td.iddivision
  AND rds.idseason = pts.idseason
  JOIN seasons s on s.id=td.idseason
  WHERE
  idclub =" . $idClub . "
  AND DATE_FORMAT( paymentdate,  '%m' ) =" . $month . "
  AND DATE_FORMAT( paymentdate,  '%Y' ) =" . $year . "
  GROUP BY d.id");
 */
mysql_query("CREATE TEMPORARY TABLE  `cashingTemp` (
`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`concept` VARCHAR( 255 ) NOT NULL ,
`amount` INT NOT NULL ,
`datetime` DATETIME NOT NULL,
`total` int null,
`division` varchar(10) null,
`rate` int null,
type varchar (255) NULL,
orderBy int null
) ENGINE = MYISAM ;
");

$res1 = mysql_query("SELECT p.name AS playerName,
       t.name AS teamName,
       rds.rate,
       paymentdate,
       d.prefix AS division,
       s.name AS season
, adste.rate as newRate
FROM   player_team_season pts
       JOIN players p
         ON p.id = pts.idplayer
       JOIN teams_divisions_per_season td
         ON td.idteam = pts.idteam
            AND td.idseason = pts.idseason
       JOIN divisions d on d.id=td.iddivision
       JOIN rate_division_season rds
         ON d.id = rds.iddivision
            AND td.idseason = rds.idseason
       JOIN teams t
         ON t.id = pts.idteam
       JOIN seasons s
         ON s.id = pts.idseason
         left join admrate_division_season_exceptions adste on adste.idplayer=p.id and adste.idseason=pts.idseason
WHERE  ispayed = 1 and paymentdate>='$startDate'  and paymentdate<='$endDate'
              AND idclub = " . $idClub . " 
        -- and pts.idseason=$lastSeasonId
        and (adste.rate >0 or adste.rate is null)

       ORDER  BY d.prefix, adste.rate");

while ($row1 = mysql_fetch_array($res1)) {

    $seasonName = $row1['season'];

    if (isset($row1['newRate'])) {
        $r = $row1['newRate'];
        $rebaixada = 1;
    } else {
        $r = $row1['rate'];
        $rebaixada = 0;
    }
    $o = 1;

    if ($ra != $r or $row1['division'] != $prefix) {

        $concept = "Mutualitats de " . $row1['division'];
        if ($rebaixada == 1) {
            // $concept .=" rebaixada a $r &euro;";
        }

        $amount = 1;
        // echo $concept;
        $sql1 = "INSERT INTO cashingTemp (concept,amount,datetime,type, orderBy, division,rate) values ('$concept'," . $amount . ",' now()','-> Mutualitat',$o, '" . $row1['division'] . "',$r)";
        //echo $sql1."<br />";
        mysql_query($sql1) or die(mysql_error());
    } else {

        $sql1 = "UPDATE cashingTemp set amount=amount+1 where rate=$r and division='" . $row1['division'] . "'";
        //echo $sql1."<br />";
        mysql_query($sql1) or die(mysql_error());
    }
    $ra = $r;
    $prefix = $row1['division'];
    $o++;
}

$res3 = mysql_query("select * from cashingTemp");
while ($row3 = mysql_fetch_array($res3)) {
    $date = explode(" ", $row1 ['datetime']);
    $d = invertdateformat($date [0]);

    $out .="<tr>";

    $out .= "<td class='zebra$n' align=center >" . $row3['amount'];

    $out .= "</td>";
    $out .= "<td class='zebra$n' nowrap colspan=4>";
    $out .= $row3['concept'];
    $out .= "</td>";
    $out .= "<td class='zebra$n' align=center>";
    $out .= $row3['rate'];


    $out .= "</td>";
    $out .= "<td class='tdRight' align=right>";
    $subtotal = $row3['rate'] * $row3['amount'];
    $out .= $subtotal;
    $total = $total + $subtotal;
    $out .= "&euro;</td>";

    $out .= "</tr>";
}

$subtotal = "";


$res1 = mysql_query("SELECT concept, amount from rfrTaxes 
    where idClub= " . $idClub . " and datetime>='$startDate' and datetime<='$endDate'");

while ($row1 = mysql_fetch_array($res1)) {
    $rowCounter++;
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
   
        $date = explode(" ", $row1 [0]);
        $d = invertdateformat($date [0]);

        $out .="<tr>";

        $out .= "<td class='zebra$n' align=center >1";


        $out .= "</td>";
        $out .= "<td class='zebra$n' nowrap colspan=4>";
        $out .= $row1['concept'];
        
        $out .= "</td>";
        $out .= "<td class='zebra$n' align=center>";
        $subtotal = $row1['amount'];
        $out .= $row1['amount'];


        $out .= "</td>";
        $out .= "<td class='tdRight' align=right>";

        $out .= $subtotal;
        $total = $total + $subtotal;
        $out .= "&euro;</td>";

        $out .= "</tr>";
    
}

//consulta pilotes

$res1 = mysql_query("SELECT sum(amount) as number, ab.ballprice from admBalls ab
    join admBallPricePerSeason abps on abps.idseason=4 and idClub= " . $idClub. " where  datetime>='$startDate'  and datetime<='$endDate'");

while ($row1 = mysql_fetch_row($res1)) {
    $rowCounter++;
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    if (!empty($row1[0])) {
        $date = explode(" ", $row1 [0]);
        $d = invertdateformat($date [0]);

        $out .="<tr>";

        $out .= "<td class='zebra$n' align=center >" . $row1[0];


        $out .= "</td>";
        $out .= "<td class='zebra$n' nowrap colspan=4>";
        $ouat .= "Pilotes  " . $d;
        $out .=" PILOTES";
        $out .= "</td>";
        $out .= "<td class='zebra$n' align=center>";
        $subtotal = $row1[0] * $row1[1];
        $out .= $row1[1];


        $out .= "</td>";
        $out .= "<td class='tdRight' align=right>";

        $out .= $subtotal;
        $total = $total + $subtotal;
        $out .= "&euro;</td>";

        $out .= "</tr>";
    }
}
for ($a = $rowCounter; $a <= 5; $a++) {

    $out .="<tr><td class='zebra$n' align=center >&nbsp;</td><td class='zebra$n' nowrap colspan=4>&nbsp;</td><td class='zebra$n' align=center>&nbsp;</td><td class='tdRight' align=right>0 &euro;</td></tr>";
}


$out .="<tr><td colspan=3 class=' borderTop ' style='border-left:0;'></td><td colspan=3 class=' borderTop bold ' style='border-left:0;' align=right>Base imposable</td><td class='bold borderTop ' style='border-left:0;' align=right>TOTAL</td></tr>";
$out .="<tr><td colspan=5 class=' noBorder ' style='border-left:0;'>&nbsp;</td><td class=' tdBottom'  align=right>$total &euro;</td><td class='tdRight tdBottom'  style='font-weight:bold;' align=right>$total &euro;</td></tr>";

$out .="<tr><td class='zebra$n noBorder' align=center colspan=5>&nbsp;</td></tr>";
$out .="<tr><td class='bold tdBottom' colspan=6>FORMA DE PAGAMENT</td><td class='bold tdRight tdBottom' colspan=6>IMPORTS</td></tr>";

$prevMonth = $month - 1;
//$res1 = mysql_query("SELECT amount,datetime, code from admClubPayments WHERE idclub =" . $idClub . " AND DATE_FORMAT( datetime,  '%m' ) in (" . $month . ",$prevMonth) AND DATE_FORMAT( datetime,  '%Y' ) =" . $year);
$res1 = mysql_query("select
        code, amount, datetime,paymentType as paymentTypeName
    from admClubPayments cp
        join clubs c on c.id=cp.idClub

LEFT JOIN admClubPaymentTypes acpt on acpt.idPaymentType=cp.idPaymentType
where
    ((cp.datetime>='$startDate' and cp.datetime<='$endDate' and cp.idPaymentType=2)
    or  (cp.datetime>='$startDate' and cp.datetime<='$endDate' and cp.idPaymentType!=2))   and c.id=$idClub");
$amount = 0;
while ($row1 = mysql_fetch_array($res1)) {

    $date = explode(" ", $row1 ['datetime']);
    $d = invertdateformat($date [0]);
    if($row1['code']=="Remanent"){
       $d="Saldo factura anterior";
    }else{
        $d="REBUT. TRANSF ($d)";
    }
    $out .="<tr><td class='noBorder tdLeft' style='border-left:1px solid #000; ' colspan=6>$d</td><td class='noBorder tdLeft tdRight' style='border-left:1px solid #000; border-right:1px solid #000;' colspan=6 align=right>" . $row1['amount'] . " &euro;</td></tr>";
    $amount = $amount + $row1['amount'];
}
$out .="<tr><td class='noBorder tdLeft' style='border-bottom:1px solid #000;border-left:1px solid #000; ' colspan=6>&nbsp;</td><td class=' bold tdLeft tdBottom' style='border-left:1px solid #000; border-right:1px solid #000;' colspan=6 align=right>" . $amount . " &euro;</td></tr>";

$saldo = $amount - $total;
//echo "AMOUNT:$amount - TOTAL $total - SALDO $saldo";
if ($saldo > 0) {
    $out .="<tr><td class='noBorder tdLeft' style='background-color:#fdd;border-bottom:1px solid #000;border-left:1px solid #000; ' colspan=6>Saldo a favor del club. </td><td class=' bold tdLeft tdBottom' style='border-left:1px solid #000;background-color:#fdd; border-right:1px solid #000;' colspan=6 align=right>" . $saldo . " &euro;</td></tr>";
}
$out .="<tr><td class='noBorder'>&nbsp;</td></tr>";
$out .="<tr><td class='noBorder'>&nbsp;</td><td class='noBorder' align=center style='font-weight:bold; font-size:14px;' colspan=3 >ACTIVITAT EXEMPTA D' IVA SEGONS <br />ARTICLE 20.13 DE LA LLEI 37/92 DE <br />28 DE DESEMBRE DE 1992</td><td colspan=3 style='font-weight:bold; font-size:24 px; color:#c00; border:0; text-align:center;' align=center><img src='http://www.futsal.cat/administration/firma.jpg' /></td></tr>";
$out .="</table></div>";
$random = md5(treuAccents($clubName));
$path = $billNumber . "_" . $clubCode . "_" . $month . "_" . $year . "_" . $random;


$sortida = $out;
//$out = "";
if ($_GET['send'] == "ok") {
    phptopdf_html($out, '../factures/', "$path.pdf");
    $out = "";
    $file = "../factures/$path.pdf";
    $filename = basename($file);
    header("Content-type: application/octet-strem");
    header("Content-Transfer-Encoding: binary");
    header("Content-length: " . filesize($file));
    header("Content-Disposition: attachment; filename=$filename");
    readfile($file);

    include("billMailSender.php");
    if(!isset($_GET['billNumber'])){
        mysql_query("update admBillNumber set number=number+1");
    }
    $sql = "Insert into admBills (idClub, path, datetime) values ($idClub, '$path',now())";
//echo $sql;
    mysql_query("Insert into admBills (idClub, path, datetime) values ($idClub, '$path',now())");
}
$saldo = "";
$total = "";
$subtotal = "";
$out = "";
echo $sortida;
?>