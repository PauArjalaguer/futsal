<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

$out = "<h1>Jornada " . invertdateformat($_GET['date']) . "</h1>";

$res = mysql_query("select r.id, r.name as Round, l.name, l.id as idLeague from rounds r join leagues l on l.id=r.idleague where initialdate='" . $_GET['date'] . "' or enddate='" . $_GET['date'] . "'") or die(mysql_error());
while ($row = mysql_fetch_array($res)) {
    $sql2="SELECT idplayer, SUM( yellowcards ) AS c
FROM  `player_card_match` pcm
JOIN matches m ON m.id = pcm.idmatch
JOIN rounds r ON r.id = m.idround
JOIN leagues l ON l.id = r.idleague
WHERE l.idseason =8 and l.id=".$row['idLeague']." and c>=5
GROUP BY idplayer
ORDER BY c DESC
LIMIT 0 , 1000";


    $out .="<div class='contentBox'>";
    $out .="<div class='contentBoxHeader'><h2>" . $row['name'] . " Jornada " . $row['Round'] . " " . $row['id'] . "</h2></div>";
    $out .="<div class='contentBoxContent'>";


    $resP = mysql_query("select pbr.id,p.name,rounds,money, t.id as teamId,t.name as teamName,comment from player_bans_round pbr join players p on pbr.idplayer=p.id join player_team_season pts on p.id=pts.idplayer join teams t on pts.idteam=t.id where pbr.idround=" . $row['id'] . " and idseason=8 order by t.id") or die(mysql_error());

    $out .="<table class='playersTable' cellspacing=0>";
    $out .="<tr><th width=15%>Jugador</th><th width=20%>Equip</th><th align=center width=10%>Sanció</th><th align=center width=35%>Partits sancionat</th><th width=20%>Comentari</th><th>&nbsp;</th></tr>";
    $n = "";
    while ($rowP = mysql_fetch_array($resP)) {
        if ($n == 1) {
            $n = 2;
        } else {
            $n = 1;
        }
        $out .="<tr><td class='zebra$n'>" . $rowP['name'] . "</td><td class='zebra$n'>" . $rowP['teamName'] . "</td><td class='zebra$n'>" . $rowP['rounds'] . " partits i " . $rowP['money'] . " euros </td><td class='zebra$n'>";
        $sqlM = "SELECT t1.name as localName, t2.name as visitorName, r.name as roundName, l.name as leagueName
FROM rounds r
join leagues l on r.idleague=l.id
JOIN matches m ON r.id = m.idround
JOIN teams t1 ON t1.id = m.idLocal
JOIN teams t2 ON t2.id = m.idvisitor
WHERE initialdate >  '" . $_GET['date'] . "'
and (idLocal=" . $rowP['teamId'] . " or idVisitor=" . $rowP['teamId'] . ")
AND idLeague =" . $row['idLeague'] . " Limit 0," . $rowP['rounds'];
        //$out .="<td>$sqlM</td>";
        $resM = mysql_query($sqlM) or die(mysql_error());
        while ($rowM = mysql_fetch_array($resM)) {
            $out .=$rowM['localName'] . "-" . $rowM['visitorName'] . "<br />";
        }
        $out .=" </td><td class='zebra$n'>" . $rowP['comment'] . "</td><td class='zebra$n'><img src='images/pencil.png' class='pointer' onClick='comiteeEditBan(" . $rowP['id'] . "," . $row['id'] . "," . "\"" . $_GET['date'] . "\")'></td></tr>";
    }
    $out .="<tr><td>&nbsp;</td></tr></table>";
    $out .="<span class='pointer' onClick=\"comiteeNewBan(" . $row['id'] . ",'" . $_GET['date'] . "');\"><img src='images/user-plus.gif'> Nova sanció</span><br />";
    $out .="<img src='images/document.gif'> <span class='pointer' onClick=\"comiteeGenerateWord('" . $_GET['date'] . "');\">Exportar a Word</span>";

    $out .="</div>";
    $out .="<div class='contentBoxSpacer'></div>";
}

$out .="<div id='comiteeResult'></div>";

echo utf8_encode($out);
?>
