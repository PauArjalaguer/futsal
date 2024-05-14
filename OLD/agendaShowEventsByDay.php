<?
Header("Cache-control: private, no-cache");

Header("Pragma: no-cache");
echo $_GET['day']." ".$_GET['month'];
include ("includes/config.php");
		 	include ("includes/funciones.php");
			conectar();
$res=mysql_query("select * from calendar where dayofmonth(datetime)=".$_GET['day']." and month(datetime)=".$_GET['month']);
while($row=mysql_fetch_array($res)){
echo "&bull; ".$row['name']."<br>";
}
?>