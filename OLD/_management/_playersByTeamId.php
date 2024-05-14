<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx = conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];

//LLISTA FITXES PER AQUEST TEMPORADA
//Nom equip
$sql = "select
        distinct p.id,
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
        (select scan from player_insurance where idPlayer=p.id and  scan is not null  order by id desc limit 0,1) as insurance,
 isRejected,
statusPercent,
paymentDate
    from player_team_season pts
        join teams t on t.id=pts.idteam
        left join players p on p.id=pts.idplayer
        left join playerPositions pp on pts.position=pp.id
    where
        isDeleted=0
        and idSeason=$lastSeasonId
        and idTeam=" . $_GET['idTeam'] . " and t.idClub=".$_COOKIE['idClub']."
       order by statusPercent asc, isRejected desc , isPayed asc,p.id, position desc";
// echo $sql;
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


    //VERIFICA ESTATUS DE LES FITXES
    $statusImage = "";
    $statusAlt = "";
    $css = "";

    $counter = 0;
    if($row['isPayed']==1 and $row['paymentDate']>'2017-12-05 13:47:22'){
    $row['isPayed']=0;
    
    }
    $statusImage = "accept";
    $statusAlt = "Fitxa correcta";
    $itemsCheckList = "";
    if (!empty($row['birthdate'])) {

        if ($row['birthdate'] != "0000-00-00") {

            $counter++;
        }
    } else {
        $itemsCheckList .="<div class='itemsCheckList'> Data de naixement</div>";
    }
    if (!empty($row['image'])) {

        /* 2 */
        $counter++;
    } else {
        $itemsCheckList .="<div class='itemsCheckList'>Fotografía</div>";
    }
    if (!empty($row['Address'])) {

        /* 3 */
        $counter++;
    } else {
        $itemsCheckList .="<div class='itemsCheckList'>Adreça</div>";
    }
    if (!empty($row['Province'])) {

        /* 4 */
        $counter++;
    } else {
        $itemsCheckList .="<div class='itemsCheckList'>Provincia</div>";
    }
    if (!empty($row['CP'])) {
        /* 5 */

        $counter++;
    } else {
        $itemsCheckList .="<div class='itemsCheckList'>Codi postal</div>";
    }
    if (!empty($row['DNI'])) {

        /* 6 */
        $counter++;
    } else {
        $itemsCheckList .="<div class='itemsCheckList'>DNI</div>";
    }

    if (!empty($row['NIF'])) {

        /* 8 */
        $counter++;
    } else {
        $itemsCheckList .="<div class='itemsCheckList'>NIF</div>";
    }
    if (!empty($row['Nationality'])) {

        /* 9 */
        $counter++;
    } else {
        $itemsCheckList .="<div class='itemsCheckList'>Nacionalitat</div>";
    }
    if (!empty($row['CountryOfBirth'])) {

        /* 10 */
        $counter++;
    } else {
        $itemsCheckList .="<div class='itemsCheckList'>Pais de naixement</div>";
    }
    if (!empty($row['ProvinceOfBirth'])) {
        /* 11 */

        $counter++;
    } else {
        $itemsCheckList .="<div class='itemsCheckList'>Provincia de naixement</div>";
    }

    if (!empty($row['position'])) {

        /* 11 */
        $counter++;
    } else {
        $itemsCheckList .="<div class='itemsCheckList'>Tipus de fitxa</div>";
    }
    if (!empty($row['insurance'])) {
        /* 12 */
        $counter++;
    } else {
        $itemsCheckList .="<div class='itemsCheckList'>Fotocopia assegurança</div>";
    }
    if (!empty($row['City'])) {
        /* 13 */
        $counter++;
    } else {
        $itemsCheckList .="<div class='itemsCheckList'>Ciutat</div>";
    }

    if ($row['statusPercent'] < 100) {
        $trace .=" less<100 ";
        $statusImage = "book-open";
    } else {
        if ($row['prints'] == 0) {
            $trace .= " p";
            $statusImage = "print";
            $statusAlt = "Pendent imprimir fitxa";
            $itemsCheckList = "<div class='itemsCheckList'>Pendent imprimir fitxa</div>";
        }
        if ($row['isPayed'] == 1) {
            $trace .=" payed ";
            $statusImage = "print";
            $css = " style='font-weight:bold; color:#090;' ";
        } else {
            $trace .=" not payed ";
            $statusImage = "euro";
            $itemsCheckList = "<div class='itemsCheckList'>Pendent pagament</div>";
        }

        if ($row['isRejected'] == 1) {
            $trace .=" rejected";
            $statusImage = "warning";
            $css = " style='font-weight:bold; color:#c00;' ";
            $itemsCheckList = "<div class='itemsCheckList'>Fitxa rebutjada, reviseu les dades</div>";
        }
    }





    //$out .=$itemsCheckList;
    $total = 13;


    $percent = 10 * $counter;
    $percent = floor(($counter / $total) * 100);
    mysql_query("UPDATE player_team_season set statusPercent=$percent where idPlayer=" . $row['id'] . " and idSeason=$lastSeasonId") or die(mysql_error());
    $countWidth = $percent * 2;

    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }

    //LLISTA DE FITXES
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
    $out .="<td class='zebra$n' $css >" . $row['name'] . "$traace</td>";

    $trace = "";
    if (!empty($row['positionName'])) {
        $out .="<td class='zebra$n' $css>" . $row['positionName'] . "</td>";
    } else {
        $out .="<td class='zebra$n'>Pendent</td>";
    }
    if ($id != $row['id']) {
        $out .="<td class='zebra$n'><div style='width:200px; height:20px; background-color:#fff; border:1px solid #ddd;'><div style='width:" . $countWidth . "px; height:18px; background-color:#0bd; color:#fff; padding-top:2px;'>&nbsp;$percent %</div></div>";

        $out .="<td class='zebra$n'>";
        if ($row['isPayed'] != 1) {
            $out .="<img src='images/pencil.png' class='pointer' onClick='playerCardEdit(" . $row['id'] . "," . $row['idTeam'] . ");' > &nbsp; ";
            $out .="<img class='pointer' src='images/cross.png' onClick='playerCardDeleteConfirm(" . $row['idCard'] . ",\"" . str_replace("'", "", $row['name']) . "\"," . $row['idTeam'] . ");'>";
        } else {
            $out .="<a href='playerCardPrint.php?idPlayer=" . $row['id'] . "' target=_blank><img src='images/print.png'></a>";
        }
    }
    $out .="</td>";
    $out .="</tr>";
    $id = $row['id'];
}
$out .= "</table>";
$out .="</div>";
$out .="</div>";
$out .="<div class='contentBoxSpacer'></div>";

