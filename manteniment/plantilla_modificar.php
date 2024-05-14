<?php



$username = "pauweb";
$password = "M0nts3rr@t";
$hostname = "localhost";

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
        or die("Unable to connect to MySQL");
$selected = mysql_select_db("futsal", $dbhandle)
        or die("Could not select examples");
mysql_query("update league_patterns set ".$_GET['type']." = " . $_GET['value'] . " where id=" . $_GET['idMatch']);
?>