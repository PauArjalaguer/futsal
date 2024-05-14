<?php
setcookie("numberOfThumbs", $_GET['n'], time() + (3600 * 24*365), "/");
$referer=$_SERVER['HTTP_REFERER'];
header ("Location: $referer");
?>
