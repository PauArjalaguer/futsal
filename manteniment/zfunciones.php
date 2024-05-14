<?php

/* * *
  función conectar
  que = se conecta a mysql y devuelve el identificador de conexión
 * * */

function conectar() {

    global $HOSTNAME, $USERNAME, $PASSWORD, $DATABASE;
    $mysqli = new mysqli($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);
 $acentos = $mysqli->query("SET NAMES 'utf8'");
    return $mysqli;
}

function RandomString($length = 10, $uc = TRUE, $n = TRUE, $sc = FALSE) {

    $source = 'abcdefghijklmnopqrstuvwxyz';

    if ($uc == 1)
        $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    if ($n == 1)
        $source .= '1234567890';

    if ($sc == 1)
        $source .= '|@#~$%()=^*+[]{}-_';

    if ($length > 0) {

        $rstr = "";

        $source = str_split($source, 1);

        for ($i = 1; $i <= $length; $i++) {

            mt_srand((double) microtime() * 1000000);

            $num = mt_rand(1, count($source));

            $rstr .= $source[$num - 1];
        }
    }

    return $rstr;
}

function treuAccents($str) {
    $str = stripslashes(strtolower($str));
    $str = str_replace("'", "", $str);
    $str = htmlentities($str);
    $str = str_replace(" ", "_", $str);
    $str = str_replace("&agrave;", "a", $str);
    $str = str_replace("&aacute;", "a", $str);
    $str = str_replace("&eacute;", "e", $str);
    $str = str_replace("&eagrave;", "e", $str);
    $str = str_replace("&iacute;", "i", $str);
    $str = str_replace("&iagrave;", "i", $str);
    $str = str_replace("&oacute;", "o", $str);
    $str = str_replace("&oagrave;", "o", $str);
    $str = str_replace("&uacute;", "u", $str);
    $str = str_replace("&uagrave;", "u", $str);
    $str = str_replace("&ccedil;", "c", $str);
    $str = str_replace("-", "", $str);
    $str = str_replace("/", "-", $str);
    $str = str_replace(",", "", $str);
    $str = str_replace("'", "", $str);
//$str1=str_replace("'","",$str);//
    return $str;
}

function teamUrlFormat($str) {
    $str = str_replace(" ", "", $str);
    $str = htmlentities($str);
    $str = stripslashes(strtolower($str));

    $str = str_replace("'", "", $str);

    $str = str_replace("&agrave;", "a", $str);

    $str = str_replace("&aacute;", "a", $str);
    $str = str_replace("&eacute;", "e", $str);
    $str = str_replace("&egrave;", "e", $str);
    $str = str_replace("&iacute;", "i", $str);
    $str = str_replace("&igrave;", "i", $str);
    $str = str_replace("&oacute;", "o", $str);
    $str = str_replace("&oagrave;", "o", $str);
    $str = str_replace("&uacute;", "u", $str);
    $str = str_replace("&ugrave;", "u", $str);
    $str = str_replace("&ccedil;", "c", $str);
    $str = str_replace("/", "-", $str);
    $str = str_replace(",", "", $str);
//$str1=str_replace("'","",$str);//
    return $str;

//return $str;
}

function redimensionar($imatge) {
    $destino = $imatge;
    $destino_temporal = tempnam("tmp/", "tmp");
    $r = explode("/", $imatge);
//$ending_target=$r[0]."/thumb_".$r[1];
    $ending_target = $destino;
    list($ample, $alt, $tipus, $atr) = getimagesize($imatge);
    $relacio = $ample / $alt;
//echo "$ample $alt $relacio";
    if ($relacio > 1) {
        $h = 600;
        $v = 450;
    } else {
        $h = 600;
        $v = 800;
    }
    redimensionar_jpeg($imatge, $destino_temporal, $h, $v, 100);

// guardamos la imagen
    $fp = fopen($ending_target, "w");
    fputs($fp, fread(fopen($destino_temporal, "r"), filesize($destino_temporal)));
    fclose($fp);
}

function redimensionar_jpeg($img_original, $img_nueva, $img_nueva_anchura, $img_nueva_altura, $img_nueva_calidad) {
    $fileName = 'redimensionar_jpeg.txt';
    $f = fopen($fileName, "w");
    $img = imagecreatefromjpeg($img_original);
    $l .= date("Y-m-d H:i:s") . " Imagecreatefromjpg $img_original\n";
    $thumb = imagecreatetruecolor($img_nueva_anchura, $img_nueva_altura);
    $l .= date("Y-m-d H:i:s") . " imagecreatetruecolor($img_nueva_anchura , $img_nueva_altura)\n";
    imagecopyresized($thumb, $img, 0, 0, 0, 0, $img_nueva_anchura, $img_nueva_altura, ImageSX($img), ImageSY($img));
    $l .= date("Y-m-d H:i:s") . " Imagecopyresized\n";
    imagecreatetruecolor($img_nueva_anchura, $img_nueva_altura);
    $l .= date("Y-m-d H:i:s") . "  imagecreatetruecolor\n";
    imagejpeg($thumb, $img_nueva, $img_nueva_calidad);
    $l .= date("Y-m-d H:i:s") . "  imagejpeg( $img_nueva)\n";
    imagedestroy($img);
    fputs($f, $l);
    fclose($f);
}

