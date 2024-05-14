<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include "config.php";
        include "funciones.php";
        $mysqli = conectar();


        if ($_GET['idLeague']) {
            $sql = "DELETE FROM matches WHERE idround IN (SELECT id FROM rounds WHERE idLeague=" . $_GET['idLeague'] . ");";
            echo $sql;
            $res = $mysqli->query($sql) or die(mysqli_error($mysqli));

            $sql = "DELETE FROM rounds WHERE idleague=" . $_GET['idLeague'] . ";";
            echo $sql;
            $res = $mysqli->query($sql) or die(mysqli_error($mysqli));
/*
            $ch = curl_init("https://www.futsal.cat/playOff/apiCompeticio.php");

            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            curl_exec($ch);
            curl_close($ch);
            fclose($fp);

            $ch = curl_init("https://www.futsal.cat/cache");

            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            curl_exec($ch);
            curl_close($ch);
            fclose($fp);*/
        }
        $sql = "select * from leagues where idSeason=10";
        $res = $mysqli->query($sql) or die(mysqli_error($mysqli));
        while ($row = mysqli_fetch_array($res)) {
            echo "<h2><a href='reiniciar.php?idLeague=" . $row['id'] . "'>REINICIAR " . $row['name'] . "</a></h2><br /><br />";
        }
        ?>
    </body>
</html>
