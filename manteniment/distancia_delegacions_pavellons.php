<?php

$username = "pauweb";
$password = "M0nts3rr@t";
$hostname = "localhost";



$dbhandle = mysql_connect($hostname, $username, $password)
        or die("Unable to connect to MySQL");
$selected = mysql_select_db("futsal", $dbhandle)
        or die("Could not select examples");

$delegationsArray = array();
$result = mysql_query("select idDelegation,delegationAddress from delegations");
while ($row = mysql_fetch_array($result)) {
    array_push($delegationsArray, $row);
}


$result = mysql_query("SELECT distinct complexName, id, complexAddress, distance FROM complex c LEFT JOIN complex_to_delegation_distance cd on cd.idComplex=c.id where revisar is null and distance is null order by complexName limit 0,20");
//fetch tha data from the database
//echo "HOLA";
while ($row = mysql_fetch_array($result)) {
    echo "<h3>" . $row['id'] . " " . utf8_encode($row['complexName']) . "</h3>" . $row['complexAddress'] . "<br />";
    foreach ($delegationsArray as $del) {
        echo "<br />";
        $from = utf8_encode($row['complexAddress']);
        $del['delegationAddress'] = utf8_encode($del['delegationAddress']);
        $to = $del['delegationAddress'];
        $from = urlencode($from);
        $to = urlencode($to);
        $data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&language=en-EN&sensor=false");
        $data = json_decode($data);
        //echo "<pre>"; print_r($data);echo "</pre>";
        $km = intval($data->rows[0]->elements[0]->distance->text);
        echo "Inici: " . $row['complexAddress'] . "<br />Final: " . $del['delegationAddress'] . ".<br />Estat:" . $data->status . "<br />KM:" . $km;
        if ($data->status != "OK") {
            mysql_query("update  complex set revisar=1 where id=" . $row['id']) or die(mysql_error());
        } else {
            if ($km == 0) {
                mysql_query("update  complex set revisar=1 where id=" . $row['id']) or die(mysql_error());
            } else {
                $sql = "insert into complex_to_delegation_distance (idComplex,idDelegation,distance) values (" . $row['id'] . "," . $del['idDelegation'] . "," . $km . ")";
                mysql_query($sql) or die(mysql_error());
                mysql_query("update  complex set revisar=0 where id=" . $row['id']) or die(mysql_error());
            }
        }
    }

    echo "<hr />";
}