function invertdateformat($date) {

    $temp = explode(" ", $date);
    $data = $temp[0];

    $d = explode("-", $data);

    $date = $d[2] . "-" . $d[1] . "-" . $d[0];
    $string = $date;
    return $string;
}

function dateformat($date) {
    $mesos = array(null, "Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Setembre", "Octubre", "Novembre", "Desembre");
    $temp = explode(" ", $date);
    $data = $temp[0];
    $hora = $temp[1];
    $d = explode("-", $data);
    $m = $mesos[abs($d[1])];
    $date = "<span class='mes'>" . substr($m, 0, 3) . "</span><br /><br /><span class='dia'> " . $d[2] . "</span>";
    $string = $date;
    return $string;
}

function monthToString($month) {
    $mesos = array(null, "Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Setembre", "Octubre", "Novembre", "Desembre");


    $m = $mesos[abs($month)];

    return $m;
}

function dateformatCup($date) {
    $mesos = array(null, "Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Setembre", "Octubre", "Novembre", "Desembre");
    $temp = explode(" ", $date);
    $data = $temp[0];
    $hora = $temp[1];
    $d = explode("-", $data);
    $m = $mesos[abs($d[1])];
    $date = $d[2] . " " . $m . " de " . $d[0];
    $string = $date;
    return $string;
}

function lastSeason($mysqli) {
    $sql = "select id,name from seasons order by id desc limit 0,1 ";
   
    $res = $mysqli->query($sql);
    $row = mysqli_fetch_row($res);
//echo "LAST SEASON:". $row['id'];
    return $row;
}

function managementLog($idUser, $idAction, $idItem) {
    
}

