<?
$url = explode("-", $_GET['idClub']);
$id = $url[0];
include("Classes/Teams_class.php");
$clubs = new Teams;
$clubs->idClub = $id;
$data = $clubs->clubGetById();
?><div class="newHeader">
    <h1 id="sectionTitle"><span style='color:#600;'>></span> <? echo $data[1]; ?>

    </h1></div>


<div class="Container">
    <h3>Dades del club</h3><div class="clubDataContainer">

        <div style="width:160px; float:left; border-right:1px dotted #242424;">
            <?
            if ($data[3]) {
                echo "<img src=\"" . $serverUrl . "webImages/clubsImages/$data[3]\" width=150>";
            } else {
                echo "<img src=\"" . $serverUrl . "webImages/clubsImages/genericClub.png\" width=150>";
            }
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
                echo "<strong>email</strong><br />" . $data[8] . "<br /><br />";
            }
             if ($data[9]) {
                 
                echo "<strong>Facebook</strong><br /><a href='$data[9]' target=_blank>" . $data[9] . "</a><br /><br />";
            }
            if ($data[10]) {
                echo "<strong>Twitter</strong><br /><a href='https://twitter.com/$data[10]' target=_blank>" . $data[10] . "</a><br />";
            }

            ?>
        </div>
        <div style="clear:both;"></div>
    </div>
    <p>
        <? echo nl2br($data[2]); ?></p><p></p>


    <?
           /* if (!empty($data[4])) {

                $xml = simplexml_load_file("http://maps.google.com/maps/geo?q=" . $data[4] . "&output=xml&sensor=false&key=ABQIAAAADKIrSO8QhdePb69IgQyNhRTAhSjkIBiGptVx9X9HprP3Oe5yPBS9Rp5ikn1ivqG2JoW8Gnyd-1jQAw");

                $coor = $xml->Response->Placemark->Point->coordinates;
                print_r($coor);
                //echo $coor;
                $c = explode(",", $coor);

                $map = "<div align=center style=''><div  id=\"map_canvas" . $data[0] . "\" style=\"width: 565px; height: 300px; margin-bottom:10px;padding:3px; border:1px solid #ddd;\"></div></div>";
                $map .= "\n\n<script src=\"http://maps.google.com/maps?file=api&v=2&key=ABQIAAAADKIrSO8QhdePb69IgQyNhRTAhSjkIBiGptVx9X9HprP3Oe5yPBS9Rp5ikn1ivqG2JoW8Gnyd-1jQAw&sensor=false\"
        type=\"text/javascript\"></script>
		\n<script type='text/javascript'>
		\t var map" . $data[0] . " = new GMap2(document.getElementById(\"map_canvas" . $data[0] . "\"));

		\t var point" . $data[0] . " = new GLatLng(" . $c[1] . "," . $c[0] . ");
		\t map" . $data[0] . ".addOverlay(new GMarker(point" . $data[0] . "));

		\t var mapControl" . $data[0] . " = new GMapTypeControl();
		\t map" . $data[0] . ".addControl(mapControl" . $data[0] . ");
		\t map" . $data[0] . ".addControl(new GLargeMapControl());

		\t map" . $data[0] . ".setCenter(new GLatLng(" . $c[1] . "," . $c[0] . "), 17);

		\n</script>\n\n";
                if (!preg_match('/Warning/',$coor)){echo $map;}
            } */
    ?>
            <h3>Equips de <? echo $data[1]; ?></h3>
    <?
            $n = 1;
            echo "<div class='clubsListName titleList' style='font-size:16px;'>Equip</a></div>";
            echo "<div class='clubsListCity titleList' style='font-size:16px;'>Competicions </div>";
            echo "<div class='clubsListInfo zebra$n'>&nbsp;</div>";
            $data = $clubs->TeamsGetByClubId();

            foreach ($data as $team) {
                if ($n == 1) {
                    $n = 2;
                } else {
                    $n = 1;
                }
                echo "<div class='teamsListName zebra$n'><a href='" . $serverUrl . "equip/" . $team[0] . "-" . teamUrlFormat($team[1]) . "'> $team[1]</a></div>";
                echo "<div class='teamsListDivision zebra$n'>";
                $clubs->idTeam = $team[0];
                $cData = $clubs->CompetitionsGetByTeamIdAndCurrentSeason();
                $a = 0;
                if (count($cData) > 0) {
                    foreach ($cData as $competition) {
                        if ($a >= 1) {
                            echo ", ";
                        }
                        echo "<a href='" . $serverUrl . "divisio/" . $competition[0] . "-" . str_replace(" ", "-", treuAccents($competition[1])) . "'> $competition[2]";
                        $a++;
                    }
                } else {
                    echo "No juga aquest any";
                }

                echo "</div>";
            }
            echo "<div style='clear:both; height:30px;'></div>";
            $web = "http://www.futsal.cat" . $_SERVER['REQUEST_URI'];
            echo "<div style='padding:5px;'><a href=\"http://twitter.com/share\" class=\"twitter-share-button\" data-count=\"horizontal\" data-via=\"futsalcat\" data-lang=\"es\">Tweet</a><script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script></div>";
            echo "<div style='padding:5px;'><iframe src=\"http://www.facebook.com/plugins/like.php?href=" . urlencode($web) . "&amp;layout=standard&amp;show_faces=true&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=100\" scrolling=\"no\" frameborder=\"0\" style=\"border:none; overflow:hidden; width:450px; height:100px;\" allowTransparency=\"true\"></iframe></div>";
    ?>

</div>



