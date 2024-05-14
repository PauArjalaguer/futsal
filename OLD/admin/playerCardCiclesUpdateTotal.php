<?php // header("Cache-Control: no-store, no-cache, must-revalidate"); ?>

<?


/*

$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];
$temporadaActual = $lastSeasonId;

$res = mysql_query("select sum(yellowcards) as totalYellowCards, idplayer, (select cards from player_card_cicles where idplayer=pcm.idplayer and idban is null)   as cicle  from player_card_match pcm
join matches m on m.id=pcm.idmatch
join rounds r on r.id=m.idround
where idseason=$lastSeasonId
GROUP BY idplayer
order by cicle") or die(mysql_error());

while ($row = mysql_fetch_array($res)) {
    $totalYellowCards = $row['totalYellowCards'];
//echo $totalYellowCards;
  $divide = $totalYellowCards / 5;
  if(strlen($divide)>1 and !empty($row['cicle'])){
    $remanent = substr($divide, -1);
  }else{
      $remanent=0;
  }
    $divisor = $remanent / 10;
    $cardsInCycle = $divisor * 5;
    if ($cardsInCycle != $row['cicle']) {
        $sql2 = "update  player_card_cicles set cards=$cardsInCycle where idPlayer=" . $row['idplayer'] . " and idban is null";
        echo "Actualizar player " . $row['idplayer'] . ".            Tenia " . $row['cicle'] . " tarjetas y debería tener $cardsInCycle. ";
        //echo "<!-- ($totalYellowCards/5 = $divide . Remanent $remanent . $remanent /10 = $divisor. $divisor *5= $cardsInCycle)--><br />";
        $res2 = mysql_query($sql2) or die(mysql_error());
    }
}*/
?>