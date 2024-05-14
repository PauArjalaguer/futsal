<?
header('Content-type: application/vnd.ms-excel');
    header("Content-Disposition: attachment; filename=Extracte:".$_GET['idClub'].".xls");
    header("Pragma: no-cache");
    header("Expires: 0"); 
 include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
echo "<table>";
  if (!$_GET['startDate']) {
            $_GET['startDate'] = '01-01-2016';
 $d = explode("-", $_GET['startDate']);
  $_GET['startDate'] = $d[2] . "-" . $d[1] . "-" . $d[0];
        }
        if (!$_GET['endDate']) {
            $_GET['endDate'] = date("d-m-Y");
 $d = explode("-", $_GET['endDate']);
 $_GET['endDate'] = $d[2] . "-" . $d[1] . "-" . $d[0];
        } 
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
$n = 1;

if ($_GET['startDate'] and $_GET['endDate']) {
    $where = "and datetime>='" . $_GET['startDate'] . " 00:00:00' and datetime<='" . $_GET['endDate'] . " 23:59:00' ";
    $where2 = "and updateddatetime>='" . $_GET['startDate'] . " 00:00:00' and updateddatetime<='" . $_GET['endDate'] . " 23:59:00' ";
    $where3 = "and paymentdate>='" . $_GET['startDate'] . " 00:00:00' and paymentdate<='" . $_GET['endDate'] . " 23:59:00' ";
    $where4 = "and ate.datetime>='" . $_GET['startDate'] . " 00:00:00' and ate.datetime<='" . $_GET['endDate'] . " 23:59:00' ";
}
$sql = "
    select
        code, amount, datetime,paymentType as paymentTypeName
    from admClubPayments cp
        join clubs c on c.id=cp.idClub
LEFT JOIN admClubPaymentTypes acpt on acpt.idPaymentType=cp.idPaymentType
 where  c.id=" . $_GET ['idClub'] . " $where ";
//echo "SQL1=" . $sql . "<br /><br /><br />";
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($res)) {
    $sql1 = "INSERT INTO cashingTemp (concept,amount,datetime,type, orderBy) values ('" . $row ['code'] . "'," . $row ['amount'] . ",'" . $row ['datetime'] . "','-> " . $row['paymentTypeName'] . "',$n)";
    //echo $sql1."<br />";
    mysql_query($sql1) or die(mysql_error());
    $n++;
}

$res1 = mysql_query("select t1.name as local, t2.name as visitor, price, updateddatetime from matches m
join teams t1 on t1.id=m.idlocal
join teams t2 on t2.id=m.idvisitor
join rounds r on r.id=m.idround
join leagues l on l.id=r.idleague
join rfrPricePerMatchbyDivisionAndSeason p on p.idDivision=l.idDivision and p.idSeason=r.idSeason
where statusId=4 and t1.idclub=" . $_GET['idClub'] . " $where2  ");


while ($row1 = mysql_fetch_array($res1)) {
    $concept = " Arbitratge " . $row1['local'] . " - " . $row1['visitor'];
    $sql1 = "INSERT INTO cashingTemp (concept,amount,datetime,type, orderBy) values ('" . addslashes($concept) . "', -" . $row1['price'] . ",'" . $row1['updateddatetime'] . "','4',$n)";
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
WHERE  ispayed = 1 
       
       AND idclub = " . $_GET['idClub'] . " $where3
       
ORDER  BY pts.id DESC 
";
//echo "SQL2=".$sql."<br /><br /><br />";
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($res)) {
    $p = explode(" ", $row['playerName']);
    $playerName = $p[0] . " " . $p[1] . " " . $pa[2];
    $concept = " Fitxa " . $row['idPlayer'] . "-" . $row['teamId'] . " " . $playerName . " (" . $row ['division'] . " " . $row['season'] . ") ";
    $r = "";
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
join admBallPricePerSeason aBP on aBP.idSeason=8 where  idClub=" . $_GET['idClub'] . " $where order by id desc";

//echo "SQL2=".$sql."<br /><br /><br />";
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($res)) {

    $concept = " Compra de  " . $row ['amount'] . " pilotes";

    if ($row['ballprice'] != $row['price']) {
        $concept .=" (promo copa) ";
    }
    $sql1 = "INSERT INTO cashingTemp (concept,amount,datetime, type,orderBy) values ('" . addslashes($concept) . "',-" . $row ['totalPrice'] . ",'" . $row ['datetime'] . "','Pilotes',$n)";
    //echo "SQL3=".$sql1."<br /><br /><br />";

    mysql_query($sql1) or die(mysql_error());
    $n++;
}
$sql = "
SELECT t.name, ate.datetime, rdst.rate, adste.rate as newRate
FROM admTeamEntries ate
JOIN teams t ON t.id = ate.idteam
LEFT JOIN teams_divisions_per_season td ON td.idteam = t.id
 AND td.idseason =ate.idseason

LEFT JOIN rate_division_season_per_team rdst ON rdst.iddivision = td.iddivision AND rdst.idseason =td.idseason
left join admrate_division_season_per_teams_exceptions adste on adste.idteam=t.id and adste.idseason=td.idseason

WHERE  idClub =" . $_GET['idClub'] . " $where4 ";

//echo "SQL2=".$sql."<br /><br /><br />";
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($res)) {
    if (isset($row['newRate'])) {
        $r = $row['newRate'];
    } else {
        $r = $row['rate'];
    }
    $r = 0 + $r;
    $concept = " Drets de competici� de " . $row ['name'] . ".";

    $sql1 = "INSERT INTO cashingTemp (concept,amount,datetime, type,orderBy) values ('" . addslashes($concept) . "',-" . $r . ",'" . $row ['datetime'] . "','Drets de comp.',$n)";
    //$sql1 = "INSERT INTO cashingTemp (concept,amount,datetime, type) values ('" . addslashes($concept) . "',-" . $row ['rate'] . ",'" . $row ['datetime'] . "','Drets')";
    //echo "SQL3=".$sql1."<br /><br /><br />";
    mysql_query($sql1) or die(mysql_error());
    $n++;
}
if ($_GET['startDate'] and $_GET['endDate']) {
    $where = "where datetime>='" . $_GET['startDate'] . " 00:00:00' and datetime<='" . $_GET['endDate'] . " 23:59:00' ";
}
//echo $where;
$res1 = mysql_query("SELECT id,concept,amount,datetime, date_format(datetime,'%m') as month,date_format(datetime,'%y') as year FROM cashingTemp " . $where . "order by datetime asc, orderBy desc") or die(mysql_error());

while ($row1 = mysql_fetch_array($res1)) {
    $d = explode(" ", $row1['datetime']);
    $date = $d[0];
    $d = explode("-", $date);
    $date = $d[2] . "-" . $d[1] . "-" . $d[0];
    //$total = $row1['amount'] + $total;
    //mysql_query("Update cashingTemp set total=$total where id=" . $row1['id']);
    echo "<tr><td>" . $date . "</td><td> " . $row1['concept'] . " </td><td> " . $row1['amount'] . "</td></tr>";
}
echo "</table>";
?>