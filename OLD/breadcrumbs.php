<div id="breadcrumbs" style="padding:3px; font-size:10px;"><?
	if(!empty($_GET['f']) and $_GET['f']!='news_inicial'){
 		echo "<a href='index.php'>Inici</a> » <a href='?f=".$_GET['f']."'>".ucwords($_GET['f'])."</a>";
	}
	
?>
</div>
 	