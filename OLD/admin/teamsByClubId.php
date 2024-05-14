<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>

    <?

    include ("../includes/config.php");
    include ("../includes/funciones.php");
    conectar();
    $res = mysql_query("select name,id from teams where idClub=" . $_GET['idClub']) or die(mysql_error());
    while ($row = mysql_fetch_array($res)) {

        $out .= "\n\t\t\t\t<li id='teamsList_".$row['id']."'> <img src='images/minus.gif'> <span onClick=\"teamsShowInfo(" . $row['id'] . ")\">" . $row['name'] . "</a></li>";
    }
    echo utf8_encode($out);
    ?>
