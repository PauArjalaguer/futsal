<?php

 include "config.php";
        include "funciones.php";
        $mysqli = conectar();
$idSeason = 10;
 $mysqli->query("delete from teams_leagues_per_season where idSeason=$idSeason");
 $mysqli->query("delete from teams_divisions_per_season where idSeason=$idSeason");
$sql = "select distinct idLocal, idLeague, idDivision 
from matches m
join rounds r on r.id=m.idRound
left join leagues l on l.id=r.idLeague
where r.idSeason=$idSeason and l.name not like '%Copa%'";
$res =  $mysqli->query($sql);
while ($row = mysqli_fetch_array($res)) {
   $mysqli->query("Insert into teams_leagues_per_season values (" . $row['idLocal'] . "," . $row['idLeague'] . "," . $idSeason . ",null)") or die(mysql_error());
   $mysqli->query("Insert into teams_divisions_per_season values (" . $row['idLocal'] . "," . $row['idDivision'] . "," . $idSeason . ",1,now())") or die(mysql_error());
}