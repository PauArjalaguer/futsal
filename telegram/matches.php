<?php
//echo "HOLA";
//exit();

include ("../manteniment/config.php");
include ("../manteniment/funciones.php");
$mysqli=conectar();

    $res1 = $mysqli->query("
    SELECT m.id as idMatch, l.id as idLeague, l.name as league, ro.name as round, t1.name as local, t2.name as visitor, m.updateddatetime, now() ,TIMESTAMPDIFF(HOUR, updateddatetime, now()), d.name as division,ro.id as idRound, now(),localResult, visitorResult FROM  matches m 
 join rounds ro on ro.id=m.idround
 join leagues l on l.id=ro.idleague
 join divisions d on d.id=l.iddivision
 join teams t1 on t1.id=m.idlocal
 join teams t2 on t2.id=m.idvisitor
 JOIN results re ON re.idMatch=m.id
 where updateddatetime<now()  
AND re.datetime > DATE_SUB(NOW(),INTERVAL 5 MINUTE) 
order by updateddatetime desc limit 0,10");

while($row = mysqli_fetch_array($res1)){
	$botToken="582102679:AAFfqOI_ODYfROrOwTk5WZP561KI3dYj9DA";
	$webSite="https://api.telegram.org/bot".$botToken;
	$website = "https://api.telegram.org/bot".$botToken;
	$chat_id="@Futsalcat";
	$message="\xE2\x9A\xBD <b>".$row['local']."</b> ".$row['localResult']." - <b>".$row['visitor']."</b>  ".$row['visitorResult']." / ".dateformatCup($row['updateddatetime'])."   <a href='https://www.futsal.cat/competicio/acta/".$row['idMatch']."'>+ info</a>";
	 $url = $webSite."/sendMessage?parse_mode=html&chat_id=".$chat_id."&text=".urlencode($message);
	file_get_contents($url);
}
	
	
	 $res1 = $mysqli->query("
     SELECT id, title, content, pathimage,insertdate,  DATE_SUB(NOW(),INTERVAL 5 MINUTE) FROM futsal.news 
WHERE insertdate > DATE_SUB(NOW(),INTERVAL 5 MINUTE) and draft!=1
 order by id desc");

  
while($row = mysqli_fetch_array($res1)){
	$botToken="582102679:AAFfqOI_ODYfROrOwTk5WZP561KI3dYj9DA";
	$webSite="https://api.telegram.org/bot".$botToken;
	$website = "https://api.telegram.org/bot".$botToken;
	$chat_id="@Futsalcat";
//print_r($row);
	 $photo="https://www.futsal.cat/images/dynamic/newsImages/".$row['pathimage'];
	// $photo="https://www.google.es/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png";
	 $file_headers = @get_headers($photo);
	 //print_r($file_headers);
	 //echo $photo;
	if($file_headers[0] != 'HTTP/1.0 404 Not Found'){
		$url = $webSite."/sendPhoto?chat_id=".$chat_id."&photo=".urlencode($photo);
		echo $url;
		file_get_contents($url);
	}
	$message="\xF0\x9F\x93\xB0 <b>".$row['title']."</b> / ".dateformatCup($row['insertdate'])."   <a href='http://www.futsal.cat/noticies/detall/".$row['id']."'>+ info</a>";
//echo $message;
	$url = $webSite."/sendMessage?parse_mode=html&chat_id=".$chat_id."&text=".urlencode($message);
//echo "<br/>".$url;
	file_get_contents($url);
}

 $res1 = $mysqli->query("
    select filepath,inserted,  DATE_SUB(NOW(),INTERVAL 5 MINUTE)  from documents d
left join downloadcategories dc on dc.id=d.category
 WHERE inserted > DATE_SUB(NOW(),INTERVAL 5 MINUTE) 
 order by d.id desc
");

  
while($row = mysqli_fetch_array($res1)){
	$botToken="582102679:AAFfqOI_ODYfROrOwTk5WZP561KI3dYj9DA";
	$webSite="https://api.telegram.org/bot".$botToken;
	$website = "https://api.telegram.org/bot".$botToken;
	$chat_id="@Futsalcat";
	$documentUrl="https://www.futsal.cat/content/documentacio/".$row['filepath'];
//print_r($row);
	$message="\xF0\x9F\x93\xB0 <b>".$row['title']."</b> / ".dateformatCup($row['insertdate'])."   <a href='http://www.futsal.cat/noticies/detall/".$row['id']."'>+ info</a>";
//echo $message;
	$url = $webSite."/sendDocument?parse_mode=html&chat_id=".$chat_id."&document=".urlencode($documentUrl);
//echo "<br/>".$url;
	file_get_contents($url);
}



?>