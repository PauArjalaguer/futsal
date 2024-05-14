<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>

<?

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$res = mysql_query("select count(*) as count from player_card_match where idPlayer=" . $_GET['idPlayer'] . " and idMatch=" . $_GET['idMatch']) or die(mysql_error());


$row = mysql_fetch_array($res);
//echo $row['count'];
if ($row['count'] == 0) {
    //echo "insert into player_card_match (idPlayer,idMatch,yellowCards, blueCards) values (".$_GET['idPlayer'].",".$_GET['idMatch'].",".$_GET['yellowCards'].",".$_GET['blueCards'];
    mysql_query("insert into player_card_match (idPlayer,idMatch,yellowCards, blueCards) values (" . $_GET['idPlayer'] . "," . $_GET['idMatch'] . "," . $_GET['yellowCards'] . "," . $_GET['blueCards'] . ")") or die(mysql_error());
    ;
} else {
    //echo "update player_card_match set yellowCards=".$_GET['yellowCards'].", blueCards=".$_GET['blueCards']." where idPlayer".$_GET['idPlayer']." and idMatch=".$_GET['idMatch'];
    mysql_query("update player_card_match set yellowCards=" . $_GET['yellowCards'] . ", blueCards=" . $_GET['blueCards'] . " where idPlayer=" . $_GET['idPlayer'] . " and idMatch=" . $_GET['idMatch']) or die(mysql_error());
    ;
}


?>
