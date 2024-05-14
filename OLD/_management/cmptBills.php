<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx = conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];
//echo $_GET['idTeam'] . " " . $_GET['idMatch'];
$hash = $_GET['hash'];
$idClub = $_GET['idClub'];

$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2 onClick=\"cmptBills('" . $_GET['hash'] . "', " . $_GET['idClub'] . ")\";>Factures</h2></div>";
$out .="<div class='contentBoxContent'><table  class='playersTable' cellspacing=0><tr><th width='150px'>Data</th><th>Factura</th><th>&nbsp;</th></tr>";
if (md5($idClub) == $hash) {
// echo $sql;
    $sql1 = "Select id, path, datetime from admBills where idClub=$idClub";
    $res1 = mysql_query($sql1) or die(mysql_error());
    $n = 1;
    while ($row1 = mysql_fetch_array($res1)) {
        if ($n == 1) {
            $n = 2;
        } else {
            $n = 1;
        }
        $dat = explode(" ", $row1['datetime']);
        $dt = explode("-", $dat[0]);
        $date = $dt[2] . "-" . $dt[1] . "-" . $dt[0];
        $f=explode("_",$row1['path']);
        $billNumber=$f[0];
        $out .="<tr><td class='zebra$n'>$date</td><td class='zebra$n'>Factura " . $billNumber . "</td><td class='zebra$n'><a target='_blank' href='../factures/" . $row1['path'] . ".pdf'><img src='http://www.futsal.cat/webImages/attach.png' /></td></tr>";


        //$n++;
    }
}
$out .="</table></div></div>";


echo utf8_encode($out);
?>

