<?php

ini_set("auto_detect_line_endings", "1");
include "config.php";
include "funciones.php";
$idcnx = conectar();

$lastSeason = lastSeason();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];

$sql = "select * from leagues where id=" . $_GET['idLeague'];
$res = mysql_query($sql);
$row = mysql_fetch_array($res);
//print_r($row);

$sql = "delete from matches where idround in (select id from rounds where idLeague=" . $_GET['idLeague'] . ")";
//echo $sql;
$res = mysql_query($sql) or die(mysql_error());

$sql = "delete from rounds where idLeague=" . $_GET['idLeague'];
//echo $sql;
$res = mysql_query($sql) or die(mysql_error());

$fp = fopen($_GET['file'], "r");

echo $row['name'];

while (( $data = fgetcsv($fp, 1000, ",")) !== FALSE) { // Mientras hay líneas que leer...
    $i = 1;

    foreach ($data as $row) {
        // echo "<pre>";print_r($row);echo "</pre>";
        $r = explode(";", $row);
        $r[0] = str_replace("\"", "", trim($r[0]));
        $r[0] = str_replace("*RETIRAT* ", "", $r[0]);
        $r[2] = str_replace("\"", "", trim($r[2]));
        $r[2] = str_replace("*RETIRAT* ", "", $r[2]);

        $d = explode("/", $r[3]);
        $r[3] = $d[2] . "-" . $d[1] . "-" . $d[0];
        //echo "<pre>";print_r($r[5]);echo "</pre>";
        if ($ro != $r[5]) {
            echo "<h1>Jornada $r[5]</h1>";
            $sql = "insert into  rounds (name, idSeason, idLeague) values ('" . $r[5] . "',9, " . $_GET['idLeague'] . ")";
            //echo $sql;
            $res = mysql_query($sql);
            $idRound = mysql_insert_id();
        }
        echo "Equip Local: " . $r[0] . " - Equip visitant: " . $r[2] . " <br />Resultat: " . $r[1] . " <br />" . $r[5] . " Data " . $r[3] . " a les " . $r[4];

        $sql = "select id,playingComplex from teams where name ='" . addslashes($r[0]) . "'";
        //echo $sql;
        $res = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_array($res);
        $team1Id = $row['id'];
        $playingComplex = $row['playingComplex'];

        $sql = "select id from teams where name ='" . addslashes($r[2]) . "'";
        //echo $sql;
        $res = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_array($res);
        $team2Id = $row['id'];

        //echo $team1Id." ".$r[0]."--".$team2Id." ".$r[2]."<br />";
        if ($team1Id and $team2Id) {
            $sql = "insert into matches (idLocal, idVisitor, idRound, statusId,updateddatetime,datetime,place) values ($team1Id, $team2Id, $idRound,1,'" . $r[3] . " " . $r[4] . "','" . $r[3] . " " . $r[4] . "',$playingComplex)";
            // echo $sql."<br />";
            $res = mysql_query($sql) or die(mysql_error());
            echo "<br />Insertat el partit " . $team1Id . " " . $r[0] . "--" . $team2Id . " " . $r[2] . "<br /><hr />";
            $idMatch = mysql_insert_id();
            if (strlen($r[1]) > 1) {
                $res = explode("-", $r[1]);
                $sql = "insert into results values (null," . $res[0] . "," . $res[1] . ",$idMatch, 1,now(),null)";
                //echo $sql."<br />";
                $res = mysql_query($sql) or die(mysql_error());
            }
        } else {
            echo "\n\t<br /><span style='color:#c00;'>Hi ha alg&uacute;n error en el partit" . $team1Id . " " . $r[0] . "--" . $team2Id . " " . $r[2] . "</span><br /><hr />";
        }
        $ro = $r[5];
    }
}
fclose($fp);
?>
