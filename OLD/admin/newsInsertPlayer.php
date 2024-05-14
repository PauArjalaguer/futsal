
    <?
    include ("../includes/config.php");
    include ("../includes/funciones.php");
    conectar();
    $res = mysql_query("insert into players (name) values ('".$_GET['playerName']."')") or die(mysql_error());

    $lastId=mysql_insert_id();
    echo $lastId;
    ?>
