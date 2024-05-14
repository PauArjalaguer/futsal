<?php

ini_set("auto_detect_line_endings", "1");
include "config.php";
include "funciones.php";
$idcnx = conectar();
$fp = fopen($_GET['file'], "r");

while (( $data = fgetcsv($fp, 1000, ",")) !== FALSE) { // Mientras hay líneas que leer...
    $i = 1;

    foreach ($data as $row) {
        // echo "<pre>";print_r($row);echo "</pre>";
        $r = explode(";", $row);
        $team = addslashes(ucwords(strtolower(str_replace("\"", "", trim($r[0])))));
        $competition = ucwords(strtolower(str_replace("\"", "", trim($r[1]))));
        $category = ucwords(strtolower(str_replace("\"", "", trim($r[2]))));
$team=str_replace("*retirat* ","",$team);
        $sqlTeam = "select id from teams where name='$team'";
        //echo $sqlTeam;
        $resTeam = mysql_query($sqlTeam);
        $rowTeam = mysql_fetch_array($resTeam);
        $idTeam = $rowTeam['id'];

        if ($idTeam) {
           // echo "<br />&bull; Pertany a l' equip amb id $idTeam - $team";
        } else {
            echo "<br />&bull; Equip $team no identificat.";
            $idTeam = 0;
        }
    }
}
fclose($fp);
?>
