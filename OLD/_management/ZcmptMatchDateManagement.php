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
$out .="<div class='contentBoxHeader'><h2>Partits</h2></div>";
$out .="<div class='contentBoxContent'><table  class='playersTable' cellspacing=0>";

$sql = "select m.id as idMatch, t1.id as idLocal, t1.name as local, t2.id as idVisitor, t2.name as visitor, datetime, r.name as roundname, (select count(*) from cmptMatch_Referee where idmatch=m.id) as nomenaments from matches m
join teams t1 on t1.id=m.idlocal
join teams t2 on t2.id=m.idvisitor
join clubs c on c.id=t1.idclub
join rounds r on r.id=m.idround
where statusid<>4 and t1.idclub=".$_COOKIE['idClub']."
order by r.name+0 ";
//echo $sql;
$res=mysql_query($sql);
while ($row = mysql_fetch_array($res)) {
    if ($row['nomenaments'] < 5) {
        if($n==1){
            $n=2;
        }else{
            $n=1;
        }
        $out .= "\n\t\t\t\t<tr><td onClick=\"cmptMatchDateChange(" . $row['idLocal'] . "," . $row['idMatch'] . ");\" class='zebra$n' onClick=\"cmptMatchDateChange(" . $row['idLocal'] . "," . $row['idMatch'] . ");\">" . $row['local'] . " - " . $row['visitor'] . "</td><td onClick=\"cmptMatchDateChange(" . $row['idLocal'] . "," . $row['idMatch'] . ");\" class='zebra$n'> " . invertdateformat($row['datetime']) . "</td><td onClick=\"cmptMatchDateChange(" . $row['idLocal'] . "," . $row['idMatch'] . ");\" style='cursor:pointer;' class='zebra$n'>Editar</td></tr>";
    }
}
$out .="</table></div></div>";
echo utf8_encode($out);
?>
