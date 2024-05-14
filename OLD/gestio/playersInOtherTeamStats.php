<? /*header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"filename.xlsx\"");
header("Cache-Control: max-age=0"); */?>
<table><?php
    include ("../includes/config.php");
    include ("../includes/funciones.php");
    conectar();
    $res = mysql_query("select idPlayer, idTeam, position, birthdate, image,dni, dniscan,address, addressnumber, floor, door, city, province, cp, nif, nationality, countryofbirth, cityofbirth, provinceofbirth, firstname, surname, insurancescan from player_team_season pts 
    join players p on p.id=pts.idplayer
where idseason=8 and ispayed=1");
    while ($row = mysql_fetch_array($res)) {
        $sql2 = "select mp.idMatch,t.id as idteam,t.name as teamname,t.idclub,d.id as iddivision, d.name as divisionname, tds.idseason, 
(select yellowCards from player_card_match where idplayer=mp.idplayer and idmatch=mp.idmatch) as yellow,
(select blueCards from player_card_match where idplayer=mp.idplayer and idmatch=mp.idmatch) as blue,
(select number from player_goals_match where idplayer=mp.idplayer and idmatch=mp.idmatch limit 0,1) as goals,
(select own from player_goals_match where idplayer=mp.idplayer and idmatch=mp.idmatch limit 0,1) as own
from matches_players mp 
join matches m on m.id=mp.idmatch
join rounds r on r.id=m.idround
join teams t on t.id=mp.idteam
join teams_divisions_per_season tds on tds.`idTeam`=t.id and tds.idseason=r.idseason
join divisions d on d.id=tds.iddivision
where r.idseason=8 and mp.idteam!=" . $row['idTeam'] . " and mp.idplayer=" . $row['idPlayer'];
        //echo $sql2 . "<br />";
        $res2 = mysql_query($sql2);
        while ($row2 = mysql_fetch_array($res2)) {
            echo "\n<tr>\n\t<td>" . $row['idPlayer'] . "</td>";
            echo "\n\t<td>" . $row['position'] . "</td>";
            echo "\n\t<td><td>" . $row['firstname'] . "</td>";
            echo "\n\t<td>" . $row['surname'] . "</td>";
            echo "\n\t<td>" . $row['birthdate'] . "</td>";
            echo "\n\t<td>" . $row['image'] . "</td>";
            echo "\n\t<td>" . $row['dni'] . "</td>";
            echo "\n\t<td>" . $row['dniscan'] . "</td>";
            echo "\n\t<td>" . $row['address'] . "</td>";
            echo "\n\t<td>" . $row['addressnumber'] . "</td>";
            echo "\n\t<td>" . $row['floor'] . "</td>";
            echo "\n\t<td>" . $row['door'] . "</td>";
            echo "\n\t<td>" . $row['city'] . "</td>";
            echo "\n\t<td>" . $row['province'] . "</td>";
            echo "\n\t<td>" . $row['cp'] . "</td>";
            echo "\n\t<td>" . $row['nationality'] . "</td>";
            echo "\n\t<td>" . $row['countryofbirth'] . "</td>";
            echo "\n\t<td>" . $row['cityofbirth'] . "</td>";
            echo "\n\t<td>" . $row['provinceofbirth'] . "</td>";
            echo "\n\t<td>" . $row['insurancescan'] . "</td>";
            echo "\n\t<td>" . $row2['idteam'] . "</td>";
            echo "\n\t<td>" . $row2['teamname'] . "</td>";
            echo "\n\t<td>" . $row2['idclub'] . "</td>";
            echo "\n\t<td>" . $row2['iddivision'] . "</td>";
            echo "\n\t<td>" . $row2['divisionname'] . "</td>";
            echo "\n\t<td>" . $row2['yellow'] . "</td>";
            echo "\n\t<td>" . $row2['blue'] . "</td>";
            echo "\n\t<td>" . $row2['goals'] . "</td>";
            echo "\n\t<td>" . $row2['own'] . "</td>";
            echo "\n\t<td>" . $row2['idMatch'] . "</td>\n</tr>";
        }
    }
    ?>
</table>