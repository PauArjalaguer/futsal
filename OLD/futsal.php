<? 
$t=explode("-",$_GET['title']);
$id=$t[0];
$res=mysql_query("select id, title,text from futsal where id=".$id);
$row=mysql_fetch_array($res);
echo "<div class=\"newHeader\"><h1 id=\"sectionTitle\"> <span style='color:#600;'>></span> ".$row['title']."</h1></div>
<p  class=\"Container\"><br />".nl2br($row['text'])."</p>";
?>
<div class="newsButtonLine" >
    <a href='<? echo $_SERVER['HTTP_REFERER']; ?>'>
        <img src="<? echo $serverUrl; ?>webImages/back.png" alt="Enrere" title="Enrere"  />
    </a>
</div>
