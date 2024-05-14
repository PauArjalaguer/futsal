<?php

ini_set("auto_detect_line_endings", "1");
include "config.php";
include "funciones.php";
$idcnx = conectar();

function invertdateformat_($date) {
    $d = explode("/", $date);
    $date = $d[2] . "-" . $d[1] . "-" . $d[0];
    return $date;
}

$fp = fopen($_GET['file'], "r");

while (( $data = fgetcsv($fp, 1000, ",")) !== FALSE) { // Mientras hay líneas que leer...
    $i = 1;

    foreach ($data as $row) {
        /* echo "<pre>";
          print_r($row);
          echo "</pre>"; */
        $r = explode(";", $row);
        $name = ucwords(strtolower(str_replace("\"", "", trim($r[0]))));
        $surname1 = ucwords(strtolower(str_replace("\"", "", trim($r[1]))));
        $surname2 = ucwords(strtolower(str_replace("\"", "", trim($r[2]))));
        $type = utf8_encode($r[4]);
        $date = invertdateformat_($r[5]);
        $dni = intval($r[6]);
        $nif = strval($r[6]);
        $birthdate = invertdateformat_($r[7]);
        $city = addslashes(ucwords(strtolower(str_replace("\"", "", trim($r[8])))));
        $address = addslashes(ucwords(strtolower(str_replace("\"", "", trim($r[9])))));
        $team = ucwords(strtolower(str_replace("\"", "", trim($r[10]))));
        $team = addslashes($team);
        $team = str_replace("*retirat* ", "", $team);
        $competition = ucwords(strtolower(str_replace("\"", "", trim($r[11]))));

        echo "<hr />$name $surname1 $surname2 - $type $date $dni  $birthdate $city $address $team $competition";

        if ($type == "Jugador") {
            $typeF = 2;
        }
        if ($type == "Entrenador") {
            $typeF = 3;
        }
        if ($type == "2º entrenador") {
            $typeF = 3;
        }
        if ($type == "Delegado") {
            $typeF = 4;
        }
        if ($type == "Auxiliar") {
            $typeF = 5;
        }
        if (strlen($dni) > 3) {
            $sqlTeam = "select id from teams where name='$team'";
            $resTeam = mysql_query($sqlTeam);
            $rowTeam = mysql_fetch_array($resTeam);
            $idTeam = $rowTeam['id'];

            if ($idTeam) {
                echo "<br />&bull; Pertany a l' equip amb id $idTeam - $team";
            } else {
                echo "<br />&bull; Equip $team no identificat.";
                $idTeam = 0;
            }
            echo "<br />&bull; Com que el DNI es correcte, busco coincidencies $typeF.<br />";
            $sql = "select id from players where dni ='" . $dni . "' limit 0,1";
            echo $sql;
            $res = mysql_query($sql) or die(mysql_error());
            $c = mysql_num_rows($res);
            $r = mysql_fetch_array($res);

            echo "<br />&bull; Hi ha $c jugadors amb aquest dni amb id:" . $r['id'];
            if ($c == 0) {
                echo "<br >&bull; Inserto el jugador";
                $sql1 = "insert into players values(null, '$name $surname1 $surname2', '$birthdate','null.jpg','$dni','null_dni.jpg','$address',0,0,0,'$city','$city','00000','$nif',null,null,null,null,null,null,'$name','$surname1','null_insurance.jpg',now())";

                echo $sql1;
                $r = mysql_query($sql1);
                $last_id = mysql_insert_id();
                $a++;
                // $last_id=2304;
                echo "<br />&bull; Darrer id: $last_id";
                $sql2 = "insert into player_team_season values ($last_id,null,$idTeam,9,3,1,0,0,'$date','$date',null,$typeF,100,0,'$date',0,0,0,0,'$team')";
                mysql_query($sql2);
                echo "<br />$a " . $sql2;
            } else {
                echo "<br />&bull; El jugador ja existia a la base de dades, l 'introduim a la temporada";
                $sql2 = "insert into player_team_season values (" . $r['id'] . ",null,$idTeam,9,3,1,0,0,'$date','$date',null,$typeF,100,0,'$date',0,0,0,0,'$team')";
                $a++;
                echo "<br />$a " . $sql2;
                mysql_query($sql2);
            }
        } else {        echo "<br />&bull; El jugador $name $surname1 $surname2 del $team  t&eacute; el dni incorrecte";
          /*  $sqlTeam = "select id from teams where name='$team'";
            $resTeam = mysql_query($sqlTeam);
            $rowTeam = mysql_fetch_array($resTeam);
            $idTeam = $rowTeam['id'];
    
            $sql2 = "insert into player_team_season values ($last_id,null,$idTeam,9,3,1,0,0,'$date','$date',null,$type,100,0,'$date',0,0,0,0,'$team');";
            echo "<br />" . $sql2 . "<hr />";*/
        }
    }
}
fclose($fp);
?>
