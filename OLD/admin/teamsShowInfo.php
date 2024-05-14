<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

//Nom equip
$res = mysql_query("select name,id from teams where id=" . $_GET['idTeam']) or die(mysql_error());
$row = mysql_fetch_array($res);
$out .= "<h1>" . $row['name'] . "</h1>";


//Jugadors
$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Plantilla</h2></div>";
$out .="<div class='contentBoxContent'>";
$out .="<table class='playersTable' cellspacing=0><tr><th width=90%>Jugador</th><th width=10%>Accio</th></tr>";
$res = mysql_query("select p.id,p.name,number from players p join player_team_season pts on pts.idplayer=p.id where idTeam=" . $_GET['idTeam'] . " and pts.idseason=3") or die(mysql_error());

while ($row = mysql_fetch_array($res)) {
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    $out .="<tr><td class='zebra$n' >" . $row['name'] . "</td><td class='zebra$n' ><img src='images/pencil.png' class='pointer' onClick='teamsEditPlayerName(" . $row['id'] . ");' > &nbsp; <img class='pointer' src='images/cross.png' onClick='teamsDeletePlayerConfirm(" . $row['id'] . ",\"" . $row['name'] . "\");'></td></tr>";
    $out .="<tr id='playerNameEditContainer_" . $row['id'] . "' class='playerNameEditContainer'><td class='zebra_b$n'  colspan=6  ><input type='hidden' id='playerPreviousNameEditInput_" . $row['id'] . "' value='" . $row['name'] . "'><input type='text'  id='playerNameEditInput_" . $row['id'] . "' class='playerNameEditInput' value='" . $row['name'] . "'> <input type='button' class='playerNameEditButton' value='Actualitzar' onClick='teamsUpdatePlayerNameConfirm(" . $row['id'] . ")'></td></tr>";


}
$out .= "</table>";
$out .="</div>";
$out .="</div>";
$out .="<div class='contentBoxSpacer'></div>";
$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Nou jugador</h2></div>";
$out .="<div class='contentBoxContent'>";
$out .="<input type='text' class='newPlayerNameInput' id='newPlayerName'>&nbsp;<input type='button' onClick='teamsInsertPlayer(" . $_GET['idTeam'] . ");' class='newPlayerNameButton' value='Guardar' />";
$out .="</div>";
$out .="</div>";

echo utf8_encode($out);
?>
