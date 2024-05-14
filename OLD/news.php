<h1 id="sectionTitle">Notícies</h1>
<script type="text/javascript">
	var flashvars={ rotul:"Notícies"};
	var params = { allowfullscreen : "true", wmode : "transparent", id : "myplayer", name : "myplayer" };
	var attributes ={};
	swfobject.embedSWF("Rotul.swf", "sectionTitle", "630", "30", "9.0.0", null, flashvars, params,attributes);    
</script>
<div class="newContainer">
<? conectar();

$sql="select  * from news order by id desc limit 0,5";
$res=mysql_query($sql);
while($row=mysql_fetch_array($res)){
	
	echo "\n\t<h2 class=\"newTitle\"><a href='?f=news_detail&id=".$row['Id']."&title=".urlencode($row['Title'])."'>".$row['Title']."</a></h2>";
	echo "\n\t<h3 class=\"newDate\">Data: ".$row['InsertDate']."</h3>";
	if(strlen($row['Content'])>500){
		$link="<a href='?f=news_detail&id=".$row['Id']."&title=".urlencode($row['Title'])."'>[[Més]]</a>";
	}
	if(!empty($row['PathImage'])){
		$paragraf="anewText";
	}else{
		$paragraf="anewFullText";
	}
	echo "\n\t<p class=\"$paragraf\">".substr($row['Content'],0,500)." $link</p>";
	
	if(!empty($row['PathImage'])){
		echo "\n\t<p class=\"newImage\"><img src=\"newsImages/".$row['PathImage']."\" width=\"100\" /></p>";
	}
	echo "<div class=\"newSpacer\">&nbsp;</div>";
}
?>
</div>
                   