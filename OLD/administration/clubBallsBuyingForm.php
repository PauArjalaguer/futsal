<?php
header ( "Cache-Control: no-store, no-cache, must-revalidate" );
?>
<?php

//echo $_GET['idTeam'];
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar ();
$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];
//echo $lastSeasonId;

$sql = "select
        name from clubs c
 where c.id=" . $_GET ['idClub'];

$res = mysql_query ( $sql ) or die ( mysql_error () );
$row = mysql_fetch_array ( $res );
$clubName = $row ['name'];

$sql="select price from admBallPricePerSeason where idseason=$lastSeasonId ";
$res = mysql_query ( $sql ) or die ( mysql_error () );
$row = mysql_fetch_array ( $res );
$price = $row ['price'];

$out .= "<div class='contentBox'>";

$out .= "<div class='contentBoxHeader'>";
$out .= "<div style='width:50%; float:left;' onClick='clubBallBuyingForm(" . $_GET ['idClub'] . ")'><h2>Compra de pilotes per al club " . $clubName . "</h2></div>";
$out .= "<div style='width:50%; float:left; text-align:right;'><img class='pointer' onClick='clubCashingInfo(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/administration/images/euro.png' /> <img class='pointer' onClick='clubBallsBuyingForm(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/webImages/soccer.png' /> <img class='pointer' onClick='clubTeamRegistrationForm(" . $_GET ['idClub'] . ")' src='http://www.futsal.cat/webImages/page_edit.png' /fi></div><div style='clear:both;'></div>";

$out .= "</div>";
$out .= "<div class='contentBoxContent'>";
$out .= "<td style='border-top:1px solid #242424;' class='zebra$n'>";
$out .= "<input value=\"0\" class='playerCardEditInput' type='text' id='clubBallsBuyingAmount' style='width:50px; text-align:center; margin-right:10px;'>";
$out .= " x  &nbsp;<input  class='playerCardEditInput' type='text' id='clubBallsBuyingPrice' style='width:50px; text-align:center; margin-right:10px;' placeholder='$price' value='25'> Euros";

$out .=" &nbsp;<input type='button' value='Guardar' class='newPlayerNameButton' onClick='clubBallsBuyingInsert(" . $_GET ['idClub'] . ")'></td></tr>";
$out .= "</div>";
$out .= "</div>";

echo utf8_encode ( $out );
?>
