<?

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();





$r = mysql_query("SELECT * FROM results where idMatch=" . $_GET['idMatch']);
if (mysql_num_rows($r) == 0) {

    $sql = "INSERT INTO results (localResult, visitorResult, idMatch) values (" . $_GET['local'] . "," . $_GET['visitor'] . "," . $_GET['idMatch'] . ")";
    mysql_query($sql);
    if ($_GET['local'] > $_GET['visitor']) {
        $winner = 'local';
    } else
    if ($_GET['local'] < $_GET['visitor']) {
        $winner = 'visitor';
    } else {
        $winner = 'draw';
    }


//crea els gols
    for ($a = 1; $a <= $_GET['local']; $a++) {
        //echo "Gol local:" . $a . "<br />";
        mysql_query("insert into player_goals_match (idMatch,idTeam) values (" . $_GET['idMatch'] . "," . $_GET['localId'] . ")") or die(mysql_error());
    }
    for ($a = 1; $a <= $_GET['visitor']; $a++) {
        //echo "Gol visitant:" . $a . "<br />";
        mysql_query("insert into player_goals_match (idMatch,idTeam) values (" . $_GET['idMatch'] . "," . $_GET['visitorId'] . ")") or die(mysql_error());
    }

//actualitza com a jugat
    mysql_query("update matches set statusid=4 where id=" . $_GET['idMatch']);

//verifica si existeix registre per a l'equip local a l'actual lliga, si no el crea
    $sql = "select count(*) as count from  classification where idTeam=" . $_GET['localId'] . " and idLeague=" . $_GET['idLeague'];

    $res = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($res);

    if ($row['count'] == 0) {
        //echo "Inserta local";
        mysql_query("Insert into classification (idTeam,idLeague) values (" . $_GET['localId'] . "," . $_GET['idLeague'] . ")") or die(mysql_error());
    }
//verifica si existeix registre per a l'equip visitant a l'actual lliga

    $sql = "select count(*) as count from  classification where idTeam=" . $_GET['visitorId'] . " and idLeague=" . $_GET['idLeague'];
    $res = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($res);
    if ($row['count'] == 0) {
        echo "Inserta visitant";
        mysql_query("Insert into classification (idTeam,idLeague) values (" . $_GET['visitorId'] . "," . $_GET['idLeague'] . ")") or die(mysql_error());
    }


//actualitza classificacio local
    $sql = "Update classification set playedMatches=playedMatches+1, goalsMade=goalsMade+" . $_GET['local'] . ",goalsReceived=goalsReceived+" . $_GET['visitor'] . ",";
    if ($winner == 'local') {
        $sql.="wonMatches=wonMatches+1 ";
    } else if ($winner == 'visitor') {
        $sql.="lostMatches=lostMatches+1 ";
    } else {
        $sql.="drawMatches=drawMatches+1 ";
    }
    $sql .=" where idTeam=" . $_GET['localId'] . " and idLeague=" . $_GET['idLeague'];
//echo $sql." <br /><br /><br /><br /><br />";
    mysql_query($sql) or die(mysql_error());

//actualitza classificacio visitant
    $sql = "Update classification set playedMatches=playedMatches+1, goalsMade=goalsMade+" . $_GET['visitor'] . ",goalsReceived=goalsReceived+" . $_GET['local'] . ",";
    if ($winner == 'visitor') {
        $sql.="wonMatches=wonMatches+1 ";
    } else if ($winner == 'local') {
        $sql.="lostMatches=lostMatches+1 ";
    } else {
        $sql.="drawMatches=drawMatches+1 ";
    }
    $sql .=" where idTeam=" . $_GET['visitorId'] . " and idLeague=" . $_GET['idLeague'];
//echo $sql." <br /><br /><br /><br /><br />";
    mysql_query($sql) or die(mysql_error());
}

//Verifica si hi ha un partit penjant d'aquest.
/*echo "SELECT id, matchWinnerLocal, matchWinnerVisitor FROM matches  where matchWinnerLocal=".$_GET['idMatch'] ." or matchWinnerVisitor=" . $_GET['idMatch']."\n";
$q = mysql_query("SELECT id, matchWinnerLocal, matchWinnerVisitor FROM matches  where matchWinnerLocal=" . $_GET['idMatch'] . " or matchWinnerVisitor=" . $_GET['idMatch']) or die(mysql_error());

if (mysql_num_rows($q)>= 0) {sql
    $r4=my_fetch_array($q);
    echo "hi ha partit penjat ".$r4['id']."\n";
    if ($_GET['idMatch'] == $r4['matchWinnerLocal']) {
        echo "Partit a actualitzar= ".$r4['matchWinnerLocal']."\n";
        echo "Penja de local\n";
        if ($winner = "local") {
            echo "local passa com a local\n";
            echo "update matches set idlocal=" . $_GET['localId'] . " where id=" . $r4['matchWinnerLocal']."\n";
            mysql_query("update matches set idlocal=" . $_GET['localId'] . " where id=" . $r4['id']) or die(mysql_error());
        } else {
            echo "visitant passa com a local\n";
            mysql_query("update matches set idVisitor=" . $_GET['localId'] . " where id=" . $r4['id']);
        }
    } else if ($_GET['idMatch'] == $r4['matchWinnerVisitor']) {
        echo "Penja de visitant\n";
         echo "Partit a actualitzar= ".$r4['matchWinnerVisitor']."\n";
        if ($winner = "visitor") {
            echo "Visitant passa a local\n";
            mysql_query("update matches set idlocal=" . $_GET['visitorId'] . " where id=" . $r4['id']);
        } else {
            echo "Visitant passa a visitant\n";
            mysql_query("update matches set idVisitor=" . $_GET['visitorId'] . " where id=" . $r4['id']);
        }
    }
}*/
?>