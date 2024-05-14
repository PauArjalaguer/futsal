<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>

<?

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();


$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];
$temporadaActual = $lastSeasonId;
mysql_query("update player_card_match set yellowCards=0 where idPlayer=" . $_GET['idPlayer'] . " and idMatch=" . $_GET['idMatch']) or die(mysql_error());

$res = mysql_query("select sum(yellowcards) as totalYellowCards
from player_card_match pcm
join matches m on m.id=pcm.idmatch
join rounds r on r.id=m.idround
join teams t1 on t1.id=m.idlocal
join teams t2 on t2.id=m.idvisitor
where idplayer=".$_GET['idPlayer']." and idseason=".$temporadaActual) or die(mysql_error());

$row = mysql_fetch_array($res);
$totalYellowCards=$row['totalYellowCards'];
//echo $totalYellowCards;
$divide=$totalYellowCards/5;
$remanent=substr($divide,-1);
$divisor=$remanent/10;
$cardsInCycle=$divisor*5;

echo "TOTAL: $totalYellowCards DIVISIO: $divide REMANENT: $remanent DIVISOR: $divisor TARGETES: $cardsInCycle<br /><br /><br /><br />";

$sql ="update  player_card_cicles set cards=$cardsInCycle where idPlayer=" . $_GET['idPlayer'] . " and idban is null";
//echo $sql;
$res=mysql_query($sql) ;
$sql ="select cards, p.name from players p left join player_card_cicles pcc on pcc.idplayer=p.id where p.id=" . $_GET['idPlayer'] . " and idban is null";
//echo $sql;
$res=mysql_query($sql) ;
$row = mysql_fetch_array($res);


//$row = mysql_fetch_array($res);
//echo $row['cards'];
echo "<br />CICLE ".$row['cards']."+".$_GET['yellowCards'];
$cicle = $row['cards'] + $_GET['yellowCards'];

if ($cicle < 5) {
   $out .= "Afegir " . $_GET['yellowCards'] . " targetes al jugador " . $row['name'] . "? Sera la " . $cicle . " del cicle.";
} else {
    $newCicle = abs(5 - $cicle);

   $out .= "Afegir " . $_GET['yellowCards'] . " targetes al jugador " . $row['name'] . "? Es sancionarà amb un partit de sanció i s'iniciarà un nou cicle amb $newCicle targetes.";
}
echo utf8_encode($out);
?>
