<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>

<?

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];
$idSeson=$lastSeasonId;

if ($_GET['action'] == "insert") {
    $sql = "insert into matches_players (idMatch,idPlayer,idTeam) values (" . $_GET['idMatch'] . "," . $_GET['idPlayer'] . ",".$_GET['idTeam'].")";


} else {
    $sql = "delete from matches_players where idMatch=" . $_GET['idMatch'] . " and idPlayer=" . $_GET['idPlayer'];
    echo $sql;
}

$res = mysql_query($sql) or die(mysql_error());
$sql="select p.id, (select count(*)
  from  matches_players mp
  join matches m on m.id=mp.idmatch
  join rounds r on r.id=m.idround
  join leagues l on l.id=r.idleague
  join championship c1 on c1.id=l.idchampionship
  where l.idseason=$lastSeasonId and mp.idplayer=p.id
  -- and mp.idteam!=pts.idteam
  and c1.orderby<c.orderby)  as count
from players p
join player_team_season pts on pts.idplayer=p.id
                            join teams t on t.id=pts.idteam
                            join teams_leagues_per_season tls on tls.idteam=t.id and tls.idseason=pts.idseason
join leagues l on l.id=tls.idleague
join championship c on c.id=l.idchampionship
where idPlayer=".$_GET[idPlayer]." and l.idSeason=".$lastSeasonId;
$row=  mysql_fetch_array(mysql_query($sql));
$m=$row['count'];
$sql="update player_team_season set matchesPlayedWithAnotherTeam=$m where idPlayer=".$_GET[idPlayer]." and idSeason=".$lastSeasonId;
mysql_query($sql);
?>
