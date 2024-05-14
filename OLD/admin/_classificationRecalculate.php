<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

$idLeague = $_GET['idLeague'];
$idSeason = $_GET['idSeason'];

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];
$idSeson = $lastSeasonId;
mysql_query("delete from classification where idLeague=$idLeague");

$sql = "select t.id, t.name from teams_leagues_per_season td join teams t on t.id=td.idTeam where idLeague=$idLeague ";
$ql = "--and idSeason=$idSeason";
echo $sql."\n";
$res = mysql_query($sql);
while ($row = mysql_fetch_array($res)) {
    //echo $row['name'] . "<br />";
    $idTeam = $row['id'];
    $sql2 = "select m.idLocal,m.idVisitor, re.localResult,re.visitorResult from results re join matches m on m.id=re.idMatch join rounds r on m.idround=r.id where (idLocal=$idTeam or idVisitor=$idTeam) and r.idSeason=$idSeason and r.idLeague=$idLeague order by idmatch";
    //echo $sql2 . "\n<br />";
    $res2 = mysql_query($sql2);
    $draws = 0;
    $wins = 0;
    $loses = 0;

    $goalsF = 0;
    $goalsC = 0;

    $playedMatches = 0;
    while ($row2 = mysql_fetch_array($res2)) {
        //echo "- - - - - - - - Local: ".$row2['idLocal']." Visitant: ".$row2['idVisitor']. " Gols Local:".$row2['localResult']." Gols Visitant: ".$row2['visitorResult']."<br />";

        if ($idTeam == $row2['idLocal']) {
            $local = 1;
            $goalsF = $goalsF + $row2['localResult'];
            $goalsC = $goalsC + $row2['visitorResult'];

            if ($row2['localResult'] > $row2['visitorResult']) {
                $wins++;
            } else if ($row2['localResult'] < $row2['visitorResult']) {
                $loses++;
            }
        } else {
            $local = 0;
            $goalsF = $goalsF + $row2['visitorResult'];
            $goalsC = $goalsC + $row2['localResult'];
            if ($row2['localResult'] < $row2['visitorResult']) {
                $wins++;
            } else if ($row2['localResult'] > $row2['visitorResult']) {
                $loses++;
            }
        }
        if ($row2['localResult'] == $row2['visitorResult']) {
            $draws++;
        }
        $playedMatches++;
    }

    //echo $idTeam . " " . $row['name'] . " Wins: $wins Loses: $loses Draws: $draws $goalsF $goalsC<br />";
    mysql_query("insert into classification (idTeam, idLeague, playedMatches, wonMatches, drawMatches,lostMatches,goalsMade,goalsReceived) values ($idTeam,$idLeague,$playedMatches,$wins,$draws,$loses,$goalsF,$goalsC)") or die(mysql_error());
}
$a = 1;
$query1 = "SELECT t.name,(
(
wonMatches *3
) + drawMatches
) AS points, idTeam, playedMatches, wonMatches, drawMatches, lostMatches, goalsMade, goalsReceived, (goalsMade-goalsReceived) as goalAverage
FROM classification c
JOIN teams t ON c.idTeam = t.id
WHERE idLeague=$idLeague
ORDER BY points DESC, playedMatches asc,goalAverage desc";

//echo "<br>$query1</br>";
$result1 = mysql_query($query1) or die(mysql_error());

while ($row = mysql_fetch_array($result1)) {
    $sql2 = "UPDATE classification set position=$a, points=" . $row['points'] . " where idLeague=$idLeague and idTeam=" . $row['idTeam'];
    //echo $sql2;
    mysql_query($sql2);
    $a++;
}
echo utf8_encode("Recalcul de classificació i puntuació de lligues fet amb èxit.");


$query = "select m.id,idlocal, idvisitor, matchWinnerLocal, matchWinnerVisitor from matches m
    join rounds r on r.id=m.idround
where idleague=$idLeague
    and (idlocal is null or idvisitor is null)";
