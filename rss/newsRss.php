<? header("Content-Type: text/xml");
$salida ="<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
$salida .="<rss version=\"0.92\" >\n";
$salida .="<channel>\n";
$salida .="\t<title>Federacio Catalana de Futbol Sala</title>\n";
$salida .="\t<link>http://www.futsal.cat</link>\n";
$salida .="\t<description>Federacio Catalana de Futbol Sala</description>\n";
//$salida .="\t<pubDate>Mon, 21 Dic 2009 04:00:00 GMT</pubDate>\n";
$salida .="\t<managingEditor >futsal@futsal.cat (Pau Arjalaguer)</managingEditor>\n";
$salida .="\t<webMaster>pau@arjalaguer.cat (Pau Arjalaguer)</webMaster>\n";
include ("../manteniment/config.php");
include ("../manteniment/funciones.php");
$mysqli=conectar();
 $res1 = $mysqli->query("
    SELECT id, title, content, pathimage,insertdate FROM futsal.news order by id desc limit 0,15");
  while ($row = mysqli_fetch_array($res1)) {
		$salida .= "<item>\n<title>".stripslashes($row['title'])."</title>\n";
		$salida .= "<link>https://www.futsal.cat/noticies/detall/".$row['id']."</link>\n<description><![CDATA[";
		if(!empty($row['pathimage'])){$salida .="<p style=\"padding:6px;\"><img src=\"https://www.futsal.cat/images/dynamic/newsImages/".$row['pathimage']."\" > </p> ";
		}
		$row['content']=strip_tags($row['content']);
		$row['content']=str_replace("[salta]","",$row['content']);
		$row['content']=str_replace("[img]","</p><div align=center><div class='news_image'><img src='http://www.futsal.cat/images/dynamic/newsImages/",$row['content']);
		$row['content']=str_replace("[/img]","' alt='Futsal.cat' width='460'/></div></div><br /><p class=\"newFullText\">",$row['content']);
		$row['content']=str_replace("[salta]"," ",$row['content']);
		$d=strtotime($row['insertdate']);
		
		//$salida .="".utf8_encode(nl2br(strip_tags(stripslashes($noticia[2]),"<img>")))."]]></description>\n<pubDate>".date("D", $d)."," .date("d", $d)." " .date("M", $d)." ".date("Y", $d)." 12:00:00 GMT</pubDate>\n</item>\n";
		$salida .="".nl2br(strip_tags(stripslashes($row['content']),"<img>"))."]]></description>\n<pubDate>".date("r", strtotime($row['insertdate']))."</pubDate>\n\n<guid>https://www.futsal.cat/noticies/detall/".$row['id']."</guid></item>\n";
$conta++;}


$salida .="</channel>\n</rss>";
echo $salida;
		
		
	 ?>