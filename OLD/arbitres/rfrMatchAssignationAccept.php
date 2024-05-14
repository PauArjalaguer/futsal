<?php

include ("../includes/config.php");
include ("../includes/funciones.php");

conectar ();
$sql = "update cmptMatch_Referee set accepted=1 where idMatch=".$_GET['idMatch']." and idReferee=".$_GET['idReferee'];
echo $sql;
$res = mysql_query($sql) or die(mysql_error());


$sql = "select t1.name as local, t2.name as visitor, c.complexName, c.complexAddress, ua.email, ua.name as refereeName, m.datetime, m.updateddatetime, r.id as idReferee, m.id as idMatch from matches m
join teams t1 on t1.id=m.idlocal
join teams t2 on t2.id=m.idvisitor
left join complex c on c.id=m.place
join cmptMatch_Referee cmr on cmr.idMatch=m.id
join rfrReferees r on r.id=cmr.idreferee
left join usersAccounts ua on ua.idReferee=r.id
where cmr.idMatch=".$_GET['idMatch']." and cmr.idReferee=".$_GET['idReferee'];
$res = mysql_query($sql) or die(mysql_error());
$row=mysql_fetch_array($res);
$subject = $row['refereeName'] . " ha acceptat ser àrbitre per al partit ".$row['local']." - ".$row['visitor'];
$out .="<div class=\"section\" style='font-weight:bold;'>Arbitratge</div>";
$out .="<div class=\"content\">".$row['refereeName'] . " ha acceptat ser àrbitre al partit ".$row['local']." - ".$row['visitor'].", que es celebrarà $date a ".$row['complexName']." (".$row['complexAddress'].").</div>";
$email = "comite.arbitres@futsal.cat";
$clubName = $row['refereeName'];
$arbitre=1;
if (!empty($row['email'])) {
    include ("../mailSender.php");
}




?>
