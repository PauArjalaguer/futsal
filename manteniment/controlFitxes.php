<table cellpadding="6" cellspacing="0" width="100%"><?php
    include ("config.php");
    include ("funciones.php");
    conectar();

    if ($_POST['submit']) {
        //$sql = "Insert into results values (null," . $_POST['local'] . "," . $_POST['visitor'] . "," . $_POST['match'] . ",1,now(),null)";
        $sql = "update player_team_season set position=" . $_POST['position'] . " where id=" . $_POST['id'];
        //print_r($_POST);
        mysql_query($sql);
    }

    $sql = "select distinct dni, pts.id,c.name as club,t.name as team,p.name as player, birthdate, pts. position, YEAR(CURDATE())-YEAR(birthdate)  as edat, minAge, maxAge from players p
join player_team_season pts on pts.idplayer=p.id
join teams t on t.id=pts.idTeam
join clubs c on c.id=t.idClub
join playerPositions pp on pp.id=pts.position
join teams_divisions_per_season tds on tds.idteam=t.id and tds.idSeason=pts.idSeason
join divisions d on d.id=tds.idDivision
where pts.idSeason=10
order by c.name, t.name, pp.position,birthdate";

    $res = mysql_query($sql) or die(mysql_error());
    while ($row = mysql_fetch_array($res)) {
        echo "\n\t<tr>";
        if ($row['edat'] >= $row['minAge'] and $row['edat'] <= $row['maxAge']) {
            $s2 = "";
        } else {
            $s2 = " color:#c00; ";
        }
        if ($t != $row['team']) {
            $s = " border-top:1px solid #242424; ";
        } else {
            $s = "";
        }
        echo "\n\t\t<td style='$s $s2'>" . $row['club'] . "</td>";
        echo "\n\t\t<td style='$s $s2'>" . $row['team'] . "</td>";
        echo "\n\t\t<td style='$s $s2'>" . $row['player'] . "</td>";
        echo "\n\t\t<td style='$s $s2'>" . $row['birthdate'] . "</td>";
        echo "\n\t\t<td style='$s $s2'>" . $row['edat'] . " (" . $row['minAge'] . "-" . $row['maxAge'] . ")</td>";

        echo "\n\t\t<form action=\"controlFitxes.php\" method=\"post\">";
        echo "\n\t\t<td style='$s $s2'><input type=hidden name=id value=" . $row['id'] . "><select name='position'>";
        echo "<option ";
        if ($row['position'] == 2) {
            echo "selected";
        }
        echo " value=2>Jugador</option>";
        echo "<option ";
        if ($row['position'] == 3) {
            echo "selected";
        }
        echo " value=3>Entrenador</option>";

        echo "<option ";
        if ($row['position'] == 4) {
            echo "selected";
        }
        echo " value = 4>Delegat</option>";
        echo "<option ";
        if ($row['position'] == 5) {
            echo "selected";
        }
        echo " value = 5>Auxiliar</option>";

        echo "</select></td>";
        echo "\n\t\t<td style='$s $s2'><input type = \"submit\" name=\"submit\" value=\"Enviar\"></form></td>";
        echo "\n\t</tr>";
        $t = $row['team'];
    }
    ?>
</table>