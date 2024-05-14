<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$sql = "SELECT idplayer, SUM( yellowcards ) AS c
FROM  `player_card_match` pcm
JOIN matches m ON m.id = pcm.idmatch
JOIN rounds r ON r.id = m.idround
JOIN leagues l ON l.id = r.idleague
WHERE l.idseason =3 
GROUP BY idplayer
ORDER BY c DESC
LIMIT 0 , 1000";

$res = mysql_query($sql);
while ($row = mysql_fetch_array($res)) {
    mysql_query("insert into player_card_cicles (idplayer,cards) values (" . $row['idplayer'] . "," . $row['c'] . ")");
}
?>
