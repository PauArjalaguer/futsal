<?
$url = explode("-", $_GET['idTeam']);
$id = $url[0];
include("Classes/Teams_class.php");
$clubs = new Teams;
$clubs->idTeam = $id;


$idClub = $clubs->ClubGetByTeamId();
$clubs->idClub = $idClub;
$data = $clubs->clubGetById();
?><div class="newHeader">
    <h1 id="sectionTitle"><span style='color:#600;'>></span> <? echo $data[1]; ?>

    </h1>
</div>

<div class="Container">
    <h3>Dades del club</h3><div class="clubDataContainer">

        <div style="width:160px; float:left; border-right:1px dotted #242424;">
            <?
            echo "<a href=\"" . $serverUrl . "club/$data[0]-" . teamUrlFormat($data[1]) . "\">";
            if ($data[3]) {
                echo "<img src=\"" . $serverUrl . "webImages/clubsImages/$data[3]\" width=150>";
            } else {
                echo "<img src=\"" . $serverUrl . "webImages/clubsImages/genericClub.png\" width=150>";
            }
            echo "</a>";
            ?>

        </div>

        <div style="width:50%; float:left; padding-left:10px;">
            <?
            if ($data[4]) {
                echo "<strong>Adreça de la seu</strong><br />" . $data[4] . "<br /><br />\n";
            }
            if ($data[5]) {
                echo "<strong>Telèfons de contacte</strong><br />" . $data[5] . "<br />";
            }
            if ($data[6]) {
                echo "$data[6]<br />\n";
            }
            echo "<br />";
            if ($data[7]) {
                echo "<strong>Web</strong><br /><a href='$data[7]'>$data[7]</a><br /><br />\n";
            }
            if ($data[8]) {
                echo "<strong>email</strong><br />" . $data[8] . "<br />";
            }
            ?>
        </div>
        <div style="clear:both;"></div>
    </div>
    <p>




        <?
            $n = 1;
            echo "<div class='clubsListName titleList' style='font-size:16px;'>Plantilla</a></div>";
            echo "<div class='clubsListCity titleList' style='font-size:16px;'>&nbsp; </div>";
            echo "<div class='clubsListInfo zebra$n'>&nbsp;</div>";


            $img = $clubs->TeamGetImageById();
            if (!empty($img)) {


                echo "<img src=\"" . $serverUrl . "images/dynamic/teamsImages/$img\" width=575 alt='$data[1]'>";
            }

            $data = $clubs->PlayersGetByTeamIdAndSeasonId();
            $a = 0;
            $n = 1;
            echo "<table cellpadding=4 id=taulajornada width=100%><tr>";
            foreach ($data as $player) {

              //  echo "<td class='td zebra$n' style='width:15px; background-color:#bbb; font-weight:bold; text-align:center; color:#fff;'>$player[2]</td>";
                //echo "<td class='td zebra$n' >";
                //echo "<a href='" . $serverUrl . "jugador/" . $player[0] . "-" . teamUrlFormat($player[1]) . "'>";
                //echo $player[1];
                //echo "</a>";
                //echo "</td>";

                $a++;
                if ($a > 1) {
                    echo "</tr><tr>";
                    $a = 0;
                    if ($n == 1) {
                        $n = 2;
                    } else {
                        $n = 1;
                    }
                }
            }echo "</table>";
            
            
           
            echo "<div style='clear:both;'></div>";
        ?>  <h3>Resultats</h3>
        <table cellpadding="4"  id="taulajornada" width="100%">
        <?
            echo "<tr><td class='td tdTop'>Últims Partits</td><td class='tdTop'>Resultat</td><td class='tdTop'>Data</td><td class='tdTop'>Competició</td></tr>";
            $data = $clubs->LastResultsGetByTeamId();
            foreach ($data as $results) {
                if ($n == 2) {
                    $n = 1;
                } else {
                    $n = 2;
                }
                echo "<tr><td class='td zebra$n'><a href='" . $serverUrl . "equip/" . $results[0] . "-" . teamUrlFormat($results[1]) . "'>$results[1]</a> - <a href='" . $serverUrl . "equip/" . $results[3] . "-" . teamUrlFormat($results[4]) . "'>$results[4]</td><td class='td zebra$n' align=center>$results[2] - $results[5]</td><td class='td zebra$n'>" . invertdateformat($results[6]) . "</td><td class='td zebra$n'><a href='" . $serverUrl . "divisio/" . $results[7] . "-" . str_replace(" ", "-", treuAccents($results[8])) . "'>$results[8]</a></td></tr>";
            }
        ?></table>
    <?
            echo "<div style='clear:both; height:30px;'></div>";
            $web = "http://www.futsal.cat" . $_SERVER['REQUEST_URI'];
            echo "<div style='padding:5px;'><a href=\"http://twitter.com/share\" class=\"twitter-share-button\" data-count=\"horizontal\" data-via=\"futsalcat\" data-lang=\"es\">Tweet</a><script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script></div>";
            echo "<div style='padding:5px;'><iframe src=\"http://www.facebook.com/plugins/like.php?href=" . urlencode($web) . "&amp;layout=standard&amp;show_faces=true&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=100\" scrolling=\"no\" frameborder=\"0\" style=\"border:none; overflow:hidden; width:450px; height:100px;\" allowTransparency=\"true\"></iframe></div>";
    ?>



</div>



