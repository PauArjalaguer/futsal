<?php header("Cache-Control: no-store, no-cache, must-revalidate");

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];
$temporadaActual = $lastSeasonId;

$res = mysql_query("select count(*) as count from player_card_match where idPlayer=" . $_GET['idPlayer'] . " and idMatch=" . $_GET['idMatch']) or die(mysql_error());
$row = mysql_fetch_array($res);
if ($row['count'] == 0) {
    //echo "insert into player_card_match (idPlayer,idMatch,yellowCards, blueCards) values (".$_GET['idPlayer'].",".$_GET['idMatch'].",".$_GET['yellowCards'].",".$_GET['blueCards'];
    mysql_query("insert into player_card_match (idPlayer,idMatch,yellowCards, blueCards) values (" . $_GET['idPlayer'] . "," . $_GET['idMatch'] . "," . $_GET['yellowCards'] . "," . $_GET['blueCards'] . ")") or die(mysql_error());
    
} else {
    echo "update player_card_match set yellowCards=".$_GET['yellowCards'].", blueCards=".$_GET['blueCards']." where idPlayer=".$_GET['idPlayer']." and idMatch=".$_GET['idMatch'];
    mysql_query("update player_card_match set yellowCards=" . $_GET['yellowCards'] . ", blueCards=" . $_GET['blueCards'] . " where idPlayer=" . $_GET['idPlayer'] . " and idMatch=" . $_GET['idMatch']) or die(mysql_error());
}


$sql = "select id,cards from  player_card_cicles  where idPlayer=" . $_GET['idPlayer'] . " and idban is null";

$res = mysql_query($sql) or die(mysql_error());
//echo mysql_num_rows($res);


if (mysql_num_rows($res) == 0) {
    mysql_query("insert into player_card_cicles (idplayer,cards) values (" . $_GET['idPlayer'] . ",0)") or die(mysql_error());
//echo "HE CREAT UN CICLE NOU PERQUE NO N'HI HAVIA CAP, HOYGAN";
}
$row = mysql_fetch_array($res);


$cicle = $row['cards'] + $_GET['yellowCards'];

if ($cicle < 5) {
    $sql = "update player_card_cicles set cards=$cicle where idplayer=" . $_GET['idPlayer'] . " and idban is null";
     echo $sql;
    mysql_query($sql) or die(mysql_error());
} else {
    $newCicle = 5 - $cicle;


    $sql = "insert into player_bans_round (idPlayer,idRound,rounds,money,comment) values (" . $_GET['idPlayer'] . "," . $_GET['idRound'] . ",1,15,'per acumulació de 5 targetes grogues')";
    mysql_query($sql) or die(mysql_error());
    $lastInserted = mysql_insert_id();
    mysql_query("update player_card_cicles set cards=5,idban=$lastInserted where idplayer=" . $_GET['idPlayer'] . " and idban is null") or die(mysql_error());
    mysql_query("insert into player_card_cicles (idplayer,cards) values (" . $_GET['idPlayer'] . ",$newCicle)") or die(mysql_error());
}
echo utf8_encode($out);
?>
