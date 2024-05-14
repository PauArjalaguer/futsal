<?
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

if (isset($_POST['submitNewMatch'])) {

    $sql = "SELECT name from rounds where idLeague=" . $_GET['l'] . " order by id desc limit 0,1";
    $res = mysql_query($sql);
    $r = mysql_fetch_array($res);


    $halfSeason = $r['name'] / 2;


    $sql2 = "SELECT name from rounds where id=" . $_GET['r'] . " order by id desc limit 0,1";
    $res2 = mysql_query($sql2);
    $r2 = mysql_fetch_array($res2);

    $actual = $r2['name'];

    $tornada = $r2['name'] + $halfSeason;


    $q = "insert into matches (idLocal, idVisitor,idRound) values (" . $_POST['local'] . "," . $_POST['visitor'] . "," . $_GET['r'] . ")";
//echo $q;
    mysql_query($q) or die(mysql_error());
    if ($actual <= $halfSeason) {

        $sql = "Select id from rounds where name=$tornada and idLeague=" . $_GET['l'];
        $res = mysql_query($sql);
        $row = mysql_fetch_array($res);
        $idRound = $row['id'];
        $q = "insert into matches (idLocal, idVisitor,idRound) values (" . $_POST['visitor'] . "," . $_POST['local'] . "," . $idRound . ")";
        //echo $q;
        mysql_query($q) or die(mysql_error());
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
            #divisions,rounds,matches{padding:15px;}

        </style>
        <link rel="stylesheet" href="../css/css.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Futsal Competicions</title>
    </head>

    <body>

        <div align="center">
            <div id="web">
                <div id="divisions" style="float:left; width:150px;">
                    <h1>Divisio</h1>
                    <?
                    $res = mysql_query("select * from leagues order by idSeason desc");
                    while ($row = mysql_fetch_array($res)) {
                        $style = "";
                        if ($_GET['l'] == $row['id']) {
                            $style = "style='font-weight:bold; color:#c00;'";
                        }
                        echo "<a href='?l=" . $row['id'] . "&s=" . $row['idSeason'] . "&d=" . $row['idDivision'] . "' $style >" . $row['name'] . "</a><br>";
                    }
                    ?>
                </div>

                <div id="teams" style="float:left; width:250px;">
                    <h1>Equips a la lliga</h1>
                    <?
                    $res = mysql_query("
                        select distinct t.id, name, idDivision from teams t
                            left join teams_divisions td
                                on td.idTeam=t.id where idDivision=" . $_GET['l'] . "

                                    order by name asc");
                    while ($row = mysql_fetch_array($res)) {
                        if ($row['id'] != $idTeam) {
                            echo "<a>" .$row['id']." " . $row['name'] . "</a><br />";
                            $idTeam = $row['id'];
                        }
                    }
                    ?>

                    <h1>Equips no a la lliga</h1>
                    <?
                    $res = mysql_query("
                        select distinct t.id, name, idDivision from teams t
                            left join teams_divisions td
                                on td.idTeam=t.id 

                                    order by name asc");
                    while ($row = mysql_fetch_array($res)) {
                        if ($row['id'] != $idTeam) {
                            echo "<a href='teamsInsertIntoLeague.php?idTeam=" . $row['id'] . "&l=" . $_GET['l'] . "&s=" . $_GET['s'] . "&d=" . $_GET['d'] . "'>" .$row['id']." "  . $row['name'] . "</a><br />";
                            $idTeam = $row['id'];
                        }
                    }
                    ?>

                </div>
                <div id="rounds" style="float:left; width:150px;">
                    <h1>Jornada</h1>
                    <?
                    if (isset($_GET['d'])) {
                        $n = 0;
                        $res = mysql_query("select * from rounds where idleague=" . $_GET['l']);
                        if (mysql_num_rows($res) > 0) {
                            while ($row = mysql_fetch_array($res)) {
                                $n++;
                                $style = "";

                                if ($_GET['r'] == $row['id']) {
                                    $style = "style='font-weight:bold; color:#c00;'";
                                }
                                echo "<a $style href='?l=" . $_GET['l'] . "&s=" . $_GET['s'] . "&d=" . $_GET['d'] . "&r=" . $row['id'] . "'>" . $n . "</a><br>";
                            }
                        } else {
                            echo "<form action='index.php?l=" . $_GET['l'] . "&s=" . $_GET['s'] . "&d=" . $_GET['d'] . "' method='POST'><input type='text' name='rounds' /><input type='submit' name='roundsSubmit' value='Enviar' /></form> ";
                        }
                    }
                    ?>
                </div>
                <div id="matches" style="float:left;width:350px;">
                    <h1>Partits</h1>
                    <?
                    if (isset($_GET['r'])) {
                        $res = mysql_query("select m.id as id, t1.id as localId,t1.name as localTeam, t2.id as visitorId,t2.name as visitorTeam from matches m join teams t1 on m.idlocal=t1.id join teams t2 on t2.id=m.idvisitor where  idround=" . $_GET['r']);

                        while ($row = mysql_fetch_array($res)) {
                            echo "<a href='result.php?m=" . $row['id'] . "&r=" . $_GET['r'] . "&d=" . $_GET['d'] . "'>" . $row['localTeam'] . " - " . $row['visitorTeam'] . "</a><br>";
                        }
                    }
                    ?>
                    <form action="<? echo $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']; ?>" enctype="multipart/form-data" method="post" >
                        <table cellpadding="3" cellspacing="0">
                            <tr>

                                <?
                                if (isset($_GET['r'])) {
                                    echo "   <td>Equip Local</td><td><select name=\"local\">";

                                    $query = "select * from teams_divisions td join teams t on t.id=td.idTeam where (t.id not in (select idlocal from matches where idround=" . $_GET['r'] . ") and t.id not in (select idvisitor from matches where idround=" . $_GET['r'] . ")) and idDivision=" . $_GET['l'];
                                    //echo $query;
                                    $res = mysql_query("select * from teams_divisions td join teams t on t.id=td.idTeam where (t.id not in (select idlocal from matches where idround=" . $_GET['r'] . ") and t.id not in (select idvisitor from matches where idround=" . $_GET['r'] . ")) and idDivision=" . $_GET['l'] . " order by name asc") or die(mysql_error());
                                    while ($row = mysql_fetch_array($res)) {
                                        echo "<option value=\"" . $row['idTeam'] . "\">" . $row['name'] . "</option>\n";
                                    }
                                    echo "</select> </td>";
                                }
                                ?>
                            </tr><tr>

                                <?
                                if (isset($_GET['r'])) {
                                    echo "   <td>Equip Visitant</td><td><select name=\"visitor\">";

                                    $res = mysql_query("select * from teams_divisions td join teams t on t.id=td.idTeam where (t.id not in (select idlocal from matches where idround=" . $_GET['r'] . ") and t.id not in (select idvisitor from matches where idround=" . $_GET['r'] . ")) and idDivision=" . $_GET['l'] . " order by name asc") or die(mysql_error());
                                    while ($row = mysql_fetch_array($res)) {
                                        echo "<option value=\"" . $row['idTeam'] . "\">" . $row['name'] . "</option>\n";
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


                </body>
                </html>
