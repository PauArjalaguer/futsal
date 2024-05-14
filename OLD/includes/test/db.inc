<? 
session_start();
$dbconnect  = NULL;

/*$dbhost     = "212.36.74.251";
$dbusername = "pauarjalaguer";
$dbuserpass = "kulick";*/
$dbhost     = "localhost";
$dbusername = "myfutsal";
$dbuserpass = "M0nts3rr@t";


$query      = NULL;

function db_connect($dbname)
{

if (isset($_SESSION['auth'])){

  $exists=true;
  //echo "HOLA";
}else{
  $exists=true;
  //echo "FALS";
}

  if($exists){
   global $dbconnect, $dbhost, $dbusername, $dbuserpass;
   
   if (!$dbconnect) $dbconnect = mysql_connect($dbhost, $dbusername, $dbuserpass);
   if (!$dbconnect) {
      return 0;
   } elseif (!mysql_select_db($dbname)) {
      return 0;
   } else {
      return $dbconnect;
   } // if
   }
} 

?>