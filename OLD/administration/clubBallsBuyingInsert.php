<?php

header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<?php

//echo $_GET['idTeam'];
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar ();
$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];
$clubCashingBalance = clubCashingBalance($_GET['idClub'], 2);
//saber preu de la pilota aquesta temporada
if (empty($_GET['price'])) {
    $res = mysql_query("SELECT price FROM `admBallPricePerSeason` WHERE idSeason=$lastSeasonId");
    $row = mysql_fetch_array($res);
    $price = $row['price'];
}else{
    $price=$_GET['price'];
}

$total = $price * $_GET['amount'];
if ($total > $clubCashingBalance) {
    echo "El saldo per pilotes del club es de " . utf8_encode($clubCashingBalance);
} else {
    mysql_query("INSERT INTO admBalls (amount, idClub, datetime, ballPrice) values (" . $_GET['amount'] . "," . $_GET['idClub'] . ",now()," . $price . ")");

    //echo "INSERT INTO admBalls (amount, idClub, datetime, ballPrice) values (" . $_GET['amount'] . "," . $_GET['idClub'] . ",now()," . $price . ")";
}
?>
