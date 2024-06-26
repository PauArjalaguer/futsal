<?php header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<?php

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
$sql = "
SELECT distinct p.name as playerName, floor(DATEDIFF(now(), birthdate) / 365.25) as age ,t.name as teamName, rate, paymentdate, d.name as divisionName, minAge, maxAge, minYear, maxYear, year(birthdate) as year, position, insuranceScan
    FROM  `player_team_season` pts
        JOIN players p ON p.id = pts.idplayer
        JOIN teams t ON t.id = pts.idteam
        JOIN clubs c ON c.id = t.idclub
        JOIN teams_divisions_per_season td ON td.idTeam = t.id  AND td.idSeason =pts.idseason
        JOIN divisions d ON d.id = td.idDivision
        JOIN rate_division_season rds ON td.idDivision = rds.idDivision  and rds.idseason=pts.idseason
		LEFT JOIN cmptAgesByDivision cad on cad.iddivision=d.id
		
WHERE idPlayer=" . $_GET['idPlayer'] . " and pts.idseason=$lastSeasonId";
//echo $sql;
$res = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($res);

$rate = $row['rate'];
$teamName = $row['teamName'];
$divisionName = $row['divisionName'];
$position = $row['position'];
$insuranceScan = $row['insuranceScan'];
$age = $row['age'];
$minAge = $row['minAge'];
$maxAge = $row['maxAge'];
$year = $row['year'];
$minYear = $row['minYear'];
$maxYear = $row['maxYear'];

function calculateMoneyBalance($idPlayer) {
    global $lastSeasonId;
    //BUSCO EL CLUB DEL JUGADOR

    $sql = "SELECT c.id FROM players p
join player_team_season pts on pts.idPlayer=p.id and pts.idseason=$lastSeasonId
join teams t on t.id=pts.idTeam
join clubs c on c.id=t.idclub
where p.id=$idPlayer";
    //echo $sql;
    $res = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($res);
    $club = $row['id'];
//echo "<br />Club : $club</br />";
    $residu = clubCashingBalance($club, 0);
    return $residu;
}

$sql = "
  select
    p.id
    , birthdate
    ,name
    ,image
    ,DNI
    ,DNIscan
    ,NIF, Address
    ,AddressNumber
    ,Floor as AddressFloor
    ,Door as AddressDoor
    ,City as AddressCity
    ,Province as AddressProvince
    ,CP
    ,Nationality
    ,CountryOfBirth
    ,CityOfBirth
    ,ProvinceOfBirth
    ,Email as playerEmail
    ,notes as playerNotes
    ,pcw.text as rejectedReason
    ,ispayed
	,(select count(*) from players p1 join player_team_season pts1 on pts1.idplayer=p1.id where p1.dni=p.dni and idseason=8 and statusPercent>50) as dniCount

  from players p
    join player_team_season pts on p.id=pts.idplayer
    left join playerCards_warned pcw on pcw.idCard=pts.id
  where p.id=" . $_GET['idPlayer'] . " and idTeam=" . $_GET['idTeam'] . " and pts.idseason=$lastSeasonId";
//echo $sql;

$res = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($res);
echo "<pre>";

echo "</pre>";
$money = calculateMoneyBalance($_GET['idPlayer']);
echo "Diners que té el club: " . $money;
$out = "";
$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'>";
$out .="<div style='width:70%; float:left;'><h2 onClick=\"playerCardEdit(" . $_GET['idPlayer'] . "," . $_GET['idTeam'] . ")\";>" . $row['name'] . " -  $teamName - $divisionName </h2></div>";
$out .="<div style='width:30%; float:left; text-align:right;'>";

//echo $money." - ".$rate;
/*
  if ($money >= $rate) {
  $out .="Valor de la fitxa: <input style='width:20px; border:0px; background-color:transparent;' type='text' value=\"$rate\" disabled id='rateDivisionChangeInput_1'/> &euro;  / $money &euro;<img alt='Canviar valor' style='vertical-align:baseline; cursor:pointer;' onClick='rateDivisionChangeEnableInput(1)' src='images/application_edit.png'><img onClick='playerCardMarkAsPayed(" . $_GET['idPlayer'] . "," . $_GET['idTeam'] . ",$rate)' src='images/accept.png'>";
  } else {
  $out .="El club no té saldo suficient per a la fitxa. ($money &euro;) ";
  }

 */

