<table border="0"><thead><th>Equip</th><th>Equip correcte</th><th>Lliga</th></thead>
<tbody><?php
$username = "pauweb";
$password = "M0nts3rr@t";
$hostname = "localhost";

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
        or die("Unable to connect to MySQL");
$selected = mysql_select_db("futsal", $dbhandle)
        or die("Could not select examples");

$result = mysql_query("select id, name from teams order by name
");
$array = array();
while($row = mysql_fetch_array($result)){
    array_push($array, $row);
}
//print_r($array);
$result = mysql_query("select t.id as idTeam, t.name as teamName,l.id as idLeague,l.name as leagueName, c.name as clubName from teams_leagues_per_season tds
join teams t on t.id=tds.idteam
join leagues l on l.id=tds.idleague
join clubs c on c.id=t.idClub
where tds.idSeason=9
order by clubName, t.name
");
//fetch tha data from the database
while ($row = mysql_fetch_array($result)) {
    echo "\n\t<tr>\n\t<td>".$row['idTeam']. " ".$row['teamName']."</td>";
    echo "\n\t<td><select  onchange=\"if (this.value) window.location.href=this.value\">";
    foreach($array as $team){
        echo "\n\t\t<option value=\"revisioEquipsALligues_modifica.php?idLeague=".$row['idLeague']."&initialTeam=".$row['idTeam']."&team=".$team['id']."\">".$team['name']."</option>";
    }
    echo "</select></td>";
    echo "\n\t<td>".$row['idLeague']." ".$row['leagueName']."</td></tr>";
}
?>
</tbody></table>