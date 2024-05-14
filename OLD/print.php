<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: Federaci&oacute; Catalana de Futbol Sala ::</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<link rel="stylesheet" type="text/css" href="css/greay_css.css" />

<link rel="alternate" type="application/rss+xml" title="Federació Catalana de Futbol Sala - Noticies" href="http://www.futsal.cat/rss/newsRss.php" />
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="scripts/scripts.js"></script>
<link rel="shortcut icon" href="webImages/favicon.ico" />
</head>

<body style="padding:5px;">
<? 
include ("includes/db.inc");
include("Classes/News_class.php");
include ("includes/funciones.php");

$news=new News;
$news->tablename="news";
$news->order="id desc";
$news->fields="Id,Title,Content,PathImage,InsertDate";
$news->pageno=$_GET['p'];
$news->rows_per_page=3;
$data=$news->getNewById(" id=".$_GET['id']);
foreach($data as $noticia){
	
	echo "\n\t<h2 class=\"newDetailTitle\">".$noticia[1]."</h2>";
	echo "\n\t<h3 class=\"newDate\">". dateformat($noticia[4])."</h3>";
	if(!empty($noticia[3])){
		echo "\n\t<p class=\"newFullImage\"><img src=\"newsImages/".$noticia[3]."\" width=\"300\" /></p>";
	}
	$noticia[2]=str_replace("[img]","</p><div align=center><div class='news_image'><img src='newsImages/",$noticia[2]);
	$noticia[2]=str_replace("[/img]","' alt='Futsal.cat'/></div></div><p class=\"newFullText\">",$noticia[2]);
	echo "\n\t<p class=\"newFullText\">".nl2br($noticia[2])."</p>";}
?>
<p style="font-weight:bold; text-align:center; margin-top:20px; font-size:14px;">&copy; 2009 Federacio Catalana de Futbol Sala www.futsal.cat</p>

