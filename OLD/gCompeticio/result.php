<?
include ("../includes/config.php");
include ("../includes/funciones.php");
include ("../includes/db.inc");
conectar();

if (isset($_POST['submit'])) {
    //actualitza resultat
    $sql = "INSERT INTO results (localResult, visitorResult, idMatch) values (" . $_POST['local'] . "," . $_POST['visitor'] . "," . $_POST['idMatch'] . ")";
    mysql_query($sql);
    if ($_POST['local'] > $_POST['visitor']) {
        $winner = 'local';
    } else
    if ($_POST['local'] < $_POST['visitor']) {
        $winner = 'visitor';
    } else {
        $winner = 'draw';
    }

    //actualitza com a jugat
    mysql_query("update matches set statusid=4 where id=" . $_POST['idMatch']);


    //actualitza classificacio local
    $sql = "Update classification set playedMatches=playedMatches+1, goalsMade=goalsMade+" . $_POST['local'] . ",goalsReceived=goalsReceived+" . $_POST['visitor'] . ",";
    if ($winner == 'local') {
        $sql.="wonMatches=wonMatches+1 ";
    } else if ($winner == 'visitor') {
        $sql.="lostMatches=lostMatches+1 ";
    } else {
        $sql.="drawMatches=drawMatches+1 ";
    }
    $sql .=" where idTeam=" . $_POST['localId'] . " and idLeague=" . $_POST['idLeague'];
    //echo $sql." <br /><br /><br /><br /><br />";
    mysql_query($sql) or die(mysql_error());

    //actualitza classificacio visitant
    $sql = "Update classification set playedMatches=playedMatches+1, goalsMade=goalsMade+" . $_POST['visitor'] . ",goalsReceived=goalsReceived+" . $_POST['local'] . ",";
    if ($winner == 'visitor') {
        $sql.="wonMatches=wonMatches+1 ";
    } else if ($winner == 'local') {
        $sql.="lostMatches=lostMatches+1 ";
    } else {
        $sql.="drawMatches=drawMatches+1 ";
    }
    $sql .=" where idTeam=" . $_POST['visitorId'] . " and idLeague=" . $_POST['idLeague'];
    //echo $sql." <br /><br /><br /><br /><br />";
    mysql_query($sql) or die(mysql_error());

    header("Location: index.php?r=" . $_GET['r'] . "&d=" . $_GET['d']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Untitled Document</title>
    </head>

    <body>
        <div style="width:960px; margin:auto;">
            <div style="border:0px solid;  padding:30px;">
                <table cellspacing="20" border="0" width="70%">
                    <form action="<? echo $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']; ?>"  enctype="multipart/form-data" name="form" method="post">
                        <?
                        $sql = "select idlocal, idvisitor, t1.name as LocalName, t2.name as VisitorName,localResult,visitorResult
from matches m 

join teams t1 on m.idlocal=t1.id 
join teams t2 on m.idVisitor=t2.id 
left join results r on r.idmatch=m.id
where m.id=" . $_GET['m'];
                        $res = mysql_query($sql) or die(mysql_error());
                        $row = mysql_fetch_array($res);
                        ?>
                        <tr>
                            <td valign="top">
                                <input type="text" style="width:80px; height:80px; font-size:56px; text-align:center; margin-right:10px;" value="<? echo $row['localResult']; ?>" name='local'  /><br />
                                <? echo $row['LocalName']; ?>
                                <?
                                include "../Classes/Teams_Class.php";
                                $teams = new Teams;
                                $teams->idTeam = $row['idlocal'];
                                $data = $teams->PlayersGetByTeamIdAndSeasonId();
                                foreach ($data as $players) {
                                    echo $players[1] . "<br />";
                                }
                                ?>
                                <input type="hidden" name="localId" value="<? echo $row['idlocal']; ?>" />


                            </td>
                            <td  valign="top">
                                <input type="text" style="width:80px; height:80px; font-size:56px; text-align:center; margin-right:10px;" name="visitor" value="<? echo $row['visitorResult']; ?>"  /><br />

                                <? echo $row['VisitorName']; ?><?
                                $teams->idTeam = $row['idvisitor'];
                                $data = $teams->PlayersGetByTeamIdAndSeasonId();
                                foreach ($data as $players) {
                                    echo $players[1] . "<br />";
                                } ?><input type="hidden" value="<? echo $row['idvisitor']; ?>" name="visitorId" />
                                <input type="hidden" value="<? echo $_GET['m']; ?>" name="idMatch" />
                                <input type="hidden" value="<? echo $_GET['d']; ?>" name="idLeague" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="submit" value="Enviar" name="submit" />
                            </td>
                        </tr>
                    </form>
                </table>
            </div>
        </div>
    </body>
</html>
