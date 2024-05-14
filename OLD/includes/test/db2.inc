<? 


/*$dbhost     = "212.36.74.251";
$dbusername = "pauarjalaguer";
$dbuserpass = "kulick";*/


$query      = NULL;

function db_connect($dbname)
{
$dbhost     = "localhost";
$dbusername = "myfutsal";
$dbuserpass = "M0nts3rr@t";
   global $dbconnect, $dbhost, $dbusername, $dbuserpass;
  
   if (!$dbconnect) $dbconnect = mysql_connect("localhost", "myfutsal", "M0nts3rr@t");
   if (!$dbconnect) {
      return 0;
   } elseif (!mysql_select_db($dbname)) {
      return 0;
   } else {
      return $dbconnect;
   } // if
   
} 

?>