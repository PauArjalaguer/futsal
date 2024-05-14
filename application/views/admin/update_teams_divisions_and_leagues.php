<?
include ("config.php");
include ("funciones.php");
$idcnx = conectar();
$idSeason=9;
mysql_query("delete from teams_leagues_per_season where idSeason=$idSeason");

mysql_query("delete from teams_divisions_per_season where idSeason=$idSeason");
$sql="select distinct idLocal, idLeague, idDivision 
from matches m
join rounds r on r.id=m.idRound
left join leagues l on l.id=r.idLeague
where r.idSeason=9";
$res = mysql_query($sql);
while ($row = mysql_fetch_array($res)) {
	mysql_query("Insert into teams_leagues_per_season values (".$row['idLocal'].",".$row['idLeague'].",".$idSeason.",null)") or die(mysql_error());
		mysql_query("Insert into teams_divisions_per_season values (".$row['idLocal'].",".$row['idDivision'].",".$idSeason.",1,'2017-09-23 00:00:00)") or die(mysql_error());
}