//FORMULARI CREACIÓ JUGADOR

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


//TRASPASSOS
$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Traspàs de jugador</h2></div>";
$out .="<div class='contentBoxContent'>";
$out .="DNI del jugador (sense lletra)  <input type='text' class='newPlayerNameInput' id='playerTransferDNI'>";
$out .="<input type='button' onClick='playerTransferDNISearch(".$_GET['idTeam'].");' class='newPlayerNameButton' id='newPlayerNameButton' value='Buscar' />";
$out .="<div style='clear:both; height:1px;'></div>";
$out .="<div id=\"playerTransferDNISearch\"></div>";
$out .="</div>";
$out .="</div>";



//RECUPERAR FITXES ANTIGUES
$out .="<div class='contentBoxSpacer'></div>";
$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Recuperar fitxes antigues</h2></div>";
$out .="<div class='contentBoxContent'>";
$out .="<table class='playersTable' cellspacing=0><tr><th width=550>Jugador</th><th width=10%>Accio</th></tr>";


$teamsString = $_GET['idTeam'];
$sql = "select idTeamTransferer from teams_cession_relation where idTeamTransfered=" . $_GET['idTeam'] . " ";
$res = mysql_query($sql) or die(mysql_error());
$numOfTeams = mysql_num_rows($res);
while ($row = mysql_fetch_array($res)) {
    $teamsString .="," . $row['idTeamTransferer'];
}

$sql="select idclub from teams where id=".$_GET['idTeam'];
$res = mysql_query($sql) or die(mysql_error());
$row=mysql_fetch_array($res);
$club=$row['idclub'];

$sql="select id from teams where idclub=$club";
$res = mysql_query($sql) or die(mysql_error());
$numOfTeams = mysql_num_rows($res);
while ($row = mysql_fetch_array($res)) {
    $teamsString .="," . $row['id'];
}


$sql = "select  distinct p.id,p.name, t.name as teamName from players p
join  player_team_season pts on pts.idplayer=p.id
join teams t on t.id=pts.idTeam
where statusPercent=100 and idteam in ($teamsString) and t.idClub=".$_COOKIE['idClub']."   and idSeason !=$lastSeasonId  order by p.name asc";
// echo $sql;
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($res)) {
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    $out .="<tr><td class='zebra$n'>" . $row['name'] . "</td><td class='zebra$n' onClick='playersInsertIntoPlayerTeamSeason(" . $row['id'] . "," . $_GET['idTeam'] . ");'>Activar</td></tr>";
}

$out .="</table></div>";
$out .="</div>";




$out .="<div class='contentBoxSpacer'></div>";




//PUJAR FOTO DE L' EQUIP
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
mysql_close($idcnx);
?>
