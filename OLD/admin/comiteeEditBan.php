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

$sql2 = "
  select pbr.id,p.id as idPlayer,p.name,rounds,money, t.id as teamId,t.name as teamName,comment from player_bans_round pbr join players p on pbr.idplayer=p.id join player_team_season pts on p.id=pts.idplayer join teams t on pts.idteam=t.id where pbr.id=" . $_GET['id'] . " order by t.id";
$res2=mysql_query($sql2);
$row2=mysql_fetch_array($res2);


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
    if($row2['idPlayer']==$rowP['id']){
        $selected="selected";
    }else{
        $selected="";
    }
    $out .="<option value=\"" . $rowP['id'] . "\" $selected>" . $rowP['name'] . "</option>";
    $idTeam = $rowP['idTeam'];
}
$out .="</select><br /> ";
$out .="<input type=\"text\" id=\"comiteeNewBanNumberOfMatches\" class='resultInput' value=\"".$row2['rounds']."\"/> número de partits<br />";
$out .="<input type=\"text\" id=\"comiteeNewBanMoney\" class='resultInput' value=\"".$row2['money']."\"/> euros de sanció ";
$out .="<textarea  id=\"comiteeNewBanComment\" rows=10>".$row2['comment']."</textarea>  ";
$out .="<input type='button' class=\"playerNameEditButton\" onClick=\"comiteeEditBanSave(".$_GET['id'].",". $_GET['idRound'] . ",'" . $_GET['date'] . "')\" value=\"Guardar\">";



$out .="</div>";
$out .="</div>";
$out .="<div class='contentBoxSpacer'></div>";
$out .="<div><span class='pointer' onClick=\"comiteeShowInfo('" . $_GET['date'] . "')\"><img src='images/control-rewind.gif'></span></div>";
echo utf8_encode($out);
?>