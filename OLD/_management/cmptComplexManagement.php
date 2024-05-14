<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?php

$idClub = $_GET['idClub'];
include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx = conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];

$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Pistess</h2></div>";
$out .="<div class='contentBoxContent'><table  class='playersTable' cellspacing=0>";

$sql = "SELECT c.id,complexName, complexAddress from complex c join clubs_complex cc on cc.idcomplex=c.id where cc.idclub=".$_COOKIE['idClub']."
order by complexName ";
//echo $sql;
$res=mysql_query($sql);
while ($row = mysql_fetch_array($res)) {
   
        if($n==1){
            $n=2;
        }else{
            $n=1;
        }
        $out .= "\n\t\t\t\t<tr><td onClick=\"cmptComplexEdit(" . $row['id']  . ");\" class='zebra$n' onClick=\"cmptComplexEdit(" . $row['id']  . ");\">" . $row['complexName'] . "</td><td onClick=\"cmptComplexEdit(" . $row['id']  . ");\" class='zebra$n'> &nbsp;</td><td onClick=\"cmptComplexEdit(" . $row['id']  . ");\" style='cursor:pointer;' class='zebra$n'>Editar</td></tr>";
    
}
$out .="</table></div></div>";
echo utf8_encode($out);
?>
