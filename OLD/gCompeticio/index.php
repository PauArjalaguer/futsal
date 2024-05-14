<? if (!$_COOKIE['userName']) {
   // header("Location: http://www.futsal.cat");
}
?><script type="text/javascript">
    function nuevoAjax() {
        var xmlhttp = false;
        try {
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (E) {
                xmlhttp = false;
            }
        }

        if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
            xmlhttp = new XMLHttpRequest();
        }
        return xmlhttp;
    }

    function updateDateTimeAndPlace(idMatch) {
        var container;
        var date = document.getElementById("match_date_" + idMatch).value;
        var time = document.getElementById("match_time_" + idMatch).value;
        var select = document.getElementById("match_complex_" + idMatch);

        var select_index = select.selectedIndex;
        var select_value = select.options[select_index].value;
        // alert(date+" "+time+" "+select_value)


        ajax = nuevoAjax();
        ajax.open("GET", "updateDateTimeAndPlace.php?date=" + date + "&time="
                + time + "&complex=" + select_value + "&idMatch=" + idMatch, true);

        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4) {
                //alert(ajax.responseText);
                document.getElementById('block_' + idMatch).style.backgroundColor = "#090";


            }
        }
        ajax.send(null)
    }
    function deleteMatchConfirm(idMatch, idRound, idLeague) {
        var conf = confirm("Segur que vols eliminar el partit ?");
        if (conf == true) {
            deleteMatch(idMatch, idRound, idLeague);

        }
    }
    function deleteMatch(idMatch, idRound, idLeague) {


        ajax = nuevoAjax();
        ajax.open("GET", "deleteMatch.php?idMatch=" + idMatch + "&idRound=" + idRound + "&idLeague=" + idLeague, true);

        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4) {
                alert(ajax.responseText);
                document.getElementById('block_' + idMatch).style.display = "none";


            }
        }
        ajax.send(null)
    }
    function deleteTeamFromLeagueConfirm(idTeam) {
        var conf = confirm("Segur que vols eliminar l' equip ?");
        if (conf == true) {
            deleteTeamFromLeague(idTeam);

        }
    }
    function deleteTeamFromLeague(idTeam) {


        ajax = nuevoAjax();
        ajax.open("GET", "deleteTeamFromLeague.php?idTeam=" + idTeam, true);

        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4) {
                //alert(ajax.responseText);
                //document.getElementById('block_'+idMatch). style.display="none";
                location.reload();


            }
        }
        ajax.send(null)
    }

    function updateRoundDate(field, idRound) {

        var date = document.getElementById(field).value;

        //alert(field+" "+date+" "+idRound);

        ajax = nuevoAjax();
        ajax.open("GET", "updateRoundDate.php?date=" + date + "&field="
                + field + "&idRound=" + idRound, true);

        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4) {
                //alert(ajax.responseText);
                //document.getElementById('block_'+idMatch). style.backgroundColor="#090";
//location.reload();

            }
        }
        ajax.send(null)

    }

</script>
<style>
    body{color:#242424;}
    a{color:#fff;}
    #web{
        font-family:Trebuchet Ms,Verdana;
        width:960px;
        margin:auto;
        color:#fff;
    }
    .block{
        text-align:left;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        background-color:#900;
        margin:5px;
        padding:15px;
        color:#fff;


    }
    .block h1{
        font-size:18px;
        margin:0;padding: 0;
        color:#fff;
        margin-bottom:10px;
    }
    .block select{ font-size:30px; padding:10px;}
    .block option{ font-size: 30px;padding:10px;}

    .innerblock{
        text-align:left;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        background-color:#fff;
        margin:5px;
        padding:15px;
        color:#900;


    }
    #rounds a{color:#000; -webkit-border-radius: 5px;
              -moz-border-radius: 5px;
              border-radius: 5px;
              background-color:#fff;
              margin:5px;
              padding:5px;
              color:#424242;
              text-decoration: none; font-size: 10px;
    }
</style>
<?
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

