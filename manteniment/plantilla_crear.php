<?php
$username = "pauweb";
$password = "M0nts3rr@t";
$hostname = "localhost"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");
$selected = mysql_select_db("futsal",$dbhandle) 
  or die("Could not select examples");

$numberOfRounds=($_POST['equips']-1)*2;
$numberOfMatches=$_POST['equips']/2;
$matches= $numberOfRounds*$numberOfMatches;
mysql_query("delete from league_patterns where idPattern=".$_POST['equips']);
$r=1;
for($a=1; $a<=$matches; $a++){
    
    if($n==$numberOfMatches){ $r++; $n=0;}
    $sql="Insert into league_patterns values (null,".$_POST['equips'].", $r,0,0)";
  $n++;
//echo $sql."<br />";  
  mysql_query($sql) or die(mysql_error());
}
header ("Location: plantilla_editar.php?idPattern=".$_POST['equips']);
?>