<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>

<?

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$out="";
$res = mysql_query("select id,name,initialdate from rounds where idLeague=" . $_GET['idLeague']) or die(mysql_error());
while ($row = mysql_fetch_array($res)) {
    $out .= "\n\t\t\t\t<li id='roundsList_" . $row['id'] . "'> <img src='images/minus.gif'> <span onClick=\"roundsShowInfo(" . $row['id'] . ")\">Jornada " . $row['name'] . "   (" . invertdateformat($row['initialdate']) . ")</span></li>";
}
echo utf8_encode($out);
?>
