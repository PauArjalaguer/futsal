<?
include "../includes/config.php";
include "../includes/funciones.php";
$idcnx = conectar();

$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];
$sql="Update teams set ";
if(!empty($_GET['day'])){
	$sql .=" playingDay=".$_GET['day'].",";
}
 if(!empty($_GET['time'])){
	$sql .=" playingHour='".$_GET['time']."',";
}
 if(!empty($_GET['complex'])){
	$sql .=" playingComplex=".$_GET['complex'].",";
}
$sql .=" name=name where id=".$_GET['idTeam'];
echo $sql;
mysql_query($sql) or die(mysql_error());
/*
$sql="select m.id, initialDate, endDate, d.datetime from matches m join rounds r on r.id=m.idround 
left join cmptMatchDateChange d on d.idmatch=m.id where idLocal=".$_GET['idTeam']." and idSeason=$lastSeasonId
order by m.id,d.id asc ";
echo $sql."<br />";
$res=mysql_query($sql) or die(mysql_error());
while($row=mysql_fetch_array($res)){
	if($_GET['complex']){
		$sql1="update matches set place=".$_GET['complex']." where id=".$row['id'];
		echo $sql1."<br />";
		mysql_query($sql1) or die(mysql_error());
	}
	if($_GET['day']==7){
		$sql2="update matches set datetime=\"".$row['initialDate']." ".$_GET['time']."\", updateddatetime=\"".$row['initialDate']." ".$_GET['time']."\" where id=".$row['id'];
		echo $sql2."<br />";
		mysql_query($sql2) or die(mysql_error());
	}
	if($_GET['day']==1){
		$sql3="update matches set datetime=\"".$row['endDate']." ".$_GET['time']."\", updateddatetime=\"".$row['endDate']." ".$_GET['time']."\" where id=".$row['id'];
		echo $sql3."<br />";
		mysql_query($sql3) or die(mysql_error());
	}
	if($row['datetime']){
		$sql="update matches set updateddatetime='".$row['datetime']."' where id=".$row['id'];
		mysql_query($sql) or die(mysql_error());
		echo "...->".$sql;
	}

}

 */
?>