function clubCashingBalance($idClub, $paymentType) {
    //echo "<h2>IDLCUB</h2> $idClub";
    $lastSeason = lastSeason();
    $lastSeasonId = $lastSeason [0];
    $lastSeasonName = $lastSeason [1];
    $residu = 0;
    $initDate = '2016-06-01';
//crear taula temporal
    mysql_query("CREATE TEMPORARY TABLE  `cashingTemp` (
`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`concept` VARCHAR( 255 ) NOT NULL ,
`amount` INT NOT NULL ,
`datetime` DATETIME NOT NULL
) ENGINE = MYISAM ;
") or die(mysql_error());

//llista de pagaments

    $sql = "
    select
        code, amount, datetime
    from admClubPayments cp
        join clubs c on c.id=cp.idClub
 where c.id=" . $idClub;
    $sql = "
    select
        code, amount, datetime,paymentType as paymentTypeName
    from admClubPayments cp
        join clubs c on c.id=cp.idClub

LEFT JOIN admClubPaymentTypes acpt on acpt.idPaymentType=cp.idPaymentType
 where archived=0 and c.id=" . $idClub;
    if ($paymentType != 0) {
        $sql .= " and cp.idPaymentType=$paymentType";
    }

    $sqlString = "SQL1=" . $sql . "<br /><br /><br />";
    $res = mysql_query($sql) or die(mysql_error());
    while ($row = mysql_fetch_array($res)) {
        $sql1 = "INSERT INTO cashingTemp (concept,amount,datetime) values ('" . $row ['code'] . "'," . $row ['amount'] . ",'" . $row ['datetime'] . "')";
//echo $sql1;
        mysql_query($sql1) or die(mysql_error());
    }


//lista de jugadors fitxats
    if ($paymentType == 1 or $paymentType == 0) {

        $sql = "SELECT p.name AS playerName,
       t.name AS teamName,
       rds.rate,
       paymentdate,
       d.prefix AS division,
       s.name AS season
, adste.rate as newRate
FROM   player_team_season pts
       JOIN players p
         ON p.id = pts.idplayer
       JOIN teams_divisions_per_season td
         ON td.idteam = pts.idteam
            AND td.idseason = pts.idseason
       JOIN divisions d on d.id=td.iddivision
       JOIN rate_division_season rds
         ON d.id = rds.iddivision
            AND td.idseason = rds.idseason
       JOIN teams t
         ON t.id = pts.idteam
       JOIN seasons s
         ON s.id = pts.idseason
         left join admrate_division_season_exceptions adste on adste.idplayer=p.id and adste.idseason=$lastSeasonId
WHERE  ispayed = 1

       AND idclub = " . $idClub . "

ORDER  BY pts.id DESC  ";
        $sql = "SELECT p.name AS playerName,
       t.name AS teamName,
       rds.rate,
       paymentdate,
       d.prefix AS division,
       s.name AS season
, adste.rate as newRate
FROM   player_team_season pts
       JOIN players p
         ON p.id = pts.idplayer
       JOIN teams_divisions_per_season td
         ON td.idteam = pts.idteam
            AND td.idseason = pts.idseason
       JOIN divisions d on d.id=td.iddivision
       JOIN rate_division_season rds
         ON d.id = rds.iddivision
            AND td.idseason = rds.idseason
       JOIN teams t
         ON t.id = pts.idteam
       JOIN seasons s
         ON s.id = pts.idseason
         left join admrate_division_season_exceptions adste on adste.idplayer=p.id and adste.idseason=pts.idseason
WHERE  ispayed = 1 and paymentDate>'$initDate'

       AND idclub = " . $idClub . "

ORDER  BY pts.id DESC ";
        $sqlString .= "SQL2=" . $sql . "<br /><br /><br />";
        $res = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($res)) {
            $concept = " Fitxa " . $row ['playerName'] . " (" . $row ['teamName'] . ")";
            if (isset($row['newRate'])) {
                $r = $row['newRate'];
            } else {
                $r = $row['rate'];
            }
            $sql1 = "INSERT INTO cashingTemp (concept,amount,datetime) values ('" . addslashes($concept) . "',-" . $r . ",' a " . $row ['paymentdate'] . "')";
            //echo "SQL3=" . $sql1 . "<br /><br /><br />";
            mysql_query($sql1) or die(mysql_error());
        }
    }
    if ($paymentType == 2 or $paymentType == 0) {
//compra de pilotes

        $sql = "
SELECT amount, datetime, (amount*ballprice) as totalPrice, ballprice, price FROM `admBalls` aB
join admBallPricePerSeason aBP on aBP.idSeason=6 where datetime>'$initDate' and idClub=" . $idClub . " order by id desc";

        $sqlString .= "SQL2=" . $sql . "<br /><br /><br />";
        $res = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($res)) {
            $concept = " Compra de  " . $row ['amount'] . " pilotes";

            $sql1 = "INSERT INTO cashingTemp (concept,amount,datetime) values ('" . addslashes($concept) . "',-" . $row ['totalPrice'] . ",'" . $row ['datetime'] . "')";
//echo "SQL3=".$sql1."<br /><br /><br />";
            mysql_query($sql1) or die(mysql_error());
        }
    }
    if ($paymentType == 3 or $paymentType == 0) {
        $sql = "
SELECT t.name, ate.datetime, rdst.rate, adste.rate as newRate
FROM admTeamEntries ate
JOIN teams t ON t.id = ate.idteam
LEFT JOIN teams_divisions_per_season td ON td.idteam = t.id
AND td.idseason =$lastSeasonId

LEFT JOIN rate_division_season_per_team rdst ON rdst.iddivision = td.iddivision AND rdst.idseason =$lastSeasonId
left join admrate_division_season_per_teams_exceptions adste on adste.idteam=t.id and adste.idseason=$lastSeasonId

WHERE idClub =$idClub";
        $sql = "
SELECT t.name, ate.datetime, rdst.rate, adste.rate as newRate
FROM admTeamEntries ate
JOIN teams t ON t.id = ate.idteam
LEFT JOIN teams_divisions_per_season td ON td.idteam = t.id
AND td.idseason =ate.idseason


LEFT JOIN rate_division_season_per_team rdst ON rdst.iddivision = td.iddivision AND rdst.idseason =td.idseason
left join admrate_division_season_per_teams_exceptions adste on adste.idteam=t.id and adste.idseason=td.idseason

WHERE ate.datetime>'$initDate' and idClub =" . $idClub;

        $sqlString .= "SQL2=" . $sql . "<br /><br /><br />";
        $res = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($res)) {
            $concept = " Drets de competici� de" . $row ['name'] . ".";
            if (empty($row['rate'])) {
                $row['rate'] = 0;
            }
            if (isset($row['newRate'])) {
                $r = $row['newRate'];
            } else {
                $r = $row['rate'];
            }
            $sql1 = "INSERT INTO cashingTemp (concept,amount,datetime) values ('" . addslashes($concept) . "',-" . $r . ",'" . $row ['datetime'] . "')";
            // echo "SQL3=" . $sql1 . "<br /><br /><br />";
            mysql_query($sql1) or die(mysql_error());
        }
    }

    $res1 = mysql_query("SELECT * FROM cashingTemp order by datetime asc") or die(mysql_error());

    while ($row1 = mysql_fetch_array($res1)) {
        if ($n == 1) {
            $n = 2;
        } else {
            $n = 1;
        }

        $residu = $residu + $row1['amount'];
    }
    //echo $sqlString;
    return $residu;
    //echo "DINERS TOTALS: $residu";
}

?>