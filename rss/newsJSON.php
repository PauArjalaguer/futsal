<? 
header("Content-type: application/json; charset=utf-8");
include ("../manteniment/config.php");
include ("../manteniment/funciones.php");
$mysqli=conectar();
if($_GET['idNew']){$q=" where id=".$_GET['idNew']; }
 $res = $mysqli->query("
    SELECT id, title, content, pathimage,insertdate FROM futsal.news $q order by id desc limit 0,35");
  $json = array();
  $newsArray= array();
while($row=mysqli_fetch_array($res)){	
$text=strip_tags($row['content']);
$s=explode(".",$text);
	$a=array("id"=>$row['id'],"name" =>$row['title'],"summary"=>$s[0].".","image"=>$row['pathimage']);
	array_push($newsArray,$a);
}
		
	
	 print_r(json_encode($newsArray)); ?>