<?
header('Content-type: text/xml');
header('Pragma: public');
header('Cache-control: private');
header('Expires: -1');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
echo "\n\t<complexes>\n\t\t<pavello>\n\t\t\t<id>0</id>\n\t\t\t<name>__</name>\n\t\t</pavello>";
include "../includes/config.php";
include "../includes/funciones.php";
$idcnx = conectar();

$sql="select distinct  complexName, id from complex where 
       (complexName like '%".$_GET['word']."%' or complexAddress like'%".$_GET['word']."%') order by complexname";
	   $res =mysql_query($sql) or die(mysql_error());	   
	   while($row=mysql_fetch_array($res)){
			echo "\n\t\t<pavello>";
			echo "\n\t\t\t<id>".$row['id']."</id>";
			echo "\n\t\t\t<name>".utf8_encode($row['complexName'])."</name>";
			echo "\n\t\t</pavello>";
		}
	echo "\n\t</complexes>";	
	   
	   ?>