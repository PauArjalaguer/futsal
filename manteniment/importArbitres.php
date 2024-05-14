<?php

ini_set("auto_detect_line_endings", "1");
include "config.php";
include "funciones.php";
$mysqli = conectar();

$fp = fopen($_GET['file'], "r");

while (( $data = fgetcsv($fp, 1000, ",")) !== FALSE) { // Mientras hay líneas que leer...
    $i = 1;

    foreach ($data as $row) {

        $r = explode(";", $row);

        $localTeam = str_replace("\"", "", trim(utf8_encode($r[2])));
        $localTeam = str_replace("*RETIRAT* ", "", $localTeam);
		 $localTeam = str_replace("*RETIRAT COPA* ", "", $localTeam);

        $result = $r[3];

        $visitorTeam = str_replace("\"", "", trim(utf8_encode($r[4])));
        $visitorTeam = str_replace("*RETIRAT* ", "", $visitorTeam);
 $visitorTeam = str_replace("*RETIRAT COPA* ", "", $visitorTeam);
        $referees = $r[5];

        $d = explode("/", $r[6]);
        $date = $d[2] . "-" . $d[1] . "-" . $d[0];

        $hour = $r[7];

        $place = $r[8];
        $round = $r[9];
        $league = utf8_encode($r[10]);
        $league = str_replace("\"", "", $league);
        if ($league == "NACIONAL CATALANA 2017-18") {
            $league = "Nacional Catalana Grup A";
        }
        if ($league == "Nacional Femenina A") {
            $league = "Primera Nacional Femenina A Grup A";
        }
        if ($league == "PRIMERA NACIONAL 2017-18") {
            $league = "Primera Nacional Grup A";
        }
        if ($league == "2a. Territorial A") {
            $league = "Segona Territorial Grup A";
        }
        if ($league == "Juvenil A") {
            $league = "Juvenil Grup A";
        }
        if ($league == "Juvenil B") {
            $league = "Juvenil Grup B";
        }
        if ($league == "Aleví A") {
            $league = "Aleví Grup A";
        }
        if ($league == "1a Territorial A") {
            $league = "Territorial Grup A";
        }
        if ($league == "1a Territorial B") {
            $league = "Territorial Grup B";
        }
        if ($league == "1ª Territorial C") {
            $league = "Territorial Grup C";
        }
        if ($league == "1a Territorial D") {
            $league = "Territorial Grup D";
        }
        if ($league == "Nacional Femenina B") {
            $league = "Primera Nacional Femenina A Grup B";
        }
        if ($league == "2a Territorial D") {
            $league = "Segona Territorial Grup D";
        }
        if ($league == "2a. Territorial C") {
            $league = "Segona Territorial Grup C";
        }
         if ($league == "Cadet A") {
            $league = "Cadet Grup A";
        }
        if ($league == "Cadet B") {
            $league = "Cadet Grup B";
        }
         
         if ($league == "Infantil A") {
            $league = "Infantil Grup A";
        }
        if ($league == "Juvenil Nacional") {
            $league = "Juvenil Nacional Grup A";
        }

        echo "<hr />Equip Local: " . $localTeam . " ($result) Equip visitant: " . $visitorTeam . " Arbitres: " . $arb . " Num:" . count($a) . " $league $round";
        $sql2 = "select m.id, localResult from matches m  join rounds ro on ro.id=m.idRound  join leagues l on l.id=ro.idleague join teams t1 on t1.id=m.idLocal "
                . "join teams t2 on t2.id=m.idVisitor "
                . "left join results re on re.idMatch=m.id "
                . "where l.idSeason=9 and t1.name='" . addslashes($localTeam) . "' and t2.name='" . addslashes($visitorTeam) . "' and l.name='" . $league . "' limit 0,1";

        $res2 = $mysqli->query($sql2);
        $row2 = mysqli_fetch_array($res2);
        // print_r($row2);
        $idMatch = $row2['id'];
        if (!$row2['id']) {
            echo "<br><font color='#c00'>No s'ha trobat el partit <br /><br />$sql2</font><br/> ";
        } else {
			
//$idLeague = $row2['id'];
            if (strlen($row2['localResult']) > 0) {
                echo "<br />Ja té resultat a la base de dades";
            } else {
				$sql3="update matches set updateddatetime='$date $hour' where id=".$row2['id'];
				 $mysqli->query($sql3);
                echo "<br />No té resultat a la base de dades";
                if (strlen($result) > 1) {
                    echo " i té resultat a la base de dades al CSV";
                    $res = explode("-", $result);
                    $sql = "insert into results values (null," . $res[0] . "," . $res[1] . ",$idMatch, 1,now(),null)";
                    // echo "<br />&nbsp; - &nbsp; " . $sql;
                    $mysqli->query($sql);
                }
            }
        }
        if ($referees) {

            $a = explode("-", $referees);
            echo "<br /><br />Busquem els " . count($a) . " arbitres $referees";
            if (count($a) > 0) {
                $p = 1;
                for ($i = 0; $i < (count($a)); $i++) {
                    echo "<br />Àrbitre: " . strtoupper(strtolower(utf8_encode($a[$i])));
                    $sql = "select id from rfrReferees where upper(name) like '%" . addslashes(trim(strtoupper(utf8_encode($a[$i])))) . "%'  ";
                    // echo "<br>" . $sql;
                    $res = $mysqli->query($sql);
                    $row = mysqli_fetch_array($res);
                    if ($row['id']) {
                        $mysqli->query("delete from cmptMatch_Referee where idRefereeType=$p and idMatch=" . $idMatch);
                        $sql3 = "insert into cmptMatch_Referee values (null," . $idMatch . "," . $row['id'] . ",0,0,$p,1,null,0)";
                        $mysqli->query($sql3);
                        echo "<br />&nbsp; Introdueixo l' arbitre " . $row['id'] . " al partit $idMatch a la posició $p <br />$sql3";
                        $p++;
                    } else {
                        echo "<br>L' arbitre no existeix";
                    }
                }
            } else {
                echo "<br><span style='color:#c00;'>Te " . count($a) . " arbitres</span>";
            }
        }
    }
}
fclose($fp);
?>
