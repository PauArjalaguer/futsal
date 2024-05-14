  <?php
            include ("../includes/config.php");
            include ("../includes/funciones.php");
            conectar();
            $sql = "select idplayer, count(*) as c from player_team_season pts
where idseason=8 and statuspercent>80
group by idplayer order by c desc";
            $resClub = mysql_query($sql);
            while ($row = mysql_fetch_array($resClub)) {
			if($row['c']>1){
				$sql2="select pts.id,name, paymentdate, idteam, position from players p join player_team_season pts on pts.idplayer=p.id where idplayer=".$row['idplayer']." and idseason=8";
				//echo $sql2."<br />";
				 $resClub2 = mysql_query($sql2);
				while ($row2 = mysql_fetch_array($resClub2)) {
				echo $row2['id']." ".$row2['name']." ".$row2['idteam']." ".$row2['paymentdate']." ".$row2['position']."<br />";
				}
			}
			}
		?>