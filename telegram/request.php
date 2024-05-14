<?php

$botToken="582102679:AAFfqOI_ODYfROrOwTk5WZP561KI3dYj9DA";
$webSite="https://api.telegram.org/bot".$botToken;

$website = "https://api.telegram.org/bot".$botToken;
 
$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);
$modo = 0;
 
$chatId = $update["message"]["chat"]["id"];
$chatType = $update["message"]["chat"]["type"];
$userId = $update["message"]['from']['id'];
$firstname = $update["message"]['from']['username'];
$response="Bona tarda";
 $message = $update["message"]["text"];
 sendMessage($chatId,$response);
 
 function sendMessage($chatId, $response, $keyboard = NULL){
  
    $url = $GLOBALS[website].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response);
    file_get_contents($url);
}

 
 
?>