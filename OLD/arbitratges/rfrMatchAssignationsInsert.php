<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

$sql = "INSERT INTO cmptMatch_Referee (idMatch, idReferee) values (".$_GET['idMatch']."," . $_GET['idReferee'].")";

//echo $sql;
$res = mysql_query($sql) or die(mysql_error());
$lastInserted=mysql_insert_id();
$sql = "select t1.name as local, t2.name as visitor, c.complexName, c.complexAddress, ua.email, ua.name as refereeName, m.datetime, m.updateddatetime, r.id as idReferee, m.id as idMatch from matches m
join teams t1 on t1.id=m.idlocal
join teams t2 on t2.id=m.idvisitor
left join complex c on c.id=m.place
join cmptMatch_Referee cmr on cmr.idMatch=m.id
join rfrReferees r on r.id=cmr.idreferee
left join usersAccounts ua on ua.idReferee=r.id
where cmr.id=$lastInserted";
echo $sql;
$res = mysql_query($sql) or die(mysql_error());
$row=mysql_fetch_array($res);

mysql_query("DELETE FROM cmptMatch_Referee where idMatch=".$row['idMatch']." and idReferee=".$row['idReferee']." and id!=".$lastInserted);
if($row['updateddatetime']!="0000-00-00 00:00:00"){
    $date=dateformatCup($row['updateddatetime']);
    
}else{
      $date=dateformatCup($row['datetime']);
}
$date=dateformatCup($row['updateddatetime']);
$subject = $row['refereeName'] . " t'han designat àrbitre per al partit ".$row['local']." - ".$row['visitor'];
$out .="<div class=\"section\" style='font-weight:bold;'>Arbitratge</div>";
$out .="<div class=\"content\">Has estat designat àrbitre per al partit ".$row['local']." - ".$row['visitor'].", que es celebrarà $date a ".$row['complexName']." (".$row['complexAddress'].").</div>";
$email = $row['email'];
$clubName = $row['refereeName'];
$arbitre=1;
if (!empty($row['email'])) {
    include ("../mailSender.php");
}
?>
