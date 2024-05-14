<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx = conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];

$hash = $_GET['hash'];
$idClub = $_GET['idClub'];

$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2 onClick=\"cmptScorers('" . $_GET['hash'] . "', " . $_GET['idClub'] . ")\";>Golejadors</h2></div>";
$out .="<div class='contentBoxContent'><table width='100%'  class='playersTable' cellspacing=0><tr><th >Jugador</th><th>Gols</th></tr>";
//if (md5($idClub) == $hash) {
if($idClub){
    
// echo $sql;
    /* $sql1 = "select
      p.name, sum(pgm.number) as goals, image, t.id,t.name as team
      from player_goals_match pgm
      join matches m on m.id=pgm.idmatch
      join players p on p.id=pgm.idplayer
      join rounds r on r.id=m.idround
      join player_team_season pts on pts.idplayer=p.id
      join teams t on t.id=pts.idteam
      where r.idseason=$lastSeasonId
      and pts.idseason=$lastSeasonId
      and idclub=$idClub
      group by pgm.idplayer
      order by pts.idteam, goals desc
      "; */
    $sql1 = "select id,name from teams where idclub=$idClub";
    
    //echo $sql1;
    $res1 = mysql_query($sql1) or die(mysql_error());
    $n = 1;
    while ($row = mysql_fetch_array($res1)) {
        if ($n == 1) {
            $n = 2;
        } else {
            $n = 1;
        }


        $out .="<tr><td>&nbsp;</td></tr><tr><td colspan=2 style='font-weight:bold; background-color:#900; color:#fff;'>" . $row['name'] . "</td></tr>";
        $sql2 = "select  sum(number) as goals,p.name, p.id from player_goals_match pgm
join players p on p.id=pgm.idplayer
join matches_players mp on mp.idplayer=pgm.idplayer and mp.idmatch=pgm.idmatch
join teams t on t.id=mp.idteam
join matches m on m.id=pgm.idmatch
join rounds r on r.id=m.idround
where idseason=$lastSeasonId and mp.idteam=" . $row['id'] . "

 group by p.id
order by goals desc
";
        $res2 = mysql_query($sql2) or die(mysql_error());
        $n = 1;
        while ($row2 = mysql_fetch_array($res2)) {
            $out .="<tr><td class='zebra$n'>" . $row2['name'] . "</td><td class='zebra$n'>" . $row2['goals'] . "</td></tr>";
            $team = $row['name'];
        }//$n++;
    }
}
$out .="</table></div></div>";


echo utf8_encode($out);
mysql_close($idcnx);
?>

