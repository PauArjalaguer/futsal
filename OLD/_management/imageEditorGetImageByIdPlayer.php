<?
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$sql="select image from players where id=".$_GET['idPlayer'];

$res = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($res);
echo $row['image'];
mysql_close();
?>