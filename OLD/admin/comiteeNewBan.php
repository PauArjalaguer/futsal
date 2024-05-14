<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?

//Connexió
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$out = "<h1>Jornada " . invertdateformat($_GET['date']) . " </h1>";
$out .="<div class='contentBox'>";
$out .="<div class='contentBoxHeader'><h2>Nova sancio</h2></div>";
$out .="<div class='contentBoxContent'>";
$out .="<select id='comiteeNewBanPlayerSelect'><option disabled>Selecciona un jugador</option>";
/* $sql = "
  select
  p.id
  ,p.name
  ,t.id as idTeam
  ,t.name as teamName
  from players p
  join player_team_season pts on pts.idplayer=p.id join teams t on pts.idteam=t.id join matches m on m.idLocal=t.id or m.idVisitor=t.id where m.idround=" . $_GET['idRound'] . " order by t.id";

 */


$sql = " select p.id ,p.name ,t1.id as idTeam ,t1.name as teamName from players p
join matches_players mp on mp.idplayer=p.id
join matches m on m.id=mp.idmatch
join teams t1 on t1.id=mp.idteam

where m.idround=" . $_GET['idRound'] . " order by t1.id, p.name asc";
//echo $sql;

$resP = mysql_query($sql);

$idTeam = "";
while ($rowP = mysql_fetch_array($resP)) {
    if ($rowP['idTeam'] != $idTeam) {
        $out .="<optgroup label=\"" . $rowP['teamName'] . "\">";
    }
    $out .="<option value=\"" . $rowP['id'] . "\">" . $rowP['name'] . "</option>";
    $idTeam = $rowP['idTeam'];
}
$out .="</select><br /> ";
$out .="<input type=\"text\" id=\"comiteeNewBanNumberOfMatches\" class='resultInput' /> número de partits<br />";
$out .="<input type=\"text\" id=\"comiteeNewBanMoney\" class='resultInput' /> euros de sanció ";
$out .="<textarea  id=\"comiteeNewBanComment\" rows=10></textarea>  ";
$out .="<input type='button' class=\"playerNameEditButton\" onClick=\"comiteeNewBanSave(" . $_GET['idRound'] . ",'" . $_GET['date'] . "')\" value=\"Guardar\">";



$out .="</div>";
$out .="</div>";
$out .="<div class='contentBoxSpacer'></div>";
$out .="<div><span class='pointer' onClick=\"comiteeShowInfo('" . $_GET['date'] . "')\"><img src='images/control-rewind.gif'></span></div>";
echo utf8_encode($out);
?>