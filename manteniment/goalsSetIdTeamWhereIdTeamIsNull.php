<?php

include ("config.php");
include ("funciones.php");
$mysqli = conectar();
$sql = "SELECT idPlayer, idMatch, idSeason, 
(select idteam from player_team_season where idPlayer=pgm.idplayer and idSeason=r.idSeason limit 0,1) as idTeam1, 
(select idteam from matches_players_archive where idPlayer=pgm.idPlayer and idMatch=pgm.idMatch limit 0,1) as idTeam2 
FROM futsal.player_goals_match pgm
	join matches m on m.id=pgm.idmatch
	join rounds r on r.id=m.idRound    
where idTeam is null limit 0,5000";
$res = $mysqli->query($sql) or die(mysqli_error($mysqli));
while ($row = mysqli_fetch_array($res)) {
    if ($row['idTeam2']) {
        $idTeam = $row['idTeam2'];
    }
    if ($row['idTeam1']) {
        $idTeam = $row['idTeam1'];
    }

    $sql2 = "update player_goals_match set idTeam=" . $idTeam . " where idMatch=" . $row['idMatch'] . " and idPlayer=" . $row['idPlayer'];
    echo "<br /> -> " . $sql2;
    $res2 = $mysqli->query($sql2) or die(mysqli_error($mysqli));
}
?>