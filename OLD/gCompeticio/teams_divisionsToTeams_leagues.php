<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx = conectar();
$sql = "
    select t.name as team, l.name as league, tls.idteam, tls.idleague, tls.idSeason, l.idDivision from teams_leagues_per_season tls
        join teams t on t.id=tls.idteam
        join leagues l on l.id=tls.idleague
        join championship c on c.id=l.idchampionship where championshiptype=1 and idDivision!=0 order by idteam, idleague";
$res = mysql_query($sql);
while ($row = mysql_fetch_array($res)) {
    echo "$n equip: " . $row['team'] . " lliga: " . $row['league'] . " idEquip: " . $row['idteam'] . " idLliga: " . $row['idleague'] . " idSeason: " . $row['idSeason'] . " idDivisio: " . $row['idDivision'] . "<br />";
    $sql2 = "SELECT * from teams_divisions_per_season where idteam=" . $row['idteam'] . " and idDivision=" . $row['idDivision'] . " and idSeason=" . $row['idSeason'];
    echo $sql2."<br />";
    $res2 = mysql_query($sql2);
    if (mysql_num_rows($res2) == 0) {
        $sql3 = "INSERT INTO teams_divisions_per_season (idTeam, idDivision, idSeason) values (" . $row['idteam'] . "," . $row['idDivision'] . "," . $row['idSeason'] . ")";
        mysql_query($sql3);
        echo $sql3 . "<br />";
    }
    echo "<br /><hr>";
}
?>
