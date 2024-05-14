<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>

<?

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
if($_GET['own']!=1){$_GET['own']=0;}
$sql = "update player_goals_match set idPlayer=" . $_GET['idPlayer'] . ", own=" . $_GET['own'] . " where id=" . $_GET['idGoal'];
echo $sql;

$res = mysql_query($sql) or die(mysql_error());
?>
