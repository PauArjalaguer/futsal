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
            $sql = "select id from players where dni ='" . $dni . "' limit 0,1";
            //echo $sql;
            $res = mysql_query($sql) or die(mysql_error());
            $c = mysql_num_rows($res);
            $r = mysql_fetch_array($res);
            
            mysql_query("update player_team_season set position=".$typeF." where idplayer=".$r['id']);
        }
    }
}
fclose($fp);
?>
