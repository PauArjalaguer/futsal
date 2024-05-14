<?php
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];
$temporadaActual = $lastSeasonName;

/*
mysql_query("select p.name, dni, nif, city, province,birthdate, YEAR(CURDATE())-YEAR(birthdate)  as edat,  t.name, d.name,  rds.rate,
CASE WHEN adse.rate is null THEN rds.rate
        
         ELSE adse.rate END AS payed
from players p
join player_team_season pts on pts.idplayer=p.id
join teams t on t.id=pts.idteam
join teams_divisions_per_season tds on tds.idteam=t.id and tds.idseason=pts.idseason
join divisions d on d.id=tds.iddivision
join rate_division_season rds on rds.iddivision=tds.iddivision and rds.idseason=pts.idseason
left join  `admrate_division_season_exceptions` adse on adse.idplayer=t.id and adse.idseason=pts.idseason

order by d.id, t.name, p.name "); 
mysql_query("select p.name, dni, nif, city, province,birthdate, YEAR(CURDATE())-YEAR(birthdate)  as edat,  t.name, d.name,  rds.rate,
CASE WHEN adse.rate is null THEN rds.rate
        
         ELSE adse.rate END AS payed
from players p
join player_team_season pts on pts.idplayer=p.id
join teams t on t.id=pts.idteam
join teams_divisions_per_season tds on tds.idteam=t.id and tds.idseason=pts.idseason
join divisions d on d.id=tds.iddivision
join rate_division_season rds on rds.iddivision=tds.iddivision and rds.idseason=pts.idseason
left join  `admrate_division_season_exceptions` adse on adse.idplayer=t.id and adse.idseason=pts.idseason

order by d.id, t.name, p.name ");
*/
$res = mysql_query("select
                                        distinct t.id
                                        , t.name
                                        , c.id as idClub
                                        , c.name as clubName
                                    from teams t
                                        left join teams_divisions_per_season td on td.idteam=t.id
                                        join clubs c on c.id=t.idclub

                                    where 
        idSeason=$lastSeasonId and
        (upper(c.name) like '%".strtoupper($_GET['search'])."%' or upper(t.name) like '%".strtoupper($_GET['search'])."')
                                    order by c.name");

while ($row = mysql_fetch_array($res)) {
    if ($row['idClub'] != $idClub) {
        $out .=  "<li style='font-weight:bold;' onClick='clubCashingInfo(" . $row['idClub'] . ")'><img src='images/drafts-open.gif' style='vertical-align:text-bottom;' > " . $row['clubName'] . "</li>";
    $out .= "<li onClick='clubRefereeReceipts(" . $row['idClub'] . ")'>Rebuts</li>";
        
    }
    $out .= "\n\t\t\t\t<li id='teamsList_" . $row['id'] . "'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";
    $out .= "- <span onClick=\"playersByTeamId(" . $row['id'] . ");\"> <a href='#init'>" . $row['name'] . "</a></span></li>";
    $idClub = $row['idClub'];
}
echo utf8_encode($out);
?>

