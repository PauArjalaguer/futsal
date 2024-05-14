<?php

include "config.php";
include "funciones.php";
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
		//echo "<pre>";print_r($r);echo "</pre>";
		
		echo "Equip Local: ".$r[0]. " - Equip visitant: ".$r[2]. " <br />Resultat: ".$r[1]. " <br />".$r[5]." Data ".$r[3]." a les ".$r[4];
	}
}
fclose($fp);
?>