if (isset($_POST['submitNewMatch'])) {

    $out .="IS POST SUBMIT NEW MATCH<br />";
    $sql = "select championshipType from leagues l join championship c on c.id=l.idchampionship where l.id=" . $_GET['l'];
    $res = mysql_query($sql);
    $r = mysql_fetch_array($res);
    $out .="$sql<br /><br />";
    if ($r['championshipType'] == 1) {
        $league = 1;
    }
    //treu numero de jornades que te la lliga

    $sql = "SELECT name from rounds where idLeague=" . $_GET['l'] . " order by id desc limit 0,1";
    $out .="$sql<br /><br />";
    $res = mysql_query($sql);
    $r = mysql_fetch_array($res);

    //meitat de lliga
    $halfSeason = $r['name'] / 2;

    //treu numero de jornada que te aquesta ronda
    $sql2 = "SELECT name from rounds where id=" . $_GET['r'] . " order by id desc limit 0,1";
    $out .="$sql2<br /><br />";
    $res2 = mysql_query($sql2);
    $r2 = mysql_fetch_array($res2);

    $actual = $r2['name'];

    //suma jornada a meitat de jornades de la lliga per a treure valor de la jornada a la segona volta
    $tornada = $r2['name'] + $halfSeason;
    if (empty($_POST['local'])) {
        $_POST['local'] = "NULL";
    }
    if (empty($_POST['visitor'])) {
        $_POST['visitor'] = "NULL";
    }
    if (empty($_POST['winnerLocal'])) {
        $_POST['winnerLocal'] = "NULL";
    }
    if (empty($_POST['winnerVisitor'])) {
        $_POST['winnerVisitor'] = "NULL";
    }
//insert partit d'anada
    if (!empty($_POST['local'])) {
        $q = "insert into matches (idLocal, idVisitor,idRound,place,datetime) values (" . $_POST['local'] . "," . $_POST['visitor'] . "," . $_GET['r'] . ",0,'0000-00-00 00:00:00')";
//echo $q;
    } else {
        $q = "insert into matches (matchWinnerLocal, matchWinnerVisitor,idRound,place) values (" . $_POST['winnerLocal'] . "," . $_POST['winnerVisitor'] . "," . $_GET['r'] . ",0)";
    }
    $q = "insert into matches (idLocal, idVisitor, matchWinnerLocal, matchWinnerVisitor,idRound,place,datetime)
        values (" . $_POST['local'] . "," . $_POST['visitor'] . "," . $_POST['winnerLocal'] . "," . $_POST['winnerVisitor'] . "," . $_GET['r'] . ",0,'0000-00-00 00:00:00')";
    //echo $q;
    mysql_query($q) or die(mysql_error());
    //insert partit de tornada, verificant abans que estiguem a jornada de la primera volta
    if ($league == 1) { //fa insert de tornada si es lliga
        if ($actual <= $halfSeason) {

            $sql = "Select id from rounds where name=$tornada and idLeague=" . $_GET['l'];
            $res = mysql_query($sql);
            $row = mysql_fetch_array($res);
            $idRound = $row['id'];
            $q = "insert into matches (idLocal, idVisitor,idRound,place) values (" . $_POST['visitor'] . "," . $_POST['local'] . "," . $idRound . ",0)";
            //echo $q;
            mysql_query($q) or die(mysql_error());
        }
    }
}


