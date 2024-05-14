<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

//Nom equip
$res = mysql_query("select * from clubs where id=" . $_GET['idClub']) or die(mysql_error());
$row = mysql_fetch_array($res);
$out .= "<h1>" . $row['name'] . "</h1>";
$res2 = mysql_query("select id,name from teams where idClub=" . $_GET['idClub']." order by name asc");

$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Equips</h2></div>";
$out .="<div class='contentBoxContent'>  <table width='100%' cellspacing=0 class='playersTable'><tr><th>Equip</th></tr>";
while ($row2 = mysql_fetch_array($res2)) {
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    $out .="<tr><td class='zebra$n'><span id='teamName_".$row2['id']."' onClick='teamNameSwitch(".$row2['id'].")'>".ucwords(strtolower($row2['name'])). "</span><input onBlur='teamInputSwitch(".$row2['id'].")' class='newPlayerNameInput' style='width:220px;display:none;' id='teamInput_".$row2['id']."' value='".ucwords(strtolower($row2['name'])) . "' onKeyUp='teamNameUpdate(".$row2['id'].")'></td></tr>";
}
$out .="</table>";
$out .="</div>";
$out .="</div>";

$res2 = mysql_query("select id, email, password from usersAccounts where idClub=" . $_GET['idClub']);

$email = $row2['email'];

$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Crear compte gestió</h2></div>";
$out .="<div class='contentBoxContent'><table width='100%' cellspacing=0 class='playersTable'><tr><th>ID</th><th>Email</th><th>Password</th><th>Accions</th></tr>";
while ($row2 = mysql_fetch_array($res2)) {
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    $out .="<tr><td class='zebra$n'>" . $row2['id'] . "</td><td class='zebra$n'>" . $row2['email'] . "</td><td class='zebra$n'>" . $row2['password'] . "</td><td class='zebra$n' onClick='clubDeleteUserAccount(" . $row2['id'] . "," . $_GET['idClub'] . ");'>Esborrar</td></tr>";
}
$out .="</table><input type='text' class='newPlayerNameInput' id='newUserAccount' value='$email'>&nbsp;<input type='button' onClick='clubNewUserAccount(" . $_GET['idClub'] . ");' class='newPlayerNameButton' value='Guardar' />";
$out .="</div>";
$out .="</div><br />";
$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Escut</h2></div>";
$out .="<div class='contentBoxContent'>  <table width='100%' cellspacing=0 class='playersTable'><tr><th>Escut</th><th>Accions</th></tr>";

$out .="</table><form action=\"avatarUpload.php?idClub=" . $_GET['idClub'] . "\" method=\"post\" enctype=\"multipart/form-data\"> <input name=\"userfile\" type=\"file\">&nbsp;<input type='submit' name='submit' value='Guardar' /></form>";
$out .="</div>";
$out .="</div>";


echo utf8_encode($out);
?>