$out .="</div><div style='clear:both;'></div>";
$out .="</div>";

$out .="<div style='background-color:#fafafa;padding:20px; border:1px solid #999;border-bottom:1px solid #dfdfdf; border-top:0;'>";

if ($row['ispayed'] == 0) {



    //echo $rate." ".$money;
    if ($rate > $money) {
        $acceptStyle = "display:none;";
        $fakeStyle = " display:inline;";
        $rejectionMessage .= " El club no disposa de diners per a aquest fitxatge.";
    } else {
        $acceptStyle = "display:inline;";
        $fakeStyle = " display:none;";
        if ($position == 2) {
            if ($year >= $minYear and $year <= $maxYear) {
                $acceptStyle = "display:inline;";
                $fakeStyle = " display:none;";
            } else {
                //$acceptStyle = "display:none;";
                //$fakeStyle = " display:inline;";
                $rejectionMessage .= " El jugador no te l' edat per a jugar a aquesta categoria. ";
            }
        }
    }
    if ($row['dniCount'] > 1) {

        $rejectionMessage .= " Possible DNI duplicat.";
    }
    if ($rejectionMessage) {
        $out .="<div style='display:block;  padding:10px; color:#fff; -webkit-border-radius: 12px;border-radius: 12px; background-color:#a90329; '>$rejectionMessage</div>";
    }
    $out .="Valor de la fitxa: <input style='text-align:right;width:40px; color:#666;font-size:14px; border:0px; background-color:transparent;' type='text' value=\"$rate\" disabled id='rateDivisionChangeInput_1' onKeyUp='rateDivisionChangeVerifyAmount($money);'/> &euro;";
    $out .="<div id='acceptButton' style='width:70px; float:left; $acceptStyle -webkit-border-radius: 12px;border-radius: 12px; background-color:#006e2e; color:#fff;padding:10px; cursor:pointer; margin: 5px 0; ' onClick='playerCardMarkAsPayed(" . $_GET['idPlayer'] . "," . $_GET['idTeam'] . ",$rate)' >Acceptar</div>";
    $out .="<div id='acceptButtonDisabled'style='width:70px; float:left; $fakeStyle -webkit-border-radius: 12px;border-radius: 12px; background-color:#ddd; color:#fff;padding:10px;  margin:5px 0; '    >Acceptar</div>";
    $out .="<div id='rejectButton' style='display:inline;width:70px; float:left;-webkit-border-radius: 12px;border-radius: 12px; background-color:#a90329; color:#fff;padding:10px; cursor:pointer; margin: 5px  ; ' onClick='playerCardMarkAsRejected(" . $_GET['idPlayer'] . "," . $_GET['idTeam'] . ")'>Rebutjar</div>";
    $out .="<div id='changeButton' alt='Canviar valor' style='width:150px;-webkit-border-radius: 12px;border-radius: 12px; background-color:#a9e4f7; color:#fff;padding:10px; cursor:pointer; margin:5px 0;float:left; ' onClick='rateDivisionChangeEnableInput(1)' >Cambiar valor de fitxa</div>&nbsp;";
    $out .="<div style='clear:both;'>&nbsp;</div>";
}
$out .="</div>";
$out .="<div class='contentBoxContent'>";
if (!empty($row['rejectedReason'])) {
    $out .="<div style='width:90%; border:1px solid #c00; background-color:#fcc; margin:auto; padding:20px; margin-bottom: 20px;'>" . nl2br($row['rejectedReason']) . "</div>";
}

if (!empty($row['image'])) {
    $avatar = "http://www.futsal.cat/images/dynamic/playersImages/" . $row['image'];
} else {
    $avatar = "../images/dynamic/playersImages/defaultAvatar.jpg";
}

