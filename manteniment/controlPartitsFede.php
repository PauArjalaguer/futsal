<?php
ini_set("auto_detect_line_endings", "1");
include "config.php";
include "funciones.php";
$mysqli = conectar();
?>
<html>
    <head>
        <script>function updateMatch(idMatch) {
             document.getElementById("match_"+idMatch).innerHTML="<img src='http://ajaxloadingimages.net/gif/image?imageid=dot-spinner&forecolor=000000&backcolor=ffffff'>";
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                       document.getElementById("match_"+idMatch).innerHTML="Ok";
                    }
                };
                xhttp.open("GET", "../playOff/apiResultats.php?debug=1&reset=1&idMatch=" + idMatch, true);
                xhttp.send();
            }</script>
        <style>td{ padding:2px; font-size:  12px;font-family: 'Roboto Condensed', sans-serif;}
        </style>        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <!-- Latest compiled and minified CSS -->
        <meta charset="UTF-8">
        <title>Control Partits FCFS</title>
    </head>
    <body>
        <table width="100%" class="table">
            <?php
            $n=1;
            $sql = "SELECT datediff(now(),r.lastupdateddatetime) AS days,ms.status,m.id, m.playOffId, localResult, visitorResult, (localResult+visitorResult) AS sumGoals, 
            --(SELECT count(*) FROM player_goals_match WHERE idMatch=r.idMatch) AS totalGoals, 
                (SELECT count(*) FROM player_goals_match WHERE idMatch=r.idMatch and idTeam=m.idLocal) AS localGoals, 
            (SELECT count(*) FROM player_goals_match WHERE idMatch=r.idMatch and idTeam=m.idVisitor) AS visitorGoals, 
            
            (SELECT count(*) FROM matches_players WHERE idMatch=m.id) AS players,m.updateddatetime, t1.name AS local, t2.name AS visitor, ro.name as round, l.name as league, r.id as idResult, t1.id as idLocal, t2.id as idVisitor FROM results r 
 RIGHT JOIN matches m ON m.id=r.idMatch
 JOIN rounds ro ON ro.id=m.idRound
 JOIN teams t1 ON t1.id=m.idLocal
 JOIN teams t2 ON t2.id=m.idVisitor
 JOIN leagues l ON l.id=ro.idLeague
 JOIN matchstatus ms  on ms.id=m.statusId
  WHERE statusId !=3 and ro.idSeason=10 AND updateddatetime<now()   order by updateddatetime desc";
            $res = $mysqli->query($sql) or die(mysqli_error($mysqli));

            while ($row = mysqli_fetch_array($res)) {
                $counter = 0;
                $message = "";
                $color = "transparent";
                $row['league'] = str_replace("Lliga", "", $row['league']);
                $row['league'] = str_replace("de", "", $row['league']);
                $row['league'] = str_replace(">", "", $row['league']);
                $row['league'] = str_replace("Grup", "", $row['league']);
                if ($row['idResult']) {
                    $counter++;
                    if ($row['localResult'] == $row['localGoals']) {
                        $counter++;
                    } else {
                        $message .="Falten " . ($row['localResult'] - $row['localGoals']) . " gols locals per anotar. <br />";
                        $color = "#FFDAB9";
                        //$mysqli->query("delete from player_goals_match where idTeam= ".$row['idLocal']." and idMatch=".$row['id']);
                    }
                    if ($row['visitorResult'] == $row['visitorGoals']) {
                        $counter++;
                    } else {
                        $message .="Falten " . ($row['visitorResult'] - $row['visitorGoals']) . " gols visitants per anotar. <br />";
                        $color = "#FFDAB9";
                        //$mysqli->query("delete from player_goals_match where idTeam= ".$row['idVisitor']." and idMatch=".$row['id']);
                    }
                    if ($row['players'] > 10) {
                        $counter++;
                    } else {
                        $message .="Falten jugadors en alineacions.";
                        $color = "#c00";
                    }
                } else {
                    $message .=" No hi ha resultat ";
                    $color = "transparent";
                }
                if ($counter < 4) {
                    echo "<tr style='background-color:$color;'>";
                     echo "\n\t<td> " . $n . "</td>";
                    echo "\n\t<td> " . $row['status'] . "</td>";
                    echo "\n\t<td>" . substr($row['updateddatetime'], 0, -3) . "</td>";
                    echo "<td>" . $row['league'] . "</td>";
                    // echo "<td>J" . $row['round'] . "</td>";
                    echo "<td>" . $row['local'] . " - " . $row['visitor'] . "</td>";
                    echo "<td>" . $message . "</td>";
                    echo "<td><a target=_blank href='https://www.futsal.cat/competicio/acta/" . $row['id'] . "'>" . $row['id'] . "</a>";
                    echo " <a target=_blank href='https://futsal.playoffinformatica.com/FormEvents.php?accio=edit&mainFrom=/LlistatEvents.php?accio=list&stringIds=" . $row['playOffId'] . "'>" . $row['playOffId'] . "</a></td>";
                    //echo "\n\t<td><a target=_blank href='https://www.futsal.cat/playOff/apiResultats.php?debug=1&idMatch=" . $row['id'] . "'>" . $row['days'] . " dies</a></td>";
                      echo "\n\t<td id='match_".$row['id']."' onClick='updateMatch(".$row['id'].")'>" . $row['days'] . " dies</td>";

                    echo "</tr>";
                    $n++;
                } else {
                    $mysqli->query("update results set checked=1 where idMatch=" . $row['id']);
                }
            }
            ?>
        </table>
    </body>
</html>
