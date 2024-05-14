
    <?

    $idSeason=2;
    include ("../includes/config.php");
    include ("../includes/funciones.php");
    conectar();
    $res = mysql_query("insert into players (name) values ('".$_GET['playerName']."')") or die(mysql_error());

    $lastId=mysql_insert_id();
    $res = mysql_query("insert into player_team_season (idplayer,idteam,idseason) values ($lastId,".$_GET['idTeam'].",$idSeason)") or die(mysql_error());
    ?>