$out .="<div style='width:30%;float:left; margin-right:10px;' id='playerPictureUpload'>";
$out .="<div style='width:120px;'>";
$out .="<h2>Imatge</h2>";
$out .="<img class='playerCardEditImage pointer'  width=120  src='$avatar'><br />";

$out .="\n\t<span onClick='imageCapture(" . $row['id'] . "," . $_GET['idTeam'] . ");' class='pointer'><img src='images/webcam--plus.png'></span> | ";
$out .="\n\t<span onClick='imageUploader(" . $row['id'] . "," . $_GET['idTeam'] . ");' class='pointer'><img src='images/disk--plus.png'> </span> |";
$out .="\n\t<span onClick='imageCropFromTeamPicture(" . $row['id'] . "," . $_GET['idTeam'] . ");' class='pointer'><img src='images/scissors-blue.png'> </span><br />";


$out .="</div>";

if (!empty($row['DNIscan'])) {
    $out .="<div style='width:120px;'>";

    $out .="<div style='position:relative; width:20px;left:-10px; top:20px; padding:3px; background-color:#f8f8f8; ' class='playerCardEditImage pointer' onClick=\"playerCardEditDeleteFile(" . $_GET['idPlayer'] . ",'DNI'," . $_GET['idTeam'] . ")\";>";
    $out .="<img src='images/cross.png' /></div>";
    $out .="<a href='http://www.futsal.cat/images/dynamic/playersImages/" . $row['DNIscan'] . "' target=_blank><img class='playerCardEditImage pointer' src='http://www.futsal.cat/images/dynamic/playersImages/" . $row['DNIscan'] . "' width=120 /></a>";
    $out .="<h2>DNI</h2>";
    $out .="</div>";
}



$insuranceSQL = "select id,scan from player_insurance where idPlayer=" . $_GET['idPlayer'] . " and   scan is not null  order by id desc limit 0,1";
//$out .= "<div style='position:absolute; top:1px; left;1px; width:1000px;'>$insuranceSQL</div>";
$insuranceRes = mysql_query($insuranceSQL) or die(mysql_error());
$insuranceRow = mysql_fetch_array($insuranceRes);
//print_r($insuranceRow);

$insurance = mysql_num_rows($insuranceRes);
echo $row['insuranceScan'];
if ($insurance > 0 or strlen($insuranceScan) > 1) {
    if (strlen($insuranceScan) > 1) {
        $insuranceRow['scan'] = $insuranceScan;
        $insuranceRow['id']=1;
    }
    $out .="<div style='width:120px;'>";

    $out .="<div style='position:relative;margin:0px; width:20px;left:-10px; top:20px; padding:3px; background-color:#f8f8f8; ' class='playerCardEditImage pointer' onClick=\"playerCardEditDeleteFile(" . $_GET['idPlayer'] . ",'insurance'," . $_GET['idTeam'] . "," . $insuranceRow['id'] . ")\";><img src='images/cross.png' /></div>";
    $out .="<a href='http://www.futsal.cat/images/dynamic/playersImages/" . $insuranceRow['scan'] . "' target=_blank><img class='playerCardEditImage pointer' src='http://www.futsal.cat/images/dynamic/playersImages/" . $insuranceRow['scan'] . "' width=120 /></a>";
    $out .="<h2>Revisi&ocute; <a href='revisionUpdate.php?idPlayer=" . $_GET['idPlayer'] . "'>(Modificar)</a></h2>";
    $out .="</div>";
}


