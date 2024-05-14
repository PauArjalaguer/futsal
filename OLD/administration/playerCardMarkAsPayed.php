<?

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];

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
 */
$sql1 = "update player_team_season set ispayed=1, paymentdate=now(),isRejected=0 where idPlayer=" . $_GET['idPlayer'] . " and idTeam=" . $_GET['idTeam'] . " and idSeason=" . $lastSeasonId;

$res1 = mysql_query($sql1);


$sql1 = "INSERT INTO  `admNotifications` (
`id` ,
`idTeam` ,
`idPlayer` ,
`notificationDate`,
`notificationType`
)
VALUES (
NULL ,  '" . $_GET['idTeam'] . "',  '" . $_GET['idPlayer'] . "',  now(),'accepted'
);";

echo $sql1;
$res1 = mysql_query($sql1);

//echo $row1['id'];

 if ($_GET['rate'] != $_GET['originalRate']) {
        mysql_query("INSERT INTO admrate_division_season_exceptions (idPlayer,rate, reason, datetime, idSeason) values (" . $_GET['idPlayer'] . "," . $_GET['rate'] . ",'" . $_GET['reason'] . "',now(),$lastSeasonId)") or die(mysql_error());
    }

echo $sql1;
?>
