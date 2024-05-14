<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];

//Nom equip
$sql = "select
        diastinct p.id,
        p.name,
        birthdate,
        image,
        number,
        pts.position,
        pp.position as positionName,
        Address,
        Province,
City,
        CP,
        DNI,
        DNIscan,
        NIF,
        Nationality,
        CountryOfBirth,
        ProvinceOfBirth,
        pts.isPayed,
        prints,
        t.id as idTeam,
        t.name as teamName,
        pts.id as idCard,
        (select scan from player_insurance where idPlayer=p.id and scan is not null  order by id desc limit 0,1) as insurance,
        statusPercent,
        isRejected
    from player_team_season pts
        join teams t on t.id=pts.idteam
        left join players p on p.id=pts.idplayer
        left join playerPositions pp on pts.position=pp.id
    where
        isDeleted=0
        and idSeason=$lastSeasonId
        and idTeam=" . $_GET['idTeam'] . "
            and statusPercent=100
    order by statusPercent desc, isPayed desc,isRejected asc,p.id, position desc";
//echo $sql;
$res = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($res);

$out = "<h1>" . $row['teamName'] . "</h1>";


//Jugadors
$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Plantilla $lastSeasonName</h2></div>";
$out .="<div class='contentBoxContent'>";
$out .="<table class='playersTable' cellspacing=0><tr><th width=12>&nbsp</th><th width=350>Jugador</th><th>Tipus de fitxa</th><th width=250 >% complet</th><th width=10%>Accio</th></tr>";
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($res)) {

    $statusImage = "";
    $statusAlt = "";

    $counter = 0;

    $statusImage = "accept";
    $statusAlt = "Fitxa correcta";




    $percent = 10 * $counter;
    $percent = floor(($counter / $total) * 100);
    //mysql_query("UPDATE player_team_season set statusPercent=$percent where idPlayer=".$row['id']." and idSeason=$lastSeasonId") or die (mysql_error());
    $countWidth = $percent * 2;
    if ($percent < 100) {
        $statusImage = "warning";
        $statusAlt = "La fitxa no està completa";
    }

    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    $out .="<tr>";
    if ($id != $row['id']) {
        $out .="<td class='zebra$n'>";
        $out .="<a class='playerCardStatus'>";
        $out .="<span>$itemsCheckList</span>";
        $out .="<img src='images/$statusImage.png' alt='$statusAlt' title='$statusAlt' />";
        $out .="</a></td>";
    } else {
        $out .="<td class='zebra$n'>&nbsp;</td>";
    }
    $out .="<td class='zebra$n' >" . $row['name'] . "</td>";
    if (!empty($row['positionName'])) {
        $out .="<td class='zebra$n'>" . $row['positionName'] . "</td>";
    } else {
        $out .="<td class='zebra$n'>Pendent</td>";
    }
    if ($id != $row['id']) {
        $out .="<td class='zebra$n'><div style='width:200px; height:20px; background-color:#fff; border:1px solid #ddd;'><div style='width:" . $countWidth . "px; height:18px; background-color:#0bd; color:#fff; padding-top:2px;'>&nbsp;$percent %</div></div>";
        $out .="<td class='zebra$n'><img src='images/pencil.png' class='pointer' onClick='playerCardEdit(" . $row['id'] . "," . $row['idTeam'] . ");' > &nbsp; ";
        if ($row['isPayed'] != 1) {
            $out .="<img class='pointer' src='images/cross.png' onClick='playerCardDeleteConfirm(" . $row['idCard'] . ",\"" . str_replace("'", "", $row['name']) . "\"," . $row['idTeam'] . ");'>";
        }
    } else {
        $out .="<td class='zebra$n'>&nbsp;</td><td class='zebra$n'>&nbsp;</td>";
    }
    $out .="</td>";
    $out .="</tr>";
    $id = $row['id'];
}
$out .= "</table>";
$out .="</div>";
$out .="</div>";
$out .="<div class='contentBoxSpacer'></div>";
$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Nou jugador</h2></div>";
$out .="<div class='contentBoxContent'>";
$out .="<input type='text' class='newPlayerNameInput' id='newPlayerName'>";


$out .="&nbsp;<input type='button' onClick='teamsInsertPlayer(" . $_GET['idTeam'] . ");' class='newPlayerNameButton' id='newPlayerNameButton' value='Guardar' />";
$out .="<div style='clear:both; height:1px;'></div>";
$out .="<div id=\"suggestions\"></div>";
$out .="</div>";
$out .="</div>";


$out .="<div class='contentBoxSpacer'></div>";
$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Foto equip</h2></div>";
$out .="<div class='contentBoxContent'>";
$out .="<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"220\" height=\"30\" id=\"fileUploader\" align=\"middle\">
    <param name=\"movie\" value=\"flash/fileUploader.swf\" />
    <param name=\"quality\" value=\"high\" />
    <param name=\"bgcolor\" value=\"#ffffff\" />
    <param name=\"play\" value=\"true\" />
    <param name=\"loop\" value=\"true\" />
    <param name=\"wmode\" value=\"window\" />
    <param name=\"scale\" value=\"showall\" />
    <param name=\"menu\" value=\"true\" />
    <param name=\"devicefont\" value=\"false\" />
    <param name=\"salign\" value=\"\" />
    <param name=\"allowScriptAccess\" value=\"sameDomain\" />
    <param name=FlashVars value=\"idTeam=" . $_GET['idTeam'] . "&idPlayer=" . $_GET['idPlayer'] . "&fileType=teamImage\">

    <!--[if !IE]>-->
    <object type=\"application/x-shockwave-flash\" data=\"flash/fileUploader.swf\" width=\"220\" height=\"30\">
        <param name=\"movie\" value=\"flash/fileUploader.swf?idTeam=" . $_GET['idTeam'] . "&idPlayer=" . $_GET['idPlayer'] . "&fileType=teamImage\" />
        <param name=\"quality\" value=\"high\" />
        <param name=\"bgcolor\" value=\"#ffffff\" />
        <param name=\"play\" value=\"true\" />
        <param name=\"loop\" value=\"true\" />
        <param name=\"wmode\" value=\"window\" />
        <param name=\"scale\" value=\"showall\" />
        <param name=\"menu\" value=\"true\" />
        <param name=\"devicefont\" value=\"false\" />
        <param name=\"salign\" value=\"\" />
        <param name=\"allowScriptAccess\" value=\"sameDomain\" />
        <param name=FlashVars value=\"idTeam=" . $_GET['idTeam'] . "&idPlayer=" . $_GET['idPlayer'] . "&fileType=teamImage\">

<!--<![endif]-->
        <a href=\"http://www.adobe.com/go/getflash\">
            <img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Obtener Adobe Flash Player\" />
        </a>
        <!--[if !IE]>-->
    </object>
    <!--<![endif]-->
</object>";
$out .="</div>";
$out .="</div>";

echo utf8_encode($out);
?>