$out .="</div>";
$out .="<div style='width:65%; float:left;'>";
if ($row['birthdate']) {
    $b = explode("-", $row['birthdate']);
    $birthdate = $b[2] . "-" . $b[1] . "-" . $b[0];
}
$out .="<form class='jqtransform'>";
$out .="<input type='text' class='playerCardEditInput' id='playerName' value='" . ucwords(strtolower($row['name'])) . "'><label for='playerName' style='clear:both;'>Nom i cognoms <span>*</span></label><br />";
//$out .="<input type='text' class='playerCardEditInput' id='playerBirthDate' value='" . $birthdate . "'><label for='playerName'>Data de naixement dd-mm-aaaa</label><div style='clear:both'></div>";
$out .="<input type='text' style='width:45px; margin-right:11px;' class='playerCardEditInput' id='playerBirthDateDD' value='" . $b[2] . "'>";
$out .="<input type='text' style='width:45px; margin-right:11px;' class='playerCardEditInput' id='playerBirthDateMM' value='" . $b[1] . "'>";
$out .="<input type='text' style='width:45px;'  class='playerCardEditInput' id='playerBirthDateYY' value='" . $b[0] . "'><label for='playerName'>Data de naixement dd-mm-aaaa</label><div style='clear:both'></div>";
$out .="<input type='text' class='playerCardEditInput' id='playerDNI' value='" . $row['DNI'] . "' style='width:140px; float:left;margin-right:1px;'>&nbsp; <input type='text' class='playerCardEditInput' id='playerNIF' value='" . $row['NIF'] . "' style='width:30px;'><label for='playerDNI'>DNI / NIF <span>*</span></label><br />";

if (empty($row['DNIscan'])) {
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
    <param name=FlashVars value=\"idTeam=" . $_GET['idTeam'] . "&idPlayer=" . $_GET['idPlayer'] . "&fileType=DNI\">
      
    <!--[if !IE]>-->
    <object type=\"application/x-shockwave-flash\" data=\"flash/fileUploader.swf\" width=\"220\" height=\"30\">
        <param name=\"movie\" value=\"flash/fileUploader.swf?idTeam=" . $_GET['idTeam'] . "&idPlayer=" . $_GET['idPlayer'] . "&fileType=DNI\" />
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
        <param name=FlashVars value=\"idTeam=" . $_GET['idTeam'] . "&idPlayer=" . $_GET['idPlayer'] . "&fileType=DNI\">
  
<!--<![endif]-->
        <a href=\"http://www.adobe.com/go/getflash\">
            <img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Obtener Adobe Flash Player\" />
        </a>
        <!--[if !IE]>-->
    </object>
    <!--<![endif]-->
</object><label for='fileUploader'>DNI escanejat</label><div id='dniPlaceholder'></div><hr>";
}
if ($insurance == 0) {
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
    <param name=FlashVars value=\"idTeam=" . $_GET['idTeam'] . "&idPlayer=" . $_GET['idPlayer'] . "&fileType=insurance\">

    <!--[if !IE]>-->
    <object type=\"application/x-shockwave-flash\" data=\"flash/fileUploader.swf\" width=\"220\" height=\"30\">
        <param name=\"movie\" value=\"flash/fileUploader.swf?idTeam=" . $_GET['idTeam'] . "&idPlayer=" . $_GET['idPlayer'] . "&fileType=insurance\" />
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
        <param name=FlashVars value=\"idTeam=" . $_GET['idTeam'] . "&idPlayer=" . $_GET['idPlayer'] . "&fileType=insurance\">

<!--<![endif]-->
        <a href=\"http://www.adobe.com/go/getflash\">
            <img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Obtener Adobe Flash Player\" />
        </a>
        <!--[if !IE]>-->
    </object>
    <!--<![endif]-->
</object><label for='fileUploader'>Documentaci&ocute; revisi&ocute; medica </label><hr>";
}



$out .="<input type='text' class='playerCardEditInput' id='playerAddress' value='" . ucwords($row['Address']) . "'><label for='playerAddress' style='clear:both;'>Carrer <span>*</span></label><br />";
$out .="<input style='width:45px; margin-right:11px;  ' type='text' class='playerCardEditInput' id='playerAddressNumber' value='" . $row['AddressNumber'] . "'>";
$out .="<input style='width:45px;margin-right:11px;  ' type='text' class='playerCardEditInput' id='playerAddressFloor' value='" . $row['AddressFloor'] . "'>";
$out .="<input style='width:45px; ' type='text' class='playerCardEditInput' id='playerAddressDoor' value='" . $row['AddressDoor'] . "'><label for='playerAddressDoor'  style='clear:both;'>Numero/Pis /Porta</label><div style='clear:both'></div>";
$out .="<input type='text' class='playerCardEditInput' id='playerAddressCity' value='" . $row['AddressCity'] . "'><label for='playerAddressCity'>Poblac&ocute; <span>*</span></label><div style='clear:both'></div>";
$out .="<input type='text' class='playerCardEditInput' id='playerAddressProvince' value='" . $row['AddressProvince'] . "'><label for='playerAddressProvince'>Provincia <span>*</span></label><hr>";

