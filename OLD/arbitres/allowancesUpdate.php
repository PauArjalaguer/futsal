<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
echo "<table cellspacing=0 cellpadding=6><tr><td>IdPartit</td><td>Arbitre</td><td>KM</td><td>Data original</td><td>Dia</td><td>Modificada</td><td>Dia</td><td>Hora</td><td>Dieta</td></tr>";
conectar ();
$sql = "select m.id,r.name, km, allowance, datetime, date_format(datetime, '%W'), date_format(datetime,'%w') as dtDay, updateddatetime, date_format(updateddatetime, '%w') as udtDay from cmptMatch_Referee cmr
    join rfrReferees r on cmr.idreferee=r.id
    join matches m on m.id=cmr.idmatch";
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($res)) {
$allowance=0;

    if ($row['updateddatetime'] == "0000-00-00 00:00:00") {
        $msg="no actualitzada";
        $day = $row['dtDay'];
        $h = explode(" ", $row['datetime']);
        $hour = $h[1];
        $hour=substr($hour,0,5);
        $hour=str_replace(":","",$hour);
    } else {
        $msg="actualizada";
        $day = $row['udtDay'];
        $h = explode(" ", $row['updateddatetime']);
        $hour = $h[1];
        $hour=substr($hour,0,5);
         $hour=str_replace(":","",$hour);
    }
   

    if($day==6){
        if($hour>='600' && $hour<='959'){
            $allowance=5;
        }
        if($hour>='1300' && $hour <='1529'){
            $allowance=5;
        }
        if($hour>='2100'){
            $allowance=10;
        }
    }
    if($day==0){
         if($hour>='600' && $hour<='859'){
            $allowance=6;
        }
        if($hour>='1330' && $hour <='1529'){
            $allowance=6;
        }
        if($hour>='1530'){
            $allowance=15;
        }
    }
     if ($day >= 1 && $day <= 5) {
        if ($hour <= '2230') {
            $allowance = 10;
        } else {
            $allowance = 20;
        }
    }
    $sql2="update cmptMatch_Referee  set allowance=$allowance where idmatch=".$row['id'];
    echo "<tr><td>" . $row['id'] . "</td><td>" . $row['name'] . "</td><td>" . $row['km'] . "</td><td>" . $row['datetime'] . "</td><td>" . $row['dtDay'] . "</td><td>" . $row['updateddatetime'] . "</td><td>" . $row['udtDay'] . "</td><td>".$hour."</td><td>".$allowance."</td><td>$msg</td></tr>";
    echo "<tr><td colspan=7>".$sql2."</td></tr>";
    mysql_query($sql2);

}
echo "</table>";
?>
