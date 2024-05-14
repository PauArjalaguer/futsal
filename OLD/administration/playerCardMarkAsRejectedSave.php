<?

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];

$sql1 = "select id from player_team_season where idPlayer=" . $_GET['idPlayer'] . " and idTeam=" . $_GET['idTeam'] . " and idSeason=" . $lastSeasonId;
$res1 = mysql_query($sql1);
$row=mysql_fetch_array($res1);

$idCard=$row['id'];

$sql1 = "INSERT INTO playerCards_warned (idCard, text, datetime) values ($idCard,'".$_GET['text']."', now());";
$res1 = mysql_query($sql1) or die(mysql_error());
echo $sql1;

$sql1 = "INSERT INTO  `admNotifications` (
`id` ,
`idTeam` ,
`idPlayer` ,
`notificationDate`,
`notificationType`,
`notificationText`
)
VALUES (
NULL ,  '" . $_GET['idTeam'] . "',  '" . $_GET['idPlayer'] . "',  now(),'rejected','".$_GET['text']."'
);";


$res1 = mysql_query($sql1) or die(mysql_error());
mysql_query("UPDATE player_team_season set isRejected=1 where id=$idCard");



echo $sql1;
?>
