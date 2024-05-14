<? 
$file = $_GET["file"];  
$filename = basename($file);  
header("Content-type: application/octet-strem");  
header("Content-Transfer-Encoding: binary");  
header("Content-length: ".filesize($file));  
header("Content-Disposition: attachment; filename=$filename");  
readfile($file); 

?>