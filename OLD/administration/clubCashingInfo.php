<?php
$initDate='2016-06-01';
header("Cache-Control: no-store, no-cache, must-revalidate");

?>
<?php

//echo $_GET['idTeam'];
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar ();
/*
mysql_query("select p.name, dni, nif, city, province,birthdate, YEAR(CURDATE())-YEAR(birthdate)  as edat,  t.name, d.name,  rds.rate,
CASE WHEN adse.rate is null THEN rds.rate
        
         ELSE adse.rate END AS payed
from players p
join player_team_season pts on pts.idplayer=p.id
join teams t on t.id=pts.idteam
join teams_divisions_per_season tds on tds.idteam=t.id and tds.idseason=pts.idseason
join divisions d on d.id=tds.iddivision
join rate_division_season rds on rds.iddivision=tds.iddivision and rds.idseason=pts.idseason
left join  `admrate_division_season_exceptions` adse on adse.idplayer=t.id and adse.idseason=pts.idseason

order by d.id, t.name, p.name ");
mysql_query("select p.name, dni, nif, city, province,birthdate, YEAR(CURDATE())-YEAR(birthdate)  as edat,  t.name, d.name,  rds.rate,
CASE WHEN adse.rate is null THEN rds.rate
        
         ELSE adse.rate END AS payed
from players p
join player_team_season pts on pts.idplayer=p.id
join teams t on t.id=pts.idteam
join teams_divisions_per_season tds on tds.idteam=t.id and tds.idseason=pts.idseason
join divisions d on d.id=tds.iddivision
join rate_division_season rds on rds.iddivision=tds.iddivision and rds.idseason=pts.idseason
left join  `admrate_division_season_exceptions` adse on adse.idplayer=t.id and adse.idseason=pts.idseason

order by d.id, t.name, p.name ");
 
 */
