<? 

/*$api_key="e1dc2265c6c775d0b18dd1e8b086d10c";
$secret="9a1fee3df4b9cf39";*/

$api_key="0df858f7d07620ceb376242e418a08a9";
$secret="b71ec74893806bac";

$fr= "http://www.flickr.com/services/auth/?api_key=".$api_key."&perms=write&api_sig=";
$fr .= md5($secret."api_key".$api_key."permswrite");

if(empty($_GET['frob'])){header ("Location: $fr");}

$rest="http://flickr.com/services/rest/?method=flickr.auth.getToken&api_key=".$api_key."&frob=".$_GET['frob']."&api_sig=";

$rest .= md5($secret."api_key".$api_key."frob".$_GET['frob']."methodflickr.auth.getToken");
echo $rest;
//header ("Location: $rest");
$xml=simplexml_load_file($rest);


?>
