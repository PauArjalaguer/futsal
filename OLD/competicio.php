<div class="newHeader">
    <h1 id="sectionTitle"> <span style='color:#600;'>></span>
        <?
        $url = explode("-", $_GET['title']);
        $id = $url[0];

        $r = explode("-", $_GET['round']);
        $selectedRoundNum = $r[0];
        //echo "ROUND:".$selectedRoundNum;

        $competition = new Competition;
        $competition->idLeague = $id;
        echo $data = $competition->getLeagueName();

        $idSeason = $competition->getLeagueSeason();
        $competition->idSeason = $idSeason;

        $roundNumberArray = $competition->getCurrentRound();

        if (empty($selectedRoundNum)) {
            $roundNumber = $roundNumberArray[0];
        } else {
            $roundNumber = $selectedRoundNum;
        }

        $competition->idRound = $roundNumber;
        $roundName = $roundNumberArray[1];
        // print_r($roundNumberArray);


        if (empty($roundNumber)) {
            $roundNumber = $competition->getFirstRoundOfALeague();
            $competition->idRound = $roundNumber[0];
            $selectedRoundNum = $roundNumber[0];
            $roundName = $roundNumber[1];
        }
        //echo "<h1>ROUND: $roundNumber $roundName</h1>";
        ?>
    </h1>
</div>

<div id="rounds">
    <?
    $data = $competition->getRoundsByIdLeague();
    if (empty($data)) {
        $rounds = 0;
    } else {
        $rounds = 1;
    }
    foreach ($data as $round) {
        $selected = "";
        if ($roundNumber == $round[0]) {
            $selected = "selected";
        }
        if (strlen($round[1]) == 1) {
            $roundName = "0" . $round[1];
        } else {
            $roundName = $round[1];
        }
        echo "<div class='cupRound $selected'> <a href='" . $serverUrl . "divisio/" . $id . "-" . str_replace(" ", "-", treuAccents($competition->getLeagueName())) . "/" . $round[0] . "-" . treuAccents($round[1]) . "'>" . $roundName . "</a></div>";
    }
    echo "<div class='cupRound'><a href='http://www.futsal.cat/classPrint.php?idLeague=$id&idRound=$roundNumber'><img class='pointer' src='http://www.futsal.cat/webImages/print.png' /></a></div>";
    echo "<div style='clear:both;'></div>";
    ?>