$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];
//echo $lastSeasonId;
$n=1;
mysql_query("CREATE TEMPORARY TABLE  `cashingTemp` (
`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`concept` VARCHAR( 255 ) NOT NULL ,
`amount` float NOT NULL ,
`datetime` DATETIME NOT NULL,
`total` float null,
type varchar (255) NULL,
orderBy int null
) ENGINE = MYISAM ;
") or die(mysql_error());

$sql = "
    select
        name from clubs c
 where c.id=" . $_GET ['idClub'];

$res = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($res);
$clubName = $row ['name'];

$sql = "
    select
        code, amount, datetime,paymentType as paymentTypeName
    from admClubPayments cp
        join clubs c on c.id=cp.idClub

LEFT JOIN admClubPaymentTypes acpt on acpt.idPaymentType=cp.idPaymentType
 where archived= 0 and c.id=" . $_GET ['idClub'];
//echo "SQL1=".$sql."<br /><br /><br />";
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($res)) {
    $sql1 = "INSERT INTO cashingTemp (concept,amount,datetime,type, orderBy) values ('" . $row ['code'] . "'," . $row ['amount'] . ",'" . $row ['datetime'] . "','-> " . $row['paymentTypeName'] . "',$n)";
    //echo $sql1;
    mysql_query($sql1) or die(mysql_error());
    $n++;
}

$res1 = mysql_query("SELECT concept, amount,datetime from rfrTaxes
 where datetime>'$initDate' and idClub= " . $_GET ['idClub']);

while ($row1 = mysql_fetch_array($res1)) {
       $sql1 = "INSERT INTO cashingTemp (concept,amount,datetime,type, orderBy) values ('" . $row1['concept'] . "', -" . $row1['amount'] . ",'" . $row1['datetime'] . "','4',$n)";
    //echo $sql1;
    mysql_query($sql1) or die(mysql_error());
    $n++;
}

$res1 = mysql_query("select t1.name as local, t2.name as visitor, price, updateddatetime from matches m
join teams t1 on t1.id=m.idlocal
join teams t2 on t2.id=m.idvisitor
join rounds r on r.id=m.idround
join leagues l on l.id=r.idleague
join rfrPricePerMatchbyDivisionAndSeason p on p.idDivision=l.idDivision and p.idSeason=r.idSeason
where statusId=4 and r.idseason=".$lastSeasonId." and t1.idclub=".$_GET['idClub']);


while ($row1 = mysql_fetch_array($res1)) {
	$concept=" Arbitratge ".$row1['local']. " - ".$row1['visitor'];
       $sql1 = "INSERT INTO cashingTemp (concept,amount,datetime,type, orderBy) values ('" . $concept . "', -" . $row1['price'] . ",'" . $row1['updateddatetime'] . "','4',$n)";
    //echo $sql1;
    mysql_query($sql1) or die(mysql_error());
    $n++;
}
$sql = "SELECT p.id as idPlayer, p.name AS playerName,
       t.name AS teamName, t.id as teamId,
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
WHERE  ispayed = 1 and paymentDate>'$initDate'
       
       AND idclub = " . $_GET['idClub'] . "
       
ORDER  BY pts.id DESC 
";
//echo "SQL2=".$sql."<br /><br /><br />";
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($res)) {
    $p = explode(" ", $row['playerName']);
    $playerName = $p[0] . " " . $p[1] . " " . $pa[2];
    $concept = " Fitxa ".$row['idPlayer']."-".$row['teamId']." " . $playerName . " (" . $row ['division'] . " " . $row['season'] . ") ";
 $r="";
    if (isset($row['newRate'])) {
        $r = $row['newRate'];
    } else {
        $r = $row['rate'];
    }
    $sql1 = "INSERT INTO cashingTemp (concept,amount,datetime,type,orderBy) values ('" . addslashes($concept) . "',-" . $r . ",'" . $row ['paymentdate'] . "','Mutualitat',$n)";
    //echo "SQL3=".$sql1."<br /><br /><br />";
    mysql_query($sql1) or die(mysql_error());
    $n++;
}

$sql = "
SELECT amount, datetime, (amount*ballprice) as totalPrice, ballprice, price  FROM `admBalls` aB
join admBallPricePerSeason aBP on aBP.idSeason=8 where datetime>'$initDate' and idClub=" . $_GET['idClub'] . " order by id desc";

//echo "SQL2=".$sql."<br /><br /><br />";
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($res)) {

    $concept = " Compra de  " . $row ['amount'] . " pilotes";

     if($row['ballprice']!=$row['price']){
        $concept .=" (promo copa) ";
      
    }
    $sql1 = "INSERT INTO cashingTemp (concept,amount,datetime, type,orderBy) values ('" . addslashes($concept) . "',-" . $row ['totalPrice'] . ",'" . $row ['datetime'] . "','Pilotes',$n)";
    //echo "SQL3=".$sql1."<br /><br /><br />";

    mysql_query($sql1) or die(mysql_error());
$n++;}
$sql = "
SELECT t.name, ate.datetime, rdst.rate, adste.rate as newRate
FROM admTeamEntries ate
JOIN teams t ON t.id = ate.idteam
LEFT JOIN teams_divisions_per_season td ON td.idteam = t.id
 AND td.idseason =ate.idseason

LEFT JOIN rate_division_season_per_team rdst ON rdst.iddivision = td.iddivision AND rdst.idseason =td.idseason
left join admrate_division_season_per_teams_exceptions adste on adste.idteam=t.id and adste.idseason=td.idseason

WHERE ate.datetime>'$initDate' and idClub =" . $_GET['idClub'];

//echo "SQL2=".$sql."<br /><br /><br />";
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($res)) {
    if (isset($row['newRate'])) {
        $r = $row['newRate'];
    } else {
        $r = $row['rate'];
    }
    $r=0+$r;
    $concept = " Drets de competici� de " . $row ['name'] . ".";

    $sql1 = "INSERT INTO cashingTemp (concept,amount,datetime, type,orderBy) values ('" . addslashes($concept) . "',-" . $r . ",'" . $row ['datetime'] . "','Drets de comp.',$n)";
    //$sql1 = "INSERT INTO cashingTemp (concept,amount,datetime, type) values ('" . addslashes($concept) . "',-" . $row ['rate'] . ",'" . $row ['datetime'] . "','Drets')";
    //echo "SQL3=".$sql1."<br /><br /><br />";
    mysql_query($sql1) or die(mysql_error());
    $n++;
}
$res1 = mysql_query("SELECT id,concept,amount,datetime, date_format(datetime,'%m') as month,date_format(datetime,'%y') as year FROM cashingTemp order by datetime asc, orderBy desc") or die(mysql_error());

while ($row1 = mysql_fetch_array($res1)) {
    $total = $row1['amount'] + $total;
    mysql_query("Update cashingTemp set total=$total where id=" . $row1['id']);
}

$out .= "<div class='contentBox'>";

$out .= "<div class='contentBoxHeader'>";
$out .= "<div style='width:50%; float:left;'><h2>".$_GET ['idClub']. " " . $clubName . "</h2></div>";
$out .= "<div style='width:50%; float:left; text-align:right;'><img class='pointer' onClick='clubCashingInfo(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/administration/images/euro.png' /> <img class='pointer' onClick='clubBallsBuyingForm(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/webImages/soccer.png' /> <img class='pointer' onClick='clubTeamRegistrationForm(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/webImages/page_edit.png' /fi></div><div style='clear:both;'></div>";
$out .= "</div>";
$out .= "<div class='contentBoxContent'>";
$out .= "<table class='playersTable' cellspacing=0 style='width:100%;' ><tr><th width=10% >Data</th><th width=10%>Concepte</th><th >Valor</th><th >Tipus</th><th >Restant</th></tr>";
if ($_COOKIE['userName'] != "Imma") {
    $out .= "<tr>";
    $out .= "<td class='zebra$n' style='border-top:1px solid #242424;'><input class='playerCardEditInputSmall' type='text' id='paymentDate' style='width:90px' value=\"" . date('d-m-Y') . "\"></td>";
    $out .= "<td class='zebra$n' style='border-top:1px solid #242424;'>";
    $out .="<input class='playerCardEditInputSmall' type='text' id='paymentConcept' style='width:300px'>";
    $out .="<select id=\"admClubPaymentConcepts\" class='playerCardEditInputSmall' onChange='admClubPaymentConcepts();'><option></option>";
    $res = mysql_query("select concept from admClubPaymentConcepts");
    while ($r = mysql_fetch_array($res)) {
        $out .= "<option value=\"" . $r['concept'] . "\" class='playerCardEditInputSmall'>" . $r['concept'] . "</option>";
    }

    $out .="</select></td>";
    $out .= "<td style='border-top:1px solid #242424;' class='zebra$n'><input class='playerCardEditInputSmall' type='text' id='paymentAmount' style='width:50px'></td>";

    $out .= "<td style='border-top:1px solid #242424;' class='zebra$n'>";
    $out .="<select id=\"paymentType\" class='playerCardEditInputSmall'>";
    $res = mysql_query("select idPaymentType, paymentType from admClubPaymentTypes");
    while ($r = mysql_fetch_array($res)) {
        $out .= "<option value=\"" . $r['idPaymentType'] . "\" class='playerCardEditInputSmall'>" . $r['paymentType'] . "</option>";
    }

    $out .="</select></td>";
    $out .= "<td style='border-top:1px solid #242424;' class='zebra$n'><input type='button' value='Guardar' class='newPlayerNameButton' onClick='clubPaymentInsert(" . $_GET ['idClub'] . ")'></td></tr>";
}
$res1 = mysql_query("SELECT id,concept,amount,datetime, date_format(datetime,'%m') as month,date_format(datetime,'%y') as year,total, type FROM cashingTemp order by datetime desc") or die(mysql_error());

while ($row1 = mysql_fetch_array($res1)) {
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    $date = explode(" ", $row1 ['datetime']);
    $d = invertdateformat($date [0]);
    if ($m != $row1['month']) {
        $out .= "<tr name='" . $row1['month'] . $row1['year'] . "'>";
    } else {
        $out .="<tr>";
    }
    $out .= "<td class='zebra$n' >";
    $out .= trim($d);
    $out .= "</td>";
    $out .= "<td class='zebra$n' nowrap >";
    $out .= $row1 ['concept'];
    $out .= "</td>";
    $out .= "<td class='zebra$n' align=right>";
    $out .= $row1 ['amount'];

    $residu = $residu + $row1 ['amount'];
    $out .= "</td>";
    $out .= "<td class='zebra$n'>";
    $out .= $row1['type'];

    $out .= "</td>";
    $out .= "<td class='zebra$n'>";
    $out .= $row1['total'];

    $out .= "</td>";

    $out .= "</tr>";
    $m = $row1['month'];
}
if ($n == 1) {
    $n = 2;
} else {
    $n = 1;
}
$oaut .= "<tr>";
$oaut .= "<td class='zebra$n' style='border-top:1px solid #242424;'><input class='playerCardEditInput' type='text' id='paymentDate2' style='width:100px' value=\"" . date('d-m-Y') . "\"></td>";
$oaut .= "<td class='zebra$n' style='border-top:1px solid #242424;'><input class='playerCardEditInput' type='text' id='paymentConcept2' style='width:100px'></td>";
$oaut .= "<td style='border-top:1px solid #242424;' class='zebra$n'><input class='playerCardEditInput' type='text' id='paymentAmount2' style='width:100px'></td>";
$oaut .= "<td style='border-top:1px solid #242424;' class='zebra$n'><input type='button' value='Guardar' class='newPlayerNameButton' onClick='clubPaymentInsert(" . $_GET ['idClub'] . ")'></td>";
$out .="</tr></table>";


$out .= "<div style='margin-top:10px; background-color:#efefef; padding:10px; border:1px solid #ededed;'><img class='pointer' onClick='clubCashingInfo(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/administration/images/euro.png' /> <img class='pointer' onClick='clubBallsBuyingForm(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/webImages/soccer.png' /> <img class='pointer' onClick='clubTeamRegistrationForm(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/webImages/page_edit.png' /fi></div><div style='clear:both;'></div>";
$out .= "</div>";
$out .= "</div>";


echo utf8_encode($out);
?>