//echo $query;
$result = mysql_query($query);
while ($row = mysql_fetch_array($result)) {
    if (empty($row['idlocal'])) {
        $query2 = "select localResult, visitorResult, idLocal, idVisitor from results r join matches m on m.id=r.idMatch where idmatch=" . $row['matchWinnerLocal'];
        //echo $query2."<br />";
        $result2 = mysql_query($query2) or die(mysql_error());
        $row2 = mysql_fetch_array($result2);
        if ($row2['localResult'] > $row2['visitorResult']) {
            // mysql_query("UPDATE matches SET idLocal=".$row2['idLocal']." where id=".$row['id'];
            $sql3 = "UPDATE matches SET idLocal=" . $row2['idLocal'] . " where id=" . $row['id'];
            mysql_query($sql3);
        }
        if ($row2['localResult'] < $row2['visitorResult']) {
            $sql3 = "UPDATE matches SET idLocal=" . $row2['idVisitor'] . " where id=" . $row['id'];
            mysql_query($sql3);
        }
    }

    if (empty($row['idvisitor'])) {
        $query2 = "select localResult, visitorResult, idLocal, idVisitor from results r join matches m on m.id=r.idMatch where idmatch=" . $row['matchWinnerVisitor'];
        //echo $query2."<br />";
        $result2 = mysql_query($query2) or die(mysql_error());
        $row2 = mysql_fetch_array($result2);
        if ($row2['localResult'] > $row2['visitorResult']) {
            // mysql_query("UPDATE matches SET idLocal=".$row2['idLocal']." where id=".$row['id'];
            $sql3 = "UPDATE matches SET idVisitor=" . $row2['idLocal'] . " where id=" . $row['id'];
            mysql_query($sql3);
        }
        if ($row2['localResult'] < $row2['visitorResult']) {
            $sql3 = "UPDATE matches SET idVisitor=" . $row2['idVisitor'] . " where id=" . $row['id'];
            mysql_query($sql3);
        }
    }
}


$query34 = "SELECT t.id,t.name, points, idTeam, position
FROM classification c
JOIN teams t ON c.idTeam = t.id
WHERE idLeague=$idLeague
ORDER BY position aSC";
//$out .= $query34;
//echo $query34;
$result34 = mysql_query($query34);