</div>
<div class="newContainer">
    <?
    if ($rounds == 1) {
        $data = $competition->getResultsByLeagueAndRound();
        //print_r($data);

        foreach ($data as $match) {
            if (empty($match[11])) {
                $match[11] = "genericClub.png";
            }
            if (empty($match[12])) {
                $match[12] = "genericClub.png";
            }
            if (empty($match[19])) {
                $match[19] = "genericClub.png";
            }
            if (empty($match[20])) {
                $match[20] = "genericClub.png";
            }
            if (empty($match[21])) {
                $match[21] = "genericClub.png";
            }
            if (empty($match[22])) {
                $match[22] = "genericClub.png";
            }


            if ($match[27] != $match[28]) {
                $dateTime = $match[26];
            } else {
                $dateTime = $match[9];
            }
            $dateTime = $match[26];
            $d = explode(" ", $dateTime);
            $date = $d[0];
            $hour = $d[1];

            if (strlen($hour) > 5) {
                $hour = substr($hour, 0, 5);
            }


            if ($dateMatch != $date) {
                if ($match[9] != "0000-00-00 00:00:00") {
                    echo "<div class='cupMatchDate'> " . dateformatCup($date) . "</div>";
                } else {
                    echo "<div class='cupMatchDate'> Partits sense data confirmada.</div>";
                }
            }

            echo "<div class='cupMatch'> ";

            //hi ha cronica?
            if (!empty($match[10])) {
                echo "<div class='cupMatchOptions'><a href='http://www.futsal.cat/noticia/" . $match[10] . "' >Veure cronica >></a></div>";
            }
            echo "<div class='cupMatchResult'>";

            //equip assignat local
            if (!empty($match[0])) {
                echo "<div class='cupMatchLocal'><a href='" . $serverUrl . "equip/" . $match[7] . "-" . teamUrlFormat($match[0]) . "'>" . $match[0] . "</a></div>";
                echo "<div class='cupMatchLocalImage'> <img src='http://www.futsal.cat/webImages/clubsImages/" . $match[11] . "' width=40 /></div>";
            } else
            // partit assignat entre guanyadors ronda previa local
            if (!empty($match[15])) {
                echo "<div class='cupMatchLocal'>" . $match[15] . " / " . $match[16] . "</div>";
                echo "<div class='cupMatchLocalImage'> <img src='http://www.futsal.cat/webImages/clubsImages/" . $match[19] . "' width=20 /><br /><br /><img src='http://www.futsal.cat/webImages/clubsImages/" . $match[20] . "' width=20 /></div>";
            } else {
                echo "<div class='cupMatchLocal'>Guanyador partit " . $match[23] . "</div>";
                echo "<div class='cupMatchLocalImage'> <img src='http://www.futsal.cat/webImages/clubsImages/genericClub.png' width=40 /></div>";
            }


            if (isset($match[2])) {
                echo "<div class='cupMatchScore'>" . $match[2] . "&nbsp; - &nbsp; " . $match[3] . "</div>";
            } else {

                echo "<div class='cupMatchScore'>" . $hour . "&nbsp;</div>";
            }


            if (!empty($match[8])) {
                echo "<div class='cupMatchVisitorImage'> <img src='http://www.futsal.cat/webImages/clubsImages/" . $match[12] . "' width=40/></div>";
                echo "<div class='cupMatchVisitor'><a href='" . $serverUrl . "equip/" . $match[8] . "-" . teamUrlFormat($match[1]) . "'>" . $match[1] . "</a></div>";
            } else if (!empty($match[18])) {
                echo "<div class='cupMatchVisitorImage'> <img src='http://www.futsal.cat/webImages/clubsImages/" . $match[21] . "' width=20/><br /><br /><img src='http://www.futsal.cat/webImages/clubsImages/" . $match[22] . "' width=20/></div>";
                echo "<div class='cupMatchVisitor'>" . $match[17] . " / " . $match[18] . "</div>";
            } else {
                echo "<div class='cupMatchVisitorImage'> <img src='http://www.futsal.cat/webImages/clubsImages/genericClub.png' width=40/></div>";
                echo "<div class='cupMatchVisitor'>Guanyador partit " . $match[24] . "</div>";
            }
            echo "<div style='clear:both;'></div>";
            echo "<div class='cupMatchStadium'>";
            if ($match[27] != $match[28]) {
                echo "<span style='color:#900; font-weight:bold;'>Partit ajornat, es jugar? el " . dateformatCup($date) . " a les $hour hores.</span><br />";
            }
            echo $match[13] . ", " . $match[14] . " <br />Codi partit:" . $match[4];
            if (isset($match[2])) {
                echo "<div class='cupMatchOptions'><a href='http://www.futsal.cat/acta/" . $match[4] . "' >Veure acta >></a></div>";
            }
            echo "</div>";

            echo "</div></div>";
            $dateMatch = $date;
        }
//print_r($data);
    } else {
        echo "<h1 style='color:#242424;'>LLiga encara no definida";
    }
    ?>
    <div>&nbsp;</div>
    <table id="taulaclassificacio" cellspacing="0" cellpadding="0" width="100%">
        <thead>
            <tr>
                <th colspan="2">Classificaci?</th>
                <th>Punts</th>
                <th>PJ</th><th>PG</th><th>PE</th><th>PP</th><th>GF</th><th>GC</th></tr>
        </thead>
        <tbody>
<?
$data = $competition->getClassificationByLeague();
/* echo "<pre>";
  print_r($data);
  echo "</pre>"; */
