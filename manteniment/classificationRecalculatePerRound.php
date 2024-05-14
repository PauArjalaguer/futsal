<?php

include ("config.php");
include ("funciones.php");
$mysqli = conectar();

$sql = "select ro.id, idLeague, idSeason from results re
join matches m on m.id=re.idmatch
join rounds ro on ro.id=m.idround
where idseason=".$_GET['idSeason']."
order by ro.id ";
$res = $mysqli->query($sql) or die(mysqli_error($mysqli));
while ($row = mysqli_fetch_array($res)) {
   echo  $idRound = $row['id'];
    $idLeague = $row['idLeague'];
    $idSeason = $row['idSeason'];

    echo "<hr />ELIMINO LLIGA SEGONS JORNADA";
    $sql = "delete from classification_v2 where idRound=$idRound and idLeague=$idLeague";
    echo $sql . "<br />";
  $mysqli->query($sql) or die(mysqli_error($mysqli));

    echo "<br />Selecciono tots els equips de la lliga";
    $sql2 = "select t.id as idTeam, t.name from teams_leagues_per_season td join teams t on t.id=td.idTeam where idLeague=$idLeague ";
    $res2 = $mysqli->query($sql2) or die(mysqli_error($mysqli));
    while ($row2 = mysqli_fetch_array($res2)) {
        $idTeam = $row2['idTeam'];
        echo "<br />-> Selecciono dades de classificació de l' equip " . $row2['idTeam'] . " - " . $row2['name'];
        $sql3 = "select m.idLocal,m.idVisitor, re.localResult,re.visitorResult from results re join matches m on m.id=re.idMatch join rounds r on m.idround=r.id where (idLocal=$idTeam or idVisitor=$idTeam) and r.idSeason=$idSeason and r.idLeague=$idLeague and r.id<=$idRound order by idmatch";
        $res3 = $mysqli->query($sql3) or die(mysqli_error($mysqli));
        $draws = 0;
        $wins = 0;
        $loses = 0;
        $goalsF = 0;
        $goalsC = 0;
        $playedMatches = 0;
        while ($row3 = mysqli_fetch_array($res3)) {
            echo "<br >Resultats de " . $row2['name'] . "<br />" . $sql3 . "<br />";


            if ($idTeam == $row3['idLocal']) {
                $local = 1;
                $goalsF = $goalsF + $row3['localResult'];
                $goalsC = $goalsC + $row3['visitorResult'];

                if ($row3['localResult'] > $row3['visitorResult']) {
                    $wins++;
                } else if ($row3['localResult'] < $row3['visitorResult']) {
                    $loses++;
                }
            } else {
                $local = 0;
                $goalsF = $goalsF + $row3['visitorResult'];
                $goalsC = $goalsC + $row3['localResult'];
                if ($row3['localResult'] < $row3['visitorResult']) {
                    $wins++;
                } else if ($row3['localResult'] > $row3['visitorResult']) {
                    $loses++;
                }
            }
            if ($row3['localResult'] == $row3['visitorResult']) {
                $draws++;
            }
            $playedMatches++;
        }
        $points = ($wins * 3) + $draws;
        $sql4 = "insert into classification_v2 (idTeam, idLeague, playedMatches, wonMatches, drawMatches,lostMatches,goalsMade,goalsReceived, idRound, points) values ($idTeam,$idLeague,$playedMatches,$wins,$draws,$loses,$goalsF,$goalsC,$idRound, $points)";
        echo "<br />" . $sql4;

        $mysqli->query($sql4) or die(mysqli_error($mysqli));

        $a = 1;
        $sql5 = "SELECT idteam from classification_v2 where idRound=$idRound ORDER BY points DESC";
        echo "<br />" . $sql5;
        $res5 = $mysqli->query($sql5) or die(mysqli_error($mysqli));
        while ($row5 = mysqli_fetch_array($res5)) {
            $sql6 = "UPDATE classification_v2 set position=$a where idLeague=$idLeague and idRound=$idRound and idTeam=" . $row5['idteam'];
            $mysqli->query($sql6) or die(mysqli_error($mysqli));
            echo "<br />" . $sql6;
            $a++;
        }
    }
}
?>