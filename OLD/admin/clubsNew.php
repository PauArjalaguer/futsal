<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<? $out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Crear compte gestió</h2></div>";
$out .="<div class='contentBoxContent'>";
$out .="<table width='100%' cellspacing=0 class='playersTable'>";
$out .="<tr><th>Nom del club</th><th>Email</th><th>Ciutat</th><th>Web</th><th>Accions</th></tr>";

$out .="<tr>";
$out .="<td><input type='text' style='width:120px;' class='newPlayerNameInput' id='newClubNameInput' value='$email'></td>";
$out .="<td><input type='text' style='width:120px;' class='newPlayerNameInput' id='newClubEmailInput' value='$email'></td>";
$out .="<td><input type='text' style='width:120px;' class='newPlayerNameInput' id='newClubCityInput' value='$email'></td>";
$out .="<td><input type='text' style='width:120px;' class='newPlayerNameInput' id='newClubWebInput' value='$email'></td>";
$out .="<td><input type='button' onClick='clubsNewSave();' class='newPlayerNameButton' value='Guardar' />";
$out .="</table></div>";
$out .="</div><br />";

echo utf8_encode($out);
?>