$p = 1;
$a = 1;
foreach ($data as $clas) {
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }

    echo "<tr>";
    echo "<td class='clasif zebra$n' style='" . $clas[11] . "'>" . $clas[10] . "</td>";
    echo "<td class='equip zebra$n'><a href='" . $serverUrl . "equip/" . $clas[2] . "-" . teamUrlFormat($clas[0]) . "'>" . $clas[0] . "</a></td>";
    echo "<td class='punts zebra$n' style=\" text-align:center;\">" . $clas[1] . "</td>";
    echo "<td class='td zebra$n' style=\"width:15px;\">" . $clas[3] . "</td>";
    echo "<td class='td zebra$n' style=\"width:15px;\">" . $clas[4] . "</td>";
    echo "<td class='td zebra$n' style=\"width:15px;\">" . $clas[5] . "</td>";
    echo "<td class='td zebra$n' style=\"width:15px;\">" . $clas[6] . "</td>";
    echo "<td class='td zebra$n' style=\"width:15px;\">" . $clas[7] . "</td>";
    echo "<td class='td zebra$n' style=\"width:15px;\">" . $clas[8] . "</td></tr>";
    $p++;
}

$itemsArray = $competition->getClassificationItemsByIdLeague();
echo "\n\t<tr>\n\t\t<td class='td'>&nbsp;</td><td colspan=7 class='td'>";
foreach ($itemsArray as $status) {
    echo "<div style='float:left; margin-right:15px;'>\n\t\t\t<div style='" . $status[2] . "; width:6px; height:6px; padding:3px; border:1px solid #fff; float:left;'>&nbsp;</div>&nbsp;" . $status[0] . "</div>\n\t\t";
}
echo "</td>\n\t</tr>";
?></tbody></table>

    <div>&nbsp;</div>
    <table id="taulajornada" width="100%"  cellspacing=0 cellpadding=0 border="0">

<?
$mScorers = $competition->getMaxScorersByLeague();
$o = 1;
$c = count($mScorers);
if ($c > 0) {
    echo "<thead><tr><th colspan=2>Golejadors</th></tr></thead>";
}

foreach ($mScorers as $scorers) {

    if (empty($scorers[2])) {
        //echo "..." . strlen($scorers[2]) . "....";
        $img = "undefined.jpg";
    } else {
        $img = $scorers[2];
    }
    if ($n == 1) {
        $n = 2;
    } else {
        $n = 1;
    }
    if ($o == 1) {
        $main = "\n\t\t<td rowspan=25 width=150>\n\t\t\t<img src='images/dynamic/playersImages/$img' width=150 height=150><br>";
        $main .= "\n\t\t\t<div style='font-weight:bold; font-size:15px; background-color:#900; width:140px;padding:5px;color:#fff;height:36px;'>$scorers[0]<br /><span style='font-size:10px; color:#ddd;'><a style='color:#ddd;' href='" . $serverUrl . "equip/" . $scorers[3] . "-" . teamUrlFormat($scorers[4]) . "'>" . $scorers[4] . " </a></span></div>";
        $main .= "\n\t\t\t<div style='font-weight:bold; font-size:35px; background-color:#900; width:140px;padding:5px;color:#fff;height:38px; text-align:center;'>$scorers[1] </div>\n\t\t</td>\n\t";
    } else if ($o == 2) {
        echo "\n\t<tr>\n\t\t$main<td  class=\"equip zebra$n\">$scorers[1] " . $scorers[0] . " (<a href='" . $serverUrl . "equip/" . $scorers[3] . "-" . teamUrlFormat($scorers[4]) . "'>" . $scorers[4] . "</a>)\n\t\t</td>\n\t</tr>";
    } else {
        echo "\n\t<tr>\n\t\t<td  class=\"equip zebra$n\">$scorers[1] " . $scorers[0] . " (<a href='" . $serverUrl . "equip/" . $scorers[3] . "-" . teamUrlFormat($scorers[4]) . "'>" . $scorers[4] . "</a>)\n\t\t</td>\n\t</tr>";
    }
    $o++;
}
?>
    </table>

    <div>&nbsp;</div>
</div>
