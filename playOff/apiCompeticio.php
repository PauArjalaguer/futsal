<?php

$time_start = microtime(true);
include "../manteniment/config.php";
include "../manteniment/funciones.php";
$mysqli = conectar();
include "funcionsApi.php";
$token = peticioToken();

$sql = "SELECT datediff( now(),datetime) as d FROM cPanelActivityLog WHERE idUser=267 ORDER BY id DESC LIMIT 0,1 ";
$res = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row = mysqli_fetch_array($res);
if ($row['d'] > 5) {
    exit();
}
$knownTeams = 0;
$idSeason = 10;

$sql = "select id, playoffid from leagues where  idseason=$idSeason and playoffid is not null order by updated asc limit 0,1";
$res = $mysqli->query($sql) or die(mysqli_error($mysqli));
while ($row = mysqli_fetch_array($res)) {
    $idGrup = $row['playoffid'];
    $idLeague = $row['id'];
    $arrayJornades = peticioCalendari($token, $idGrup);
    if ($_GET['api'] == 1) {
        echo "<pre>";
        print_r($arrayJornades);
        echo "</pre>";
    }
    foreach ($arrayJornades['jornades'] as $round) {
//CONTROL JORNADES
        $r = str_replace("Jornada ", "", trim($round['nomJornada']));

        $sql2 = "select r.id from rounds r right join leagues l on l.id=r.idLeague where r.name=" . "'" . $r . "'" . " and idLeague=$idLeague";

        $debug .="<br />" . $sql2;
        $res2 = $mysqli->query($sql2) or die(mysqli_error($mysqli));
        $date = $round['dataFiJornada'];

        if ($res2->num_rows > 0) {
            $roundDataInici = $round['dataInici'];
            $roundDataFiJornada = $round['dataFiJornada'];
            $sql3 = "update rounds r set  initialDate=' $roundDataInici ', endDate=' $roundDataFiJornada '   where r.name=" . "'" . $r . "'" . " and idLeague=$idLeague";
            $debug .= "<h2>Jornada $r</h2> La jornada  existeix, fem update. $sql3";
        } else {
            $roundDataInici = $round['dataInici'];
            $roundDataFiJornada = $round['dataFiJornada'];
            $sql3 = "insert into rounds values (null, " . "'" . $r . "',"  ."'". $roundDataFiJornada . "'" . ", " . "'" . $roundDataFiJornada . "', " . $idSeason . ", $idLeague, " . $round['idJornada'] . ")";
            $debug .= "<h2>Jornada $r</h2> La jornada no existeix, fem insert. $sql3";
        }

$res3 = $mysqli->query($sql3) or die(mysqli_error($mysqli));
        $rowRound = mysqli_fetch_array($res2);
        if ($rowRound['id']) {
            $idRound = $rowRound['id'];
        } else {
            $idRound = $mysqli->insert_id;
        }
//control partits

        foreach ($round['events'] as $match) {
            $knownTeams = 0;
//echo "<br />Partit num: ".$match['idEvent']." (jornada $idRound) es juga a les :".$match['partitHora']." a ".$match['partitPistaJoc'];
            $idLocal = $match ['equips'][0]['idEquip'];
            $nameLocal = $match['equips'][0]['nomEquip'];
            $posicioLocal = $match['equips'][0]['idTipusEvent'];
            $idVisitor = $match['equips'][1]['idEquip'];
            $nameVisitor = $match['equips'][1]['nomEquip'];
            $posicioVisitor = $match['equips'][1]['idTipusEvent'];
            $matchDate = $match['partitData'];
            $matchHour = $match ['partitHora'];

            $matchStatus = $match ['estat'];
            
            if($matchStatus=='EVESTPERJUGAR'){
                $matchStatus=1;
            }else if($matchStatus=='EVESTJUGAT'){
                $matchStatus=4;
            }else{
                $matchStatus=3;
            }
            $matchIdEvent = $match['idEvent'];
            $matchIdRound = $match['idJornada'];

            $matchCp = $match['partitCP'];
            $matchAddress = $match['domicili'];
            $matchCity = $match['municipi'];
            $matchProvince = $match['partitProvincia'];
            $matchComplex = $match['partitPistaJoc'];

            $debug .= "<br /><h3>Partit num: $matchIdEvent</h3> Equips: $idLocal $nameLocal ($localGoals - $visitorGoals) $idVisitor $nameVisitor<br />  Data: $matchDate $matchHour";
            $debug .="<br />Es juga a $matchComplex: $matchAddress $matchCp $matchCity ($matchProvince)";


            $sqlLocal = "select id from teams where playOffId=$idLocal";

            $resLocal = $mysqli->query($sqlLocal) or die(mysqli_error($mysqli));
            $rowLocal = mysqli_fetch_array($resLocal);

            if ($resLocal->num_rows > 0) {
                $knownTeams++;
                $idLocal = $rowLocal['id'];
            } else {
                $debug .=" <br />-> No existeix el local a la base de dades $idLocal $nameLocal";
            }

            $sqlVisitor = "select id from teams where playOffId=$idVisitor";
            $resVisitor = $mysqli->query($sqlVisitor) or die(mysqli_error($mysqli));
            $rowVisitor = mysqli_fetch_array($resVisitor);
            if ($resVisitor->num_rows > 0) {
                $knownTeams++;
                $idVisitor = $rowVisitor['id'];
            } else {
                $debug .=" <br />-> No existeix el visitant a la base de dades $idVisitor $nameVisitor";
            }
            $debug .="Known teams=" . $knownTeams;
            if ($knownTeams == 2) {
                $debug .= "<br />-> Existeixen els dos equips. Busquem si existeix el partit.";
                $sqlMatch = "select id from matches where playOffId=" . $matchIdEvent;

                $resMatch = $mysqli->query($sqlMatch) or die(mysqli_error($mysqli));
                $rowMatch = mysqli_fetch_array($resMatch);

                if ($resMatch->num_rows > 0) {
                    if ($posicioLocal == 1) {
                        $local = $idLocal;
                        $visitor = $idVisitor;
                    } else {
                        $local = $idVisitor;
                        $visitor = $idLocal;
                    }
                    $debug .= "<br />--> El partit existeix. Actualitzem dades.";
                    $complexName = addslashes($matchComplex);
                    $complexAddress = addslashes(ucwords(mb_strtolower($matchAddress . " " . $matchCity)));
                    $sqlMatch2 = "Update matches set statusId='$matchStatus', idLocal=$local, idVisitor=$visitor, complexName=' $complexName ', complexAddress=' $complexAddress ' ,  datetime=" . "'" . $matchDate . " " . $matchHour . "', updateddatetime=" . "'" . $matchDate . " " . $matchHour . "'" . " where playOffId=" . $matchIdEvent;
                    $idMatch = $rowMatch['id'];
                } else {
                    if ($posicioLocal == 1) {
                        $local = $idLocal;
                        $visitor = $idVisitor;
                    } else {
                        $local = $idVisitor;
                        $visitor = $idLocal;
                    }
                    $debug .= "<br />--> El partit no existeix. Fem insert.";
                    $sqlMatch2 = "insert into matches values (null,$local,$visitor, $idRound," . "'" . $matchDate . " " . $matchHour . "'" . ",4,1,null,null,null," . "'" . $matchDate . " " . $matchHour . "'" . ",$matchIdEvent,null,null,null)";
                }
                $debug .= $sqlMatch2;
                $resMatch2 = $mysqli->query($sqlMatch2) or die(mysqli_error($mysqli));
                if ($mysqli->affected_rows != 0) {
                    echo "\n $nameLocal - $nameVisitor: ";
                    echo "\n\t$matchDate $matchHour $matchComplex , $matchAddress $matchCity";
                }
            }
        }
    }
    $resMatch2 = $mysqli->query("update leagues set updated=now() where id=" . $idLeague) or die(mysqli_error($mysqli));
}


if ($_GET['debug']) {
    echo $debug;
    echo '<br />Total execution time in seconds: ' . (microtime(true) - $time_start);
}