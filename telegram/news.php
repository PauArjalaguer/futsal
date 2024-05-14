<?

include ("../manteniment/config.php");
include ("../manteniment/funciones.php");
$mysqli=conectar();
$r=rand(0,100);
    $res1 = $mysqli->query("
    SELECT id, title, content, pathimage,insertdate FROM futsal.news order by id desc limit $r,15");

    $row = mysqli_fetch_array($res1);
	$botToken="582102679:AAFfqOI_ODYfROrOwTk5WZP561KI3dYj9DA";
$webSite="https://api.telegram.org/bot".$botToken;
$website = "https://api.telegram.org/bot".$botToken;
$chat_id="@Futsalcat";
//print_r($row);
$message="\xF0\x9F\x93\xB0 <b>".$row['title']."</b> / ".dateformatCup($row['insertdate'])."   <a href='http://v3.futsal.cat/noticies/detall/".$row['id']."'>+ info</a>";
//echo $message;
$url = $webSite."/sendMessage?parse_mode=html&chat_id=".$chat_id."&text=".urlencode($message);
//echo "<br/>".$url;
file_get_contents($url);
	
?>