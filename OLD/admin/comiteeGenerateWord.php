<?php

$date = $_GET['date'];
$d = str_replace("-", "", $date);

Header("Content-type: application/vnd.ms-word");
Header("Content-Disposition: filename=ActaComite$d.doc");
$fp = fopen("../Actes/ActaComite$d.doc", "w");

/* require_once '../includes/PHPWord.php';

  // Create a new PHPWord Object
  $PHPWord = new PHPWord();

  // Every element you want to append to the word document is placed in a section. So you need a section:
  $section = $PHPWord->createSection();


  $PHPWord->addFontStyle('text', array('name' => 'Tahoma', 'size' => 10, 'color' => '242424'));
  $PHPWord->addFontStyle('match', array('name' => 'Tahoma', 'size' => 10, 'color' => '242424', 'bold' => true));
  $PHPWord->addFontStyle('league', array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true, 'underline' => PHPWord_Style_Font::UNDERLINE_SINGLE));

  // At least write the document to webspace:
 */
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$out = "";
$date = $_GET['date'];
//$res = mysql_query("Select l.name from rounds r join leagues l on r.idleague=l.id join matches m on m.idround=r.id where initialdate='2010-10-23' or enddate='2010-10-23'") or die(mysql_error());
$sql = "select m.id as matchId, t2.name as localName, t3.name as visitorName,l.id as idLeague, l.name as leagueName, m.id as idMatch, p.name as playerName,yellowcards,bluecards, t1.id as idTeam,t1.name as teamName,r.id as idRound from player_card_match pcm ";
$sql .="join players p on p.id=pcm.idplayer ";
$sql .="join matches m on pcm.idmatch=m.id ";
$sql .="join rounds r on r.id=m.idround ";
$sql .="join player_team_season pts on pts.idplayer=pcm.idplayer and pts.idseason=r.idSeason ";
$sql .="join teams t1 on t1.id=pts.idteam ";
$sql .="join teams t2 on t2.id=m.idlocal ";
$sql .="join teams t3 on t3.id=m.idvisitor ";
$sql .="join leagues l on l.id=r.idleague ";
$sql .="where (initialdate='$date' or enddate='$date') and (yellowcards>0 or bluecards>0) ";
$sql .="order by idchampionship, r.idleague, idround, idmatch, idTeam";

//echo $sql . "<br /><br />";
$res = mysql_query($sql);
$idLeague = "";
$idMatch = "";
while ($row = mysql_fetch_array($res)) {
    if ($row['idLeague'] != $idLeague) {
        $out .= "<h1>" . $row['leagueName'] . "</h1>";
        //$section->addText(strtoupper($row['leagueName']), 'league');
    }
    if ($row['idMatch'] != $idMatch) {
        $match = $row['localName'] . "-" . $row['visitorName'];
        //$section->addText($match, 'match');
        $out .= "<h2>" . $row['localName'] . " - " . $row['visitorName'] . "</h2>";
    }

    if ($row['idRound'] != $idRound) {
        $ban = "";
        $sqlB = "select p.name,rounds,money, t.id as teamId,t.name as teamName,comment from player_bans_round pbr join players p on pbr.idplayer=p.id join player_team_season pts on p.id=pts.idplayer join teams t on pts.idteam=t.id where pbr.idround=" . $row['idRound'] . " order by t.id";
        $resB = mysql_query($sqlB) or die(mysql_error());
        while ($rowB = mysql_fetch_array($resB)) {
            $ban .="<br />&bull; El jugador <strong>" . $rowB['name'] . "</strong> del <strong>" . $rowB['teamName'] . "</strong> ha estat sancionat amb " . $rowB['rounds'] . " partits de sanció";
            if (!empty($rowB['money'])) {
                $ban .=" i " . $rowB['money'] . " euros";
            }

            $ban .=" per " . $rowB['comment'] . ". Aquesta sanció li impedeix jugar els partits següents:<br />";

            $sqlM = "SELECT t1.name as localName, t2.name as visitorName, r.name as roundName, l.name as leagueName
FROM rounds r
join leagues l on r.idleague=l.id
JOIN matches m ON r.id = m.idround
JOIN teams t1 ON t1.id = m.idLocal
JOIN teams t2 ON t2.id = m.idvisitor
WHERE initialdate >  '" . $_GET['date'] . "'
and (idLocal=" . $rowB['teamId'] . " or idVisitor=" . $rowB['teamId'] . ")
AND idLeague =" . $row['idLeague'] . " ORDER BY r.name Limit 0," . $rowB['rounds'];
           echo $sqlM . "<br /><br />";
            $resM = mysql_query($sqlM) or die(mysql_error());
            while ($rowM = mysql_fetch_array($resM)) {
                $ban .="<br /> &nbsp;&nbsp;&nbsp;&deg; " . $rowM['localName'] . " - " . $rowM['visitorName'] . "(Jornada " . $rowM['roundName'] . ") ";
            }//$section->addText($ban, 'text');
        }
    }
    $money = ($row['yellowcards'] * 15) + ($row['bluecards'] * 30);
    $teamMoney = $teamMoney + $money;

    $p .="&nbsp;&nbsp;&nbsp;&deg; ";
    $p.= "<strong>" . $row['playerName'] . "</strong> per ";
    /*if ($row['yellowcards'] > 0) {

        if ($row['yellowcards'] == 1) {
            $p .=$row['yellowcards'] . " tarjeta groga ";
        } else {
            $p .=$row['yellowcards'] . " targetes grogues";
        }
    }*/
    if ($row['yellowcards'] > 0 and $row['bluecards'] > 0) {
       // $p .=" i ";
    }
    if ($row['bluecards'] > 0) {
        if ($row['bluecards'] == 1) {
            $p .=$row['bluecards'] . " tarjeta blava";
        } else {

            $p .=$row['bluecards'] . " targetes blaves";
        }
    }
    $p .="<br/>";


    $t = "&bull; Sancionar al " . $row['teamName'] . " amb $teamMoney euros  per:  ";
    //$section->addText($t, 'text');
    if ($row['idTeam'] != $idTeam) {

        if (!empty($ban)) {
            $out .=$ban . "<br /><br /> ";
        }
        $out .=$t . "<br />";
        $out .=$p . "<br />";
        $t = "";
        $p = "";
        $ban = "";
        $teamMoney = "";
    }

    $idLeague = $row['idLeague'];
    $idMatch = $row['idMatch'];
    $idTeam = $row['idTeam'];
    $idRound = $row['idRound'];
}

$end .="Aquestes sancions poden ser recorregudes davant del Comitè d'Apel·lació de la federació en el termini de tres dies hàbils, a comptar des de l'endemà del dia en què es notifiqui aquesta resolució, tal i com indica l'article 78è del Reglament de Disciplina Esportiva de la Federació Catalana de Futbol Sala.";
//$section->addText($end, 'text');
//$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
//$objWriter->save("../Actes/ActaComite" . $d . ".docx");
echo utf8_encode($out);





fwrite($fp, $out);
fclose($fp);
?>
