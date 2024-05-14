
<div style='width:9cm;height:7cm; border:1px dashed #000;padding:0.5cm;'><?php



//echo $_GET['idTeam'];
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];

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
  from players p
  where p.id=" . $_GET['idPlayer'];
//echo $sql;

$res = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($res);

$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2 onClick=\"playerCardEdit(" . $_GET['idPlayer'] . "," . $_GET['idTeam'] . ")\";>" . $row['name'] . " " . $row['idCard'] . "</h2></div>";
$out .="<div class='contentBoxContent'>";

if (!empty($row['image'])) {
    $avatar = "../images/dynamic/playersImages/" . $row['image'];
} else {
    $avatar = "../images/dynamic/playersImages/defaultAvatar.jpg";
}

$out .="<div style='width:30%;float:left; margin-right:10px;' id='playerPictureUpload'>";
$out .="<div style='width:120px;'>";
$out .="<h2>Imatge</h2>";
$out .="<img class='playerCardEditImage pointer'  width=120  src='$avatar'><br />$avatr";
$out .="<span onClick='imageCapture(" . $row['id'] . "," . $_GET['idTeam'] . ");' class='pointer'><img src='images/webcam--plus.png'></span> | ";
$out .="<span onClick='imageUploader(" . $row['id'] . "," . $_GET['idTeam'] . ");' class='pointer'><img src='images/disk--plus.png'> </span> |";
$out .="<span onClick='imageCropFromTeamPicture(" . $row['id'] . "," . $_GET['idTeam'] . ");' class='pointer'><img src='images/scissors-blue.png'> </span><br />";


$out .="</div>";

$insuranceSQL = "select id,scan from player_insurance where idPlayer=" . $_GET['idPlayer'] . " and (expirationDate>now() or expirationDate is null) and scan is not null  order by id desc limit 0,1";
//$out .= $insuranceSQL;
$insuranceRes = mysql_query($insuranceSQL) or die(mysql_error());
$insuranceRow = mysql_fetch_array($insuranceRes);

$insurance = mysql_num_rows($insuranceRes);


$out .="</div>";
$out .="<div style='width:65%; float:left;'>";
if ($row['birthdate']) {
    $b = explode("-", $row['birthdate']);
    $birthdate = $b[2] . "-" . $b[1] . "-" . $b[0];
}
$out .="<form class='jqtransform'>";
//$out .="<input type='text' class='playerCardEditInput' id='playerBirthDate' value='" . $birthdate . "'><label for='playerName'>Data de naixement dd-mm-aaaa</label><div style='clear:both'></div>";
$out .="<input type='text' style='width:45px; margin-right:11px;' class='playerCardEditInput' id='playerBirthDateDD' value='" . $b[2] . "'>";
$out .="<input type='text' style='width:45px; margin-right:11px;' class='playerCardEditInput' id='playerBirthDateMM' value='" . $b[1] . "'>";
$out .="<input type='text' style='width:45px;'  class='playerCardEditInput' id='playerBirthDateYY' value='" . $b[0] . "'><label for='playerName'>Data de naixement dd-mm-aaaa</label><div style='clear:both'></div>";
$out .="<input type='text' class='playerCardEditInput' id='playerDNI' value='" . $row['DNI'] . "' style='width:140px; float:left;margin-right:1px;'>&nbsp; <input type='text' class='playerCardEditInput' id='playerNIF' value='" . $row['NIF'] . "' style='width:30px;'><label for='playerDNI'>DNI <span>*</span></label><br />";



$out .="<input type='text' class='playerCardEditInput' id='playerAddress' value='" . $row['Address'] . "'><label for='playerAddress' style='clear:both;'>Carrer <span>*</span></label><br />";
$out .="<input style='width:45px; margin-right:11px;  ' type='text' class='playerCardEditInput' id='playerAddressNumber' value='" . $row['AddressNumber'] . "'>";
$out .="<input style='width:45px;margin-right:11px;  ' type='text' class='playerCardEditInput' id='playerAddressFloor' value='" . $row['AddressFloor'] . "'>";
$out .="<input style='width:45px; ' type='text' class='playerCardEditInput' id='playerAddressDoor' value='" . $row['AddressDoor'] . "'><label for='playerAddressDoor'  style='clear:both;'>Numero/Pis /Porta</label><div style='clear:both'></div>";
$out .="<input type='text' class='playerCardEditInput' id='playerAddressCity' value='" . $row['AddressCity'] . "'><label for='playerAddressCity'>Ciutat <span>*</span></label><div style='clear:both'></div>";
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
    $sql3 = "select id,position from playerPositions";
    $res3 = mysql_query($sql3) or die(mysql_error());
    $maxPositions = mysql_num_rows($res3);
    while ($row3 = mysql_fetch_array($res3)) {
        $selected = "";
        if ($row3['id'] == $row2['position']) {
            $selected = " selected";
        }
        $out .="<option $selected value='" . $row3['id'] . "' $selected>" . $row3['position'] . " " . $row3['ida'] . " " . $row2['posiation'] . "</option>";
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
$out .="</div>";

echo utf8_encode($out);
?>
</div>