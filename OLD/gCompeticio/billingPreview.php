<style>body{font-family:Trebuchet Ms, Verdana; }
    td {cellpadding:5px;}
    th{ text-align:left;}
</style>
<?php
// header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<?php
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];
//echo $_GET['idTeam'];
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];
//$lastSeasonId=5;
//echo $lastSeasonId;

$n = 1;
$sqlClub = "select distinct c.id as idClub,c.name from clubs c
join teams t on t.idclub=c.id
join teams_divisions_per_season tds on tds.idteam=t.id
where idseason=$lastSeasonId
order by c.name";
//echo $sqlClub . "<br />";
$resClub = mysql_query($sqlClub);
$n = 1;
while ($rowClub = mysql_fetch_array($resClub)) {
    $idClub = $rowClub['idClub'];
    $clubName = $rowClub['name'];
    $sql1 = "select date(datetime) as date from admBills where idclub=$idClub order by id desc limit 0,1";

    $res1 = mysql_query($sql1) or die(mysql_error());
    $row1 = mysql_fetch_array($res1);
    $startDate = $row1['date'];
    $endDate = date("Y-m-d");
    $expeditionDate = date("d-m-Y");

    //$out .= "<div class='contentBox'>";

    $out .= "<div class='contentBoxHeader'>";
    $out .= "<div style='width:50%; float:left;'>$n <h2>" . $clubName . "</h2>   &raquo; <a target=_blank href='../administration/bills.php?idClub=$idClub&startDate=$startDate&endDate=$endDate&expeditionDate=$expeditionDate&send=no'>Veure</a> &raquo; <a target=_blank  href='../administration/bills.php?idClub=$idClub&send=ok&startDate=$startDate&endDate=$endDate'>PDF</a> &raquo; <a href='../administration/bills.php?idClub=$idClub&billNumber=&send=no&startDate=$startDate&endDate=$endDate' target=_blank >Reenviar</a>";
// $out .= "<div style='width:50%; float:left; text-align:right;'><img class='pointer' onClick='clubCashingInfo(" . $_GET ['idClub'] . ")' src='http://historic.futsal.cat/administration/images/euro.png' /> <img class='pointer' onClick='clubBallsBuyingForm(" . $_GET ['idClub'] . ")' src='http://historic.futsal.cat/webImages/soccer.png' /> <img class='pointer' onClick='clubTeamRegistrationForm(" . $_GET ['idClub'] . ")' src='http://historic.futsal.cat/webImages/page_edit.png' /fi></div><div style='clear:both;'></div>";
    $out .="<div style='margin:10px ;-webkit-border-radius: 4px 4px 4px 4px;
border-radius: 4px 4px 4px 4px;border:1px solid #ddd; padding:10px;  '>";
    $sql3 = "select path, datetime from admBills where idClub=$idClub";
    $res3 = mysql_query($sql3) or die(mysql_error());
    while ($row3 = mysql_fetch_array($res3)) {
        $p = explode("_", $row3['path']);
        $out .= "&bull; <a href='http://historic.futsal.cat/factures/" . $row3['path'] . ".pdf'>" . $p[0] . "</a> ";
    }
    $out .= "</div>";
    $out .= "</div>";
    $out .= "</div>";
    $n++;
}
echo $out;
echo "<hr>";
echo $final;
?>