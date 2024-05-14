<?php
$username = "pauweb";
$password = "M0nts3rr@t";
$hostname = "localhost";

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
        or die("Unable to connect to MySQL");
$selected = mysql_select_db("futsal", $dbhandle)
        or die("Could not select examples");
$result = mysql_query("SELECT distinct idPattern FROM league_patterns order by idPattern");
//fetch tha data from the database
while ($row = mysql_fetch_array($result)) {
    echo "<a href='plantilla_editar.php?idPattern=" . $row['idPattern'] . "'>Plantilla de " . $row['idPattern'] . " equips. </a><br />";
}
?>

<form action="plantilla_crear.php" method="post">
    <p>Equips: <input type="text" name="equips" /></p> 
    <p><input type="submit" /></p>
</form>