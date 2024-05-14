<?php
	include ("includes/db.inc");
	include("Classes/News_class.php");
	include("includes/config.php");
	include ("includes/funciones.php");
	conectar();
	mysql_query("update news set send=send+1 where id=".$_GET['idNew']);
	mysql_query("insert into mailingList (mail) values ('".$_GET['receiverMail']."')");
	$correu="futsal@futsal.cat";
  	$sendTo = $_GET['receiverMail'];

  	$headers = "MIME-Version: 1.0\r\n";
 	 $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
  
  $headers .= "From: " ;
  $headers .= "<" . $correu . ">\r\n";
  $headers .= "Reply-To: " . $correu;
  $message = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
<title>:: Federaci&oacute; Catalana de Futbol Sala ::</title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"http://www.futsal.cat/css/css.css\" />";
	$news=new News;
	$news->tablename="news";
	$news->order="id desc";
	$news->fields="Id,Title,Content,PathImage,InsertDate";
	$news->pageno=$_GET['p'];
	$news->rows_per_page=3;
	$data=$news->getNewById(" id=".$_GET['idNew']);
	//echo "...................".$_GET['idNew'];
	foreach($data as $noticia){
	$message .="<a href='http://www.futsal.cat/news_detail.php?id=".$_GET['idNew']."'>Veure en web</a><br>";
	
	$message .= "\n\t<h2 class=\"newDetailTitle\">".$noticia[1]."</h2>";
	$message .= "\n\t<h3 class=\"newDate\">". dateformat($noticia[4])."</h3>";
	if(!empty($noticia[3])){
		$message .= "\n\t<p class=\"newFullImage\"><img src=\"http://www.futsal.cat/newsImages/".$noticia[3]."\" width=\"300\" /></p>";
	}
	$noticia[2]=str_replace("[img]","</p><div align=center><div class='news_image'><img src='newsImages/",$noticia[2]);
	$noticia[2]=str_replace("[/img]","' alt='Futsal.cat'/></div></div><p class=\"newFullText\">",$noticia[2]);
	$message .= "\n\t<p class=\"newFullText\">".nl2br($noticia[2])."</p>";}
	$message .="
<p style=\"font-weight:bold; text-align:center; margin-top:20px; font-size:14px;\">&copy; 2009 Federacio Catalana de Futbol Sala www.futsal.cat</p>";
  
  $subject=$_GET['senderName']." t'ha enviat una noticia des de www.futsal.cat";
  mail($sendTo, $subject, $message, $headers);
 
  echo "<div style=\"background-image:url(webImages/webBackground.jpg); text-align:right; font-size:8px; padding:0px 3px 0px 3px;\"><span onClick=\"closePopUp();\" class=\"button\">X</span></div><div style='padding:15px; font-size:14px;'>Missatge enviat a ".$_GET['receiverMail']."</div>";
?>