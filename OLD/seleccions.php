<? 
$url=explode("-",$_GET['title']);
$id=$url[0];
$res=mysql_query("select id, name, text from selections where id=".$id);
	$row=mysql_fetch_array($res);
?>
<div class="newHeader"><h1 id="sectionTitle"><span style='color:#600;'>></span> Selecció <? echo $row['name']; ?></h1></div>

<div class="newContainer">
<p><? echo $row['text']; ?></p>
</div>
<div class="newsButtonLine" ><a href='<? echo $_SERVER['HTTP_REFERER']; ?>'><img src="<? echo $serverUrl; ?>webImages/back.png" alt="Enrere" title="Enrere"  /></a></div>

