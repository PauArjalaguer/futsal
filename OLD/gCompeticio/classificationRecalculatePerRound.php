<?
include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx = conectar();
$sql = "
   select ro.id, idLeague, idSeason from results re
join matches m on m.id=re.idmatch
join rounds ro on ro.id=m.idround
where idseason=8
order by ro.id 
";
$res = mysql_query($sql);
while ($row = mysql_fetch_array($res)) {
	$idRound=$row['id'];
	$idLeague = $row['idLeague'];
	$idSeason= $row['idSeason'];

	echo "<hr />ELIMINO LLIGA SEGONS JORNADA";
	$sql="delete from classification_V2 where idRound=$idRound and idLeague=$idLeague";
	echo $sql."<br />";
	mysql_query($sql);
	
	echo "<br />Selecciono tots els equips de la lliga";
	$sql2 = "select t.id as idTeam, t.name from teams_leagues_per_season td join teams t on t.id=td.idTeam where idLeague=$idLeague ";
	$res2 = mysql_query($sql2);
	while ($row2 = mysql_fetch_array($res2)) {
		$idTeam=$row2['idTeam'];
		echo "<br />-> Selecciono dades de classificació de l' equip ".$row2['idTeam']." - ".$row2['name'];
		$sql3 = "select m.idLocal,m.idVisitor, re.localResult,re.visitorResult from results re join matches m on m.id=re.idMatch join rounds r on m.idround=r.id where (idLocal=$idTeam or idVisitor=$idTeam) and r.idSeason=$idSeason and r.idLeague=$idLeague and r.id<=$idRound order by idmatch";
		$res3 = mysql_query($sql3);
			$draws = 0;
			$wins = 0;
			$loses = 0;
			$goalsF = 0;
			$goalsC = 0;
			$playedMatches = 0;
		while ($row3 = mysql_fetch_array($res3)) {
			 echo "<br >Resultats de ".$row2['name']."<br />".$sql3."<br />";
		
			
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
		$points = ($wins*3)+$draws;
		$sql4="insert into classification_V2 (idTeam, idLeague, playedMatches, wonMatches, drawMatches,lostMatches,goalsMade,goalsReceived, idRound, points) values ($idTeam,$idLeague,$playedMatches,$wins,$draws,$loses,$goalsF,$goalsC,$idRound, $points)";
		echo "<br />".$sql4;
		
		mysql_query($sql4) or die(mysql_error());
		
		$a = 1;	
		$sql5 = "SELECT idteam from classification_V2 where idRound=$idRound ORDER BY points DESC";
		echo "<br />".$sql5;
		$res5 = mysql_query($sql5);
		while($row5= mysql_fetch_array($res5)){
			$sql6 = "UPDATE classification_V2 set position=$a where idLeague=$idLeague and idRound=$idRound and idTeam=" . $row5['idteam'];	
			mysql_query($sql6);
			echo "<br />".$sql6;
		$a++;	}	
		
	}
}
	?>