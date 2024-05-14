<?php
$username = "pauweb";
$password = "M0nts3rr@t";
$hostname = "localhost";

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
        or die("Unable to connect to MySQL");
$selected = mysql_select_db("futsal", $dbhandle)
        or die("Could not select examples");

$result = mysql_query("
select m.id from matches m
join rounds r on r.id=m.idRound
where idLeague=".$_GET['idLeague']." and idLocal=".$_GET['initialTeam']);
$array = array();
while($row = mysql_fetch_array($result)){
   $sql2="Update matches set idLocal=".$_GET['team']." where idLocal=".$_GET['initialTeam']." and id=".$row['id'];
   mysql_query($sql2);
}


$result = mysql_query("
select m.id from matches m
join rounds r on r.id=m.idRound
where idLeague=".$_GET['idLeague']." and idVisitor=".$_GET['initialTeam']);
$array = array();
while($row = mysql_fetch_array($result)){
   $sql2="Update matches set idVisitor=".$_GET['team']." where idVisitor=".$_GET['initialTeam']." and id=".$row['id'];
 mysql_query($sql2);
}

header("Location: revisioEquipsALligues.php");