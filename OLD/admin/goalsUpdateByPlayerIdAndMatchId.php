<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$res123=  mysql_query("Select idplayer from player_goals_match where idPlayer=".$_GET['idPlayer']." and idMatch=".$_GET['idMatch']);
echo mysql_num_rows($res123);

if(mysql_num_rows($res123)==0){
    mysql_query("Insert into player_goals_match (idPlayer, idMatch, number, own) values (".$_GET['idPlayer'].",".$_GET['idMatch'].",".$_GET['number'].",".$_GET['own'].")") or die(mysql_error());
    echo $_GET['number'];
}else{
    $sqlU="Update player_goals_match set number=".$_GET['number'].", own=".$_GET['own']." where idPlayer=".$_GET['idPlayer'] ."and idMatch=".$_GET['idMatch'];
    echo $sqlU;
    mysql_query($sqlU) or die(mysql_error());

    echo $_GET['number'];
}

?>
