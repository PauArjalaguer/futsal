<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();



if ($_GET['idReferee']==0){
$sql = "delete from cmptMatch_Referee where id=" . $_GET['idCmr'];

//echo $sql;
    $res = mysql_query($sql) or die(mysql_error());
}else {
    $sql = "update cmptMatch_Referee set idReferee=" . $_GET['idReferee'] . " where id=" . $_GET['idCmr'];

//echo $sql;
    $res = mysql_query($sql) or die(mysql_error());
    $sql = "select t1.name as local, t2.name as visitor, c.complexName, c.complexAddress, ua.email, ua.name as refereeName, m.datetime, m.updateddatetime, r.id as idReferee, m.id as idMatch from matches m
join teams t1 on t1.id=m.idlocal
join teams t2 on t2.id=m.idvisitor
join complex c on c.id=m.place
join cmptMatch_Referee cmr on cmr.idMatch=m.id
join rfrReferees r on r.id=cmr.idreferee
left join usersAccounts ua on ua.idReferee=r.id
where cmr.id=" . $_GET['idCmr'];
    echo $sql;
    $res = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($res);

    mysql_query("DELETE FROM cmptMatch_Referee where idMatch=" . $row['idMatch'] . " and idReferee=" . $row['idReferee'] . " and id!=" . $_GET['idCmr']);
    if ($row['updateddatetime'] != "0000-00-00 00:00:00") {
        $date = dateformatCup($row['updateddatetime']);
    } else {
        $date = dateformatCup($row['datetime']);
    }
    $subject = $row['refereeName'] . " t'han designat àrbitre per al partit " . $row['local'] . " - " . $row['visitor'];
    $out .="<div class=\"section\" style='font-weight:bold;'>Arbitratge</div>";
    $out .="<div class=\"content\">Has estat designat àrbitre per al partit " . $row['local'] . " - " . $row['visitor'] . ", que es celebrarà $date a " . $row['complexName'] . " (" . $row['complexAddress'] . ").</div>";
    $email = $row['email'];
    $clubName = $row['refereeName'];

    if (!empty($row['email'])) {
        include ("../mailSender.php");
    }
}
?>