$out .="<input type='text' class='playerCardEditInput' id='playerAddressCP' value='" . $row['CP'] . "'><label for='playerAddressCP'>Codi postal <span>*</span></label><hr>";


$out .="<input type='text' class='playerCardEditInput' id='playerNationality' value='" . $row['Nationality'] . "'><label for='playerNationality'>Nacionalitat <span>*</span></label><div style='clear:both'></div>";
$out .="<input type='text' class='playerCardEditInput' id='playerCountryOfBirth' value='" . $row['CountryOfBirth'] . "'><label for='playerCountryOfBirth'>Pais de naixement <span>*</span></label><div style='clear:both'></div>";
$out .="<input type='text' class='playerCardEditInput' id='playerProvinceOfBirth' value='" . $row['ProvinceOfBirth'] . "'><label for='playerProvinceOfBirth'>Provincia de naixement <span>*</span></label><hr>";


$sql2 = "select * from player_team_season where idplayer=" . $_GET['idPlayer'] . " and idSeason=$lastSeasonId and idTeam=" . $_GET['idTeam'];
$res2 = mysql_query($sql2) or die(mysql_error());
$numberOfPosition = mysql_num_rows($res2);
while ($row2 = mysql_fetch_array($res2)) {

    //$out .=$row2['id']." ".$row2['position'];
    $out .="\n\n<select class='playerCardEditSelect' id='playerPosition" . $row2['id'] . "' onChange='playerPositionUpdate(" . $row2['id'] . "," . $_GET['idPlayer'] . "," . $_GET['idTeam'] . ");'>";
    $out .="<option  value='' >&nbsp;</option>";
    $sql3 = "select id,position from playerPositions";
    $res3 = mysql_query($sql3) or die(mysql_error());
    $maxPositions = mysql_num_rows($res3);
    while ($row3 = mysql_fetch_array($res3)) {
        $selected = "";
        if ($row3['id'] == $row2['position']) {
            $selected = " selected";
        }
        $out .="<option $selected value='" . $row3['id'] . "' $selected>" . $row3['position'] . " </option>";
    }
    $out .="</select><label for='playerPosition'>Tipus de fitxa <span>*</span></label><div style='clear:both'></div>";
    $out .="<input type='text' class='playerCardEditInput' id='playerNumber' value='" . $row['number'] . "'><label for='playerName'>Dorsal</label><div style='clear:both'></div>";
}

if ($numberOfPosition < $maxPositions) {
    //$out .="<br ><br><span onClick=\"playerCardInsert(" . $_GET['idPlayer'] . "," . $_GET['idTeam'] . ")\";><img src='images/user-plus.gif'> Afegir nou tipus de fitxa</span>";
}
$out .="<hr>";
$out .="<input type='text' class='playerCardEditInput' id='playerEmail' value='" . $row['playerEmail'] . "'><label for='playerEmail'>Correu Electrònic</label><div style='clear:both'></div>";
$out .="<textarea rows=10 type='text' class='playerCardEditInput' id='playerNotes' value=''>" . $row['playerNotes'] . "</textarea><label for='playerNotes'>Notes</label>";


$out .="<br /><br /><input type='button' onClick='playerCardUpdate(" . $_GET['idPlayer'] . "," . $_GET['idTeam'] . ");' class='newPlayerNameButton' value='Desar' />&nbsp;";

$out .="<input type='button' onClick='playersByTeamId(" . $_GET['idTeam'] . ");' class='newPlayerNameButton' value='Cancelar' />";
$out .="</form>";
$out .="</div>";
$out .="<div style='clear:both;'></div>";


$out .="</div>";
$out .="<div style='border-top:1px solid;'>Valor de la fitxa: $rate euros.</div>";
$out .="</div>";

echo utf8_encode($out);
?>
