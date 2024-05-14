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

        ?>
    </h1>
</div>

<div id="rounds">
    <?
        $data = $competition->getRoundsByIdLeague();
        foreach ($data as $round) {
            $selected = "";
            if ($selectedRoundNum == $round[0]) {
                $selected = "selected";
            }
            if(strlen($round[1])==1){
                $roundName="0".$round[1];
            }else{
                $roundName=$round[1];
            }
            echo "<div class='cupRound $selected'> <a href='" . $serverUrl . "copa/" . $id . "-" . str_replace(" ", "-", treuAccents($competition->getLeagueName())) . "/" . $round[0] . "-" . treuAccents($round[1]) . "'>" . $roundName . "</a></div>";
        }
        echo "<div style='clear:both;'></div>";
    ?>
    </div>
    <div class="newContainer">
    <?
        $data = $competition->getResultsByLeagueAndRound();


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

            $dateTime = $match[9];
            $d = explode(" ", $dateTime);
            $date = $d[0];
            $hour = $d[1];

            if ($dateMatch != $date) {
                echo "<div class='cupMatchDate'> " . dateformatCup($date) . "</div>";
            }
            echo "<div class='cupMatch'> ";

            //hi ha cronica?
            if (!empty($match[10])) {
                echo "<div class='cupMatchOptions'>Veure cronica >></div>";
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
            } else if(!empty($match[18])) {
                echo "<div class='cupMatchVisitorImage'> <img src='http://www.futsal.cat/webImages/clubsImages/" . $match[21] . "' width=20/><br /><br /><img src='http://www.futsal.cat/webImages/clubsImages/" . $match[22] . "' width=20/></div>";
                echo "<div class='cupMatchVisitor'>" . $match[17] . " / " . $match[18] . "</div>";
            }else{
                echo "<div class='cupMatchVisitorImage'> <img src='http://www.futsal.cat/webImages/clubsImages/genericClub.png' width=40/></div>";
                echo "<div class='cupMatchVisitor'>Guanyador partit " . $match[24] . "</div>";

            }
            echo "<div style='clear:both;'></div>";
            echo "<div class='cupMatchStadium'>" . $match[13] . ", " . $match[14] . " <br />Codi partit:".$match[4]."</div>";

            echo "</div></div>";
            $dateMatch = $date;
        }
//print_r($data);
    ?>

</div>
