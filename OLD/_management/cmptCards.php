<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx = conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];
//echo $_GET['idTeam'] . " " . $_GET['idMatch'];
$hash = $_GET['hash'];
$idClub = $_GET['idClub'];

$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2 onClick=\"cmptScorers('" . $_GET['hash'] . "', " . $_GET['idClub'] . ")\";>Golejadors</h2></div>";
$out .="<div class='contentBoxContent'><table width='100%'  class='playersTable' cellspacing=0><tr><th >Jugador</th><th>Grogues</th><th>Blaves</th><th>Cicle</th></tr>";
if (md5($idClub) == $hash) {
// echo $sql;
    $sql1 = "

select p.id,sum(pcm.yellowcards) as yellow, sum(pcm.blueCards) as blue, p.name, t.name as team, (select cards from player_card_cicles where idplayer=pcm.idplayer order by id desc limit 0,1)  as lastCicle from player_card_match pcm
join matches m on m.id=pcm.idmatch
join rounds r on r.id=m.idround
join players p on p.id=pcm.idplayer
join player_team_season pts on pts.idplayer=pcm.idplayer
join teams t on t.id=pts.idteam
where r.idseason=$lastSeasonId
and pts.idseason=$lastSeasonId
and idclub=$idClub
group by pcm.idplayer
order by t.id asc, blue desc, yellow desc
";
    $res1 = mysql_query($sql1) or die(mysql_error());
    $n = 1;
    while ($row = mysql_fetch_array($res1)) {
        if ($n == 1) {
            $n = 2;
        } else {
            $n = 1;
        }

        if ($team != $row['team']) {
            $out .="<tr><td>&nbsp;</td></tr><tr><td colspan=6 style='font-weight:bold; background-color:#900; color:#fff;'>" . $row['team'] . "</td></tr>";
        }
        $out .="<tr><td class='zebra$n'>" . $row['name'] . "</td><td class='zebra$n'>" . $row['yellow'] . "</td><td class='zebra$n'>" . $row['blue'] . "</td><td class='zebra$n'>" . $row['lastCicle'] . "</td></tr>";
$team = $row['team'];

        //$n++;
    }
}
$out .="</table></div></div>";


echo utf8_encode($out);
mysql_close($idcnx);
?>

