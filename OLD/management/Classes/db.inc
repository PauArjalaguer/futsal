<? 
session_start();
$dbconnect  = NULL;

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
  $exists=false;
  //echo "FALS";
}

  
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

?>