while ($row34 = mysql_fetch_array($result34)) {
    $out .= "<br /><br />" . $row34['name'] . " - " . $row34['points']."<br /><br />";
    if ($prevTeamPoints == $row34['points']) {

        $idTeam = $row34['id'];
        $out .= "<br /><br />" . $prevTeamName . "-" . $row34['name'] . " empatats a punts<br />";
        $query2 = "Select idlocal, idvisitor,localResult, visitorResult,(localResult-visitorResult) as result, t.id,t.name from matches m
join results re on re.idmatch=m.id
join rounds r on r.id=m.idround
join teams t on t.id=m.idlocal where  idleague=" . $_GET['idLeague'] ." and ((idLocal=$idTeam and idVisitor=$prevTeamId) or (idLocal=$prevTeamId and idVisitor=$idTeam)) ";
        //$out .= "---->" . $query2 . "<br />";
        $result2 = mysql_query($query2) or die(mysql_error());
        $matchCounter = 1;

        $firstTeamWin = 0;
        $secondTeamWin = 0;

        $firstTeamId = $prevTeamId;
        $secondTeamId = $idTeam;

        $firstTeamName = $prevTeamName;
        $secondTeamName = $row34['name'];

        $firstTeamPosition = $prevTeamPosition;
        $secondTeamPosition = $row34['position'];
        while ($row2 = mysql_fetch_array($result2)) {
            $result = $row2['result'];

            /* if ($matchCounter == 1) {
              $firstTeamGoals = $row['localResult'];
              $secondTeamGoals = $row['visitorResult'];
              $out .="\n\t______________> Primer partit:";
              //Si guanya local
              if ($result == 0) {
              $draw = 1;
              $out .= " empat.";
              } else if ($result >= 1) {
              $firstTeamWin++;
              $out .= " guanya $firstTeamName equip";
              } else {
              $secondTeamWin++;
              $out .= " guanya $secondTeamName equip";
              }
              }
              if ($matchCounter == 2) {
              $firstTeamGoals = $firstTeamGoals + $row['visitorResult'];
              $secondTeamGoals = $secondTeamGoals + $row['localResult'];
              $out .="\n\t<br />______________> Segon partit :";
              //Si guanya local
              if ($result == 0) {
              $draw = 1;
              $out .= " empat.";
              } else if ($result >= 1) {
              $secondTeamWin++;
              $out .= " guanya $secondTeamName equip";
              } else {
              $firstTeamWin++;
              $out .= " guanya $firstTeamName equip";
              }
              }* /
             * 
             */
            if ($matchCounter == 1) {
                $firstTeamId = $row2['id'];
                $firstTeamName = $row2['name'];

                $secondTeamId = $row2['idVisitor'];
                $out .="Primer equip: $firstTeamId";
                $firstTeamGoals = $row2['localResult'];
                $secondTeamGoals = $row2['visitorResult'];
                if ($result == 0) {
                    $draw = 1;
                    $out .= " empat.";
                } else if ($result >= 1) {
                    $firstTeamWin++;
                    $out .= " guanya $firstTeamName ";
                } else {
                    $secondTeamWin++;
                    $out .= " guanya $secondTeamName";
                }
                $out .= "(" . $row2['localResult'] . "-" . $row2['visitorResult'] . ")";
            }
            if ($matchCounter == 2) {
                $firstTeamGoals = $firstTeamGoals + $row2['visitorResult'];
                $secondTeamGoals = $secondTeamGoals + $row2['localResult'];
                $secondTeamId = $row2['id'];
                $secondTeamName = $row2['name'];
                $out .="<br />Segon equip: $secondTeamId";
                if ($result == 0) {
                    $draw = 1;
                    $out .= " empat.";
                } else if ($result >= 1) {
                    $secondTeamWin++;
                    $out .= " guanya $secondTeamName ";
                } else {
                    $firstTeamWin++;
                    $out .= " guanya $firstTeamName ";
                }
                $out .= "(" . $row2['localResult'] . "-" . $row2['visitorResult'] . ")";
            }

            $matchCounter++;
        }

        $position = $row34['position'];
        $out .="<br />---> $firstTeamName: $firstTeamWin GOLS: $firstTeamGoals. $secondTeamName : $secondTeamWin GOLS $secondTeamGoals";
    }
    $prevTeamName = $row34['name'];
    $prevTeamPoints = $row34['points'];
    $prevTeamId = $row34['id'];
    $prevTeamPosition = $row34['position'];
    //$firstTeamWin = intval($firstTeamWin);
    //$secondTeamWin = intval($secondTeamWin);
}
$out .="\n\t<br />$firstTeamWin - $secondTeamWin<br />";
//$secondTeamWin=$firstTeamWin;
if ($firstTeamWin > $secondTeamWin) {
    $out .="\n\tPrimer equip guanya $position";
    //mysql_query("Update classification set position=" . ($position - 1) . " where idLeague=$idLeague and idTeam=" . $firstTeamId) or die(mysql_error());
    //mysql_query("Update classification set position=" . $position . " where idLeague=$idLeague and idTeam=" . $secondTeamId) or die(mysql_error());
} else if ($firstTeamWin < $secondTeamWin) {
    $out .="\n\t Segon equip guanya $position";
    //mysql_query("Update classification set position=" . $position . " where idLeague=$idLeague and idTeam=" . $firstTeamId) or die(mysql_error());
    //mysql_query("Update classification set position=" . ($position - 1) . " where idLeague=$idLeague and idTeam=" . $secondTeamId) or die(mysql_error());
} else {
    $out .="\n\t Empat";
    if ($firstTeamGoals > $secondTeamGoals) {
        $out .="\n\t Després de l' empat guanya el primer equip";
       // mysql_query("Update classification set position=" . ($position - 1) . " where idLeague=$idLeague and idTeam=" . $firstTeamId) or die(mysql_error());
       // mysql_query("Update classification set position=" . $position . " where idLeague=$idLeague and idTeam=" . $secondTeamId) or die(mysql_error());
    } else {
        $out .="\n\t Després de l' empat guanya el segon equip";
       // mysql_query("Update classification set position=" . $position . " where idLeague=$idLeague and idTeam=" . $firstTeamId) or die(mysql_error());
       //  mysql_query("Update classification set position=" . ($position - 1) . " where idLeague=$idLeague and idTeam=" . $secondTeamId) or die(mysql_error());
    }
}




if($_GET['debug']){
    echo $out;
}
//echo "<br />$firstTeamWin - $secondTeamWin<br />";
//mysql_close($idcnx);
?>