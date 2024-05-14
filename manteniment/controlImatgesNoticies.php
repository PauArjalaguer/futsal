<?php
include "config.php";
include "funciones.php";
$mysqli = conectar();
$sql = "select id, title, pathimage from news";
$res = $mysqli->query($sql) or die(mysqli_error($mysqli));
while ($row = mysqli_fetch_array($res)) {
	if(file_exists("../images/dynamic/newsImages/".$row['pathimage'])){
		echo $row['id']." ".$row['title']." ".$row['pathimage']."<br />";
	}else{
	$sql2="update news set pathimage='1560.jpg' where id=".$row['id'];
	$mysqli->query($sql2) ;
	echo "$sql2 <br />";
	}
}
			?>