if (isset($_POST['roundsSubmit'])) {
    $rounds = $_POST['rounds'];
    for ($a = 1; $a <= $rounds; $a++) {
        mysql_query("insert into rounds (name,idSeason,idLeague) values ($a," . $_GET['s'] . "," . $_GET['l'] . ")");
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <style>
            h1{font-size:12px;}
            #divisions,#rounds,matches,#teams, #teamsDisabled, #matches{padding:15px; color:#fff;}

        </style>

        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Futsal Competicions</title>
    </head>

    <body>

        <div align="center">
            <div id="web">
                <div id="divisions" class="block">
                    <h1>Divisio</h1>
                    <select onChange="window.location.href = this.options[this.selectedIndex].value;">
                        <option></option>
                        <?
                        $res = mysql_query("select * from leagues where idseason=9 order by idSeason desc,name asc");
                        while ($row = mysql_fetch_array($res)) {
                            $style = "";
                            $selected = "";
                            if ($_GET['l'] == $row['id']) {
                                $selected = "selected";
                            }
                            //echo "<a href='?l=" . $row['id'] . "&s=" . $row['idSeason'] . "&d=" . $row['idDivision'] . "' $style >" . $row['name'] . "</a><br>";
                            echo "\n\t<option $selected value='?l=" . $row['id'] . "&s=" . $row['idSeason'] . "&d=" . $row['idDivision'] . "'>" . $row['name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div id="rounds" class="block">
                    <h1>Jornada</h1>
                    <?
                    if (isset($_GET['d'])) {

                        $res = mysql_query("select * from rounds where idleague=" . $_GET['l']);
                        if (mysql_num_rows($res) > 0) {
                            echo "<select onChange=\"window.location.href=this.options[this.selectedIndex].value;\">
                        <option></option>";
                            $n = 0;
                            while ($row = mysql_fetch_array($res)) {
                                $n++;
                                $style = "";

                                if ($_GET['r'] == $row['id']) {
                                    $selected = "selected";
                                }
                                echo "\n\t<option $selected value='?l=" . $_GET['l'] . "&s=" . $_GET['s'] . "&d=" . $_GET['d'] . "&r=" . $row['id'] . "'>" . $row['name'] . "</option>";
                                $selected = "";
                            }
                            echo "</select>";
                        } else {

                            echo "<form action=\"index.php?l=" . $_GET['l'] . "&s=" . $_GET['s'] . "&d=" . $_GET['d'] . "\" method=\"POST\"><input type=\"text\" name=\"rounds\" /><input type=\"submit\" name=\"roundsSubmit\" value=\"Enviar\" /></form> ";
                        }
                    }
                    ?>
                </div>
                <div id="matches" class="block">


                    <h1>Partits</h1>
                    <?
                    if ($_GET['r']) {
                        $sql = "select initialDate, endDate, DAYOFWEEK(initialdate) as w from rounds where id=" . $_GET['r'];

                        $res = mysql_query($sql);
                        $row = mysql_fetch_array($res);
                        $d = explode("-", $row['initialDate']);
                        $initialDate = $d[2] . "-" . $d[1] . "-" . $d[0];
                        $d = explode("-", $row['endDate']);
                        $endDate = $d[2] . "-" . $d[1] . "-" . $d[0];
                        $w = $row['w'];
                    }
                    ?>
                    <div class="innerblock">Dia inici jornada <input type="text" value="<? echo $initialDate; ?>" id="initialDate" onBlur="updateRoundDate('initialDate',<? echo $_GET['r']; ?>)" />&nbsp; Dia final jornada <input type="text" value="<? echo $endDate; ?>" id="endDate"   />
                        <div class="innerblock">
                            <?
                            $query = "select * from complex order by complexname";
                            $result = mysql_query($query) or die(mysql_error());
                            $data_array = array();
                            while ($query_data = mysql_fetch_row($result)) {
                                array_push($data_array, $query_data);
                            }
                            //print_r($data_array);
                            if (isset($_GET['r'])) {
                                // echo "select m.id as id, t1.id as localId,t1.name as localTeam, t2.id as visitorId,t2.name as visitorTeam from matches m join teams t1 on m.idlocal=t1.id join teams t2 on t2.id=m.idvisitor where  idround=" . $_GET['r'];
                                $res = mysql_query("SELECT
            t1.name as local,
            t2.name as visitor,
            localResult,
            visitorResult,
            m.id as idMatch,
            m.statusId,
            ms.color,
            t1.id as localId,
            t2.id as visitorId,
            m.updateddatetime as datetime,
            (select idnew from news_match where idmatch=m.id) as news,
            c1.image,
            c2.image,
			cx.id as complexId,
            cx.complexName,
            cx.complexAddress,
            t3.name as local1,
            t4.name as visitor1,
            t5.name as local2,
            t6.name as visitor2,
            c3.image,
            c4.image,
            c5.image,
            c6.image,
            m1.id,
            m2.id,
            ro.name as round,
            m.matchwinnerlocal,
            m.matchwinnervisitor
            from matches m
			left join results r on m.id=r.idMatch
			left join teams t1 on t1.id=m.idLocal
			left join teams t2 on t2.id=m.idvisitor
			join rounds ro on ro.id=m.idround
                        left join clubs c1 on c1.id=t1.idclub
                        left join clubs c2 on c2.id=t2.idclub
                        left join complex cx on cx.id=m.place
			left join matchstatus ms on m.statusid=ms.id

                        left join matches m1 on m1.id=m.matchwinnerlocal
                        left join teams t3 on t3.id=m1.idlocal
                        left join teams t4 on t4.id=m1.idvisitor
                        left join clubs c3 on c3.id=t3.idclub
                        left join clubs c4 on c4.id=t4.idclub

                        left join matches m2 on m2.id=m.matchwinnervisitor
                        left join teams t5 on t5.id=m2.idlocal
                        left join teams t6 on t6.id=m2.idvisitor
                        left join clubs c5 on c5.id=t5.idclub
                        left join clubs c6 on c6.id=t6.idclub


        where  ro.id=" . $_GET['r']);

                                while ($row = mysql_fetch_array($res)) {
                                    echo "\n\n\n<div>";
                                    echo "\n\t" . $row['idMatch'];
                                    if (!empty($row['local'])) {
                                        echo " " . $row['local'] . " - " . $row['visitor'];
                                    } else if (!empty($row['local1'])) {
                                        echo " " . $row['local1'] . "/" . $row['visitor1'] . " - " . $row['local2'] . "/" . $row['visitor2'];
                                    } else {
                                        echo " Partit " . $row['matchwinnerlocal'] . " -  Partit " . $row['matchwinnervisitor'];
                                    }
                                    echo "</div>";

                                    $datetime = $row['datetime'];
                                    $dt = explode(" ", $datetime);
                                    $date = $dt[0];
                                    $time = $dt[1];

                                    $d = explode("-", $date);
                                    $date = $d[2] . "-" . $d[1] . "-" . $d[0];
                                    echo "<div class='block' id='block_" . $row['idMatch'] . "'>\n\tDATA <input type='text' value='$date' id='match_date_" . $row['idMatch'] . "'></input>\n\t HORA <input type='text' value='$time' id='match_time_" . $row['idMatch'] . "'></input> PAVELL&Oacute;\n\t<select id='match_complex_" . $row['idMatch'] . "'>";
                                    foreach ($data_array as $complex) {
                                        echo "--> " . $row['complexId'] . "-->" . $complex[0] . "<br />";
                                        if ($row['complexId'] == $complex[0]) {
                                            $selected = "selected";
                                        } else {
                                            $selected = "";
                                        }
                                        echo "\n\t\t<option $selected value='" . $complex[0] . "'>" . $complex[1] . "</option>";
                                    }
                                    echo"\n\t</select><input type='button' value='Actualitzar horari' onClick='updateDateTimeAndPlace(" . $row['idMatch'] . ")'>&nbsp;<input type='button' style='cursor:pointer;' value='Esborrar partit' onClick='deleteMatchConfirm(" . $row['idMatch'] . "," . $_GET['r'] . "," . $_GET['l'] . ")'></input>
                                </div>";
                                }


                                //echo "<a href='result.php?m=" . $row['id'] . "&r=" . $_GET['r'] . "&d=" . $_GET['d'] . "'>" . $row['localTeam'] . " - " . $row['visitorTeam'] . "</a><br>";
                            }
                            ?>
                        </div>
                        <form action="<? echo $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']; ?>" enctype="multipart/form-data" method="post" >
                            <table cellpadding="3" cellspacing="0">
                                <tr>

                                    <?
                                    if (isset($_GET['r'])) {
                                        echo "   <td>Equip Local</td><td><select name=\"local\"><option></option>";

                                        $query = "select * from teams_leagues_per_season td join teams t on t.id=td.idTeam where 
                                             (t.id not in (select idlocal from matches where idround=" . $_GET['r'] . ") and t.id not in (select idvisitor from matches where idround=" . $_GET['r'] . ")) and
                                                idLeague=" . $_GET['l'] . " order by name asc";
                                        echo $query;
                                        $res = mysql_query("select * from teams_leagues_per_season td join teams t on t.id=td.idTeam where 
                                             (t.id not in (select idlocal from matches where idround=" . $_GET['r'] . " and idlocal is not null) and t.id not in (select idvisitor from matches where idround=" . $_GET['r'] . " and idvisitor is not null)) and
                                                idLeague=" . $_GET['l'] . " order by name asc") or die(mysql_error());
                                        while ($row = mysql_fetch_array($res)) {
                                            echo "<option value=\"" . $row['idTeam'] . "\">" . $row['name'] . "</option>\n";
                                        }
                                        echo "</select> </td>";
                                    }
                                    ?>
                                </tr>
                                <tr>

                                    <?
                                    if (isset($_GET['r'])) {
                                        echo "   <td>Equip Visitant</td><td><select name=\"visitor\"><option></option>";

                                        $res = mysql_query("select * from teams_leagues_per_season td join teams t on t.id=td.idTeam where (t.id not in (select idlocal from matches where idround=" . $_GET['r'] . " and idlocal is not null) and t.id not in (select idvisitor from matches where idround=" . $_GET['r'] . " and idvisitor is not null)) and
                                             idLeague=" . $_GET['l'] . " order by name asc") or die(mysql_error());
                                        while ($row = mysql_fetch_array($res)) {
                                            echo "<option value=\"" . $row['idTeam'] . "\">" . $row['name'] . "</option>\n";
                                        }
                                        echo "</select> </td>";
                                    }
                                    ?>

                                </tr>
                                <tr>

                                    <?
                                    if (isset($_GET['r'])) {
                                        echo "   <td>Guanyador partit</td><td><select name=\"winnerLocal\"><option>";

                                        $res = mysql_query("SELECT
            t1.name as local,
            t2.name as visitor,
            localResult,
            visitorResult,
            m.id as idMatch,
            m.statusId,
            ms.color,
            t1.id as localId,
            t2.id as visitorId,
            m.datetime,
            (select idnew from news_match where idmatch=m.id) as news,
            c1.image,
            c2.image,
            cx.complexName,
            cx.complexAddress,
            t3.name as local1,
            t4.name as visitor1,
            t5.name as local2,
            t6.name as visitor2,
            c3.image,
            c4.image,
            c5.image,
            c6.image,
            m1.id,
            m2.id,
            ro.name as round
            from matches m
			left join results r on m.id=r.idMatch
			left join teams t1 on t1.id=m.idLocal
			left join teams t2 on t2.id=m.idvisitor
			join rounds ro on ro.id=m.idround
                        left join clubs c1 on c1.id=t1.idclub
                        left join clubs c2 on c2.id=t2.idclub
                        left join complex cx on cx.id=m.place
			left join matchstatus ms on m.statusid=ms.id

                        left join matches m1 on m1.id=m.matchwinnerlocal
                        left join teams t3 on t3.id=m1.idlocal
                        left join teams t4 on t4.id=m1.idvisitor
                        left join clubs c3 on c3.id=t3.idclub
                        left join clubs c4 on c4.id=t4.idclub

                        left join matches m2 on m2.id=m.matchwinnervisitor
                        left join teams t5 on t5.id=m2.idlocal
                        left join teams t6 on t6.id=m2.idvisitor
                        left join clubs c5 on c5.id=t5.idclub
                        left join clubs c6 on c6.id=t6.idclub


        where  ro.idleague=$idLeague" . $_GET['l'] . "
        order by m.id asc") or die(mysql_error());
                                        while ($row = mysql_fetch_array($res)) {

                                            echo "<option value=\"" . $row['idMatch'] . "\">" . $row['idMatch'] . " " . $row['round'] . " " . $row['local'] . " " . $row['visitor'] . " " . $row['local1'] . "/" . $row['visitor1'] . " - " . $row['local2'] . " " . $row['visitor2'] . "</option>\n";
                                        }
                                        echo "</select> </td>";
                                    }
                                    ?>

                                </tr>
                                <tr>

                                    <?
                                    if (isset($_GET['r'])) {
                                        echo "   <td>Guanyador partit</td><td><select name=\"winnerVisitor\"><option>";

                                        $res = mysql_query("SELECT
            t1.name as local,
            t2.name as visitor,
            localResult,
            visitorResult,
            m.id as idMatch,
            m.statusId,
            ms.color,
            t1.id as localId,
            t2.id as visitorId,
            m.datetime,
            (select idnew from news_match where idmatch=m.id) as news,
            c1.image,
            c2.image,
            cx.complexName,
            cx.complexAddress,
            t3.name as local1,
            t4.name as visitor1,
            t5.name as local2,
            t6.name as visitor2,
            c3.image,
            c4.image,
            c5.image,
            c6.image,
            m1.id,
            m2.id,
                                    ro.name as round
            from matches m
			left join results r on m.id=r.idMatch
			left join teams t1 on t1.id=m.idLocal
			left join teams t2 on t2.id=m.idvisitor
			join rounds ro on ro.id=m.idround
                        left join clubs c1 on c1.id=t1.idclub
                        left join clubs c2 on c2.id=t2.idclub
                        left join complex cx on cx.id=m.place
			left join matchstatus ms on m.statusid=ms.id

                        left join matches m1 on m1.id=m.matchwinnerlocal
                        left join teams t3 on t3.id=m1.idlocal
                        left join teams t4 on t4.id=m1.idvisitor
                        left join clubs c3 on c3.id=t3.idclub
                        left join clubs c4 on c4.id=t4.idclub

                        left join matches m2 on m2.id=m.matchwinnervisitor
                        left join teams t5 on t5.id=m2.idlocal
                        left join teams t6 on t6.id=m2.idvisitor
                        left join clubs c5 on c5.id=t5.idclub
                        left join clubs c6 on c6.id=t6.idclub


        where  ro.idleague=$idLeague" . $_GET['l'] . "
        order by m.id,m.datetime asc") or die(mysql_error());
                                        while ($row = mysql_fetch_array($res)) {
                                            echo "<option value=\"" . $row['idMatch'] . "\">" . $row['idMatch'] . " " . $row['round'] . " " . $row['local'] . " " . $row['visitor'] . " " . $row['local1'] . "/" . $row['visitor1'] . " - " . $row['local2'] . " " . $row['visitor2'] . "</option>\n";
                                        }
                                        echo "</select> </td>";
                                    }
                                    ?>

                                </tr>



                                <tr>
                                    <td><input type="submit" name="submitNewMatch" value="Enviar" /></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div id="teams" class="block">
                        <h1>Equips a la lliga</h1>
                        <div class="innerblock">
                            <table width="100%">
                                <tr>
                                    <?
                                    $res = mysql_query("
                        select distinct t.id, name, idLeague from teams t
                            left join teams_leagues_per_season td
                                on td.idTeam=t.id where idLeague=" . $_GET['l'] . "

                                    order by name asc");
                                    $a = 1;
                                    $n = 1;
                                    if (mysql_num_rows($res) > 0) {
                                        while ($row = mysql_fetch_array($res)) {
                                            if ($row['id'] != $idTeam) {
                                                echo "<td style='color:#900;'>$n " . $row['name'] . " |<span style='cursor:pointer;' onClick='deleteTeamFromLeagueConfirm(" . $row['id'] . ");'>x</span>|�</td>";

                                                $idTeam = $row['id'];
                                                if ($a == 4) {
                                                    $a = 0;
                                                    echo "</tr><tr>";
                                                }
                                                $a++;
                                                $n++;
                                            }
                                        }
                                    } else {
                                        echo "<script type='text/javascript'>document.getElementById('teams').style.display='none';</script>";
                                    }
                                    ?>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="teamsDisabled" class="block">
                        <div style="float:left; width:50%;">
                            <h1>Equips no a la lliga</h1>
                        </div>
                        <div style="float:left; width:50%; text-align:right;">
                            X
                        </div>
                        <table width="100%">
                            <tr>
                                <?
                                $res = mysql_query("
                        select distinct t.id, name from teams t
                            left join teams_leagues_per_season td
                                on td.idTeam=t.id where t.id not in (select distinct t.id from teams t
                            left join teams_leagues_per_season td
                                on td.idTeam=t.id where idLeague=" . $_GET['l'] . ")


                                    order by name asc");
                                $i = 0;
                                if (mysql_num_rows($res) > 0) {

                                    $a = 0;
                                    while ($row = mysql_fetch_array($res)) {
                                        if ($row['id'] != $idTeam) {
                                            $i++;
                                            $a++;
                                            echo "<td>$i " . $row['id'] . " <a style='color:#fff; font-size:12px;' href='teamsInsertIntoLeague.php?idTeam=" . $row['id'] . "&l=" . $_GET['l'] . "&s=" . $_GET['s'] . "&d=" . $_GET['d'] . "'>" . $row['iad'] . " " . $row['name'] . "</a></td>";
                                            $idTeam = $row['id'];
                                            if ($a == 4) {
                                                $a = 0;
                                                echo "</tr><tr>";
                                            }
                                        }
                                    }
                                } else {
                                    
                                }
                                if (!$_GET['l']) {
                                    echo "<script type='text/javascript'>
                                      document.getElementById('teams').style.display='none';
                                      //document.getElementById('teamsDisabled').style.display='none';
                                       document.getElementById('rounds').style.display='none';
                                        document.getElementById('matches').style.display='none';

</script>";
                                }
                                ?>
                            </tr>
                        </table>

                    </div>

                </div>
            </div>

            <?
            if (!$_GET['l']) {
                echo "<script type='text/javascript'>document.getElementById('teamsDisabled').style.display='none';</script>";
            }
            ?>
    </body>
</html>