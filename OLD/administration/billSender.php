<?php

header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<?php

$month = date("m");
$year = date("Y");

include ("../includes/config.php");
include ("../includes/funciones.php");
include_once('../includes/phpToPDF.php');
conectar ();
$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];


//while de club
$sql5 = "select
           id,name, image
       FROM  clubs";

$res5 = mysql_query($sql5) or die(mysql_error());
while ($row5 = mysql_fetch_array($res5)) {

    $idClub=$row5['id'];
    $clubName=$row5['name'];
    $clubImage=$row5['image'];
    echo "EQUIP:" . $row['name'] . " ";

//comprova compra de drets
    $sql1 = "select
           *
       FROM  admTeamEntries ate join teams t on  t.id=ate.idteam
       where idclub=" . $idClub . " and date_format(datetime,'%m')=" . $month . "
        and  date_format(datetime,'%Y')=" . $year;

    $res1 = mysql_query($sql1) or die(mysql_error());
    echo "<br /> - NUMERO DE COMPRA DE DRETS: ";
    echo $num = mysql_num_rows($res1);
    $total = $num;


//comprova compra de pilotes
    $sql1 = "select
           *
       FROM  admBalls
       where idclub=" . $idClub . " and date_format(datetime,'%m')=" . $month . "
        and  date_format(datetime,'%Y')=" . $year;

    $res1 = mysql_query($sql1) or die(mysql_error());
    echo "<br /> - NUMERO DE COMPRA DE PILOTES: ";
    echo $num = mysql_num_rows($res1);
    $total = $total + $num;


//comprova compra de fitxes
    $sql1 = "select
           *
       FROM  player_team_season pts join teams t on  t.id=pts.idteam
       where idclub=" . $idClub . " and date_format(paymentdate,'%m')=" . $month . "
        and  date_format(paymentdate,'%Y')=" . $year;

    $res1 = mysql_query($sql1) or die(mysql_error());
    echo "<br /> - NUMERO DE COMPRA DE FITXES: ";
    echo $num = mysql_num_rows($res1);
    $total = $num+$total;
$it++;

    if ($total > 0) {
        //include_once("bills.php?idClub=" . $row['id'] . "&month=" . $month . "&year=" . $year);
        include("bills.php");
    }


    echo "<br /><br />";
}

?>