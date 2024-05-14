<?php

include "../includes/config.php";
include "../includes/funciones.php";
$idcnx = conectar();

$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];

$sql = "select * from leagues where id=".$_GET['idLeague'];
$res = mysql_query($sql);
$row = mysql_fetch_array($res);
//print_r($row);

$sql = "delete from matches where idround in (select id from rounds where idLeague=".$_GET['idLeague'].")";
//echo $sql;
$res = mysql_query($sql) or die(mysql_error());

$sql  ="delete from rounds where idLeague=".$_GET['idLeague'];
echo $sql;
$res = mysql_query($sql) or die(mysql_error());

$fp = fopen("calendari.csv", "r");

echo $row['name'];

while (( $data = fgetcsv($fp, 1000, ",")) !== FALSE) { // Mientras hay líneas que leer...
    $i = 1;
    foreach ($data as $row) {
       $r = explode(";", $row);
	    $r[0]=trim($r[0]);
		$r[2]=trim($r[2]);
       if(preg_match('/Jornada/', $r[0])){	  
			$round = str_replace("Jornada:","",$r[0]);
			echo "<br />JORNADA ". $round.".<hr />";
			$sql  ="insert into  rounds (name, idSeason, idLeague) values ('".$round."',$lastSeasonId, ".$_GET['idLeague'].")";
			//echo $sql;
			$res = mysql_query($sql);
			$round=mysql_insert_id();
			
			
	   }else{
			
			//echo $r[0]."-".$r[2]."<br />";
			
			$sql  ="select id from teams where name ='".$r[0]."'";
			//echo $sql;
			$res = mysql_query($sql) or die(mysql_error());
			$row = mysql_fetch_array($res);
			$team1Id=$row['id'];
			
			$sql  ="select id from teams where name ='".$r[2]."'";
			//echo $sql;
			$res = mysql_query($sql) or die(mysql_error());
			$row = mysql_fetch_array($res);
			$team2Id=$row['id'];
			
			//echo $team1Id." ".$r[0]."--".$team2Id." ".$r[2]."<br />";
			if($team1Id and $team2Id){
				$sql="insert into matches (idLocal, idVisitor, idRound, statusId,updateddatetime) values ($team1Id, $team2Id, $round,4,null)";
				//echo $sql."<br />";
				$res = mysql_query($sql) or die(mysql_error());
				echo "Insertat el partit ".$team1Id." ".$r[0]."--".$team2Id." ".$r[2]."<br />";
			}else{
				echo "Hi ha algún error en el partit". $team1Id." ".$r[0]."--".$team2Id." ".$r[2]."<br />";
			}
			
	   }
    }
}
fclose($fp);
?>
