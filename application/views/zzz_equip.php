<div class="row" id="content" style='padding:12px;'>
    <div  class="large-12 medium-12 columns">
        <div class="row">
            <?php
            /*
              echo "<pre>";
              print_r(get_defined_vars());
              echo "</pre>"; */
            $this->load->helper('functions_helper'); 
            $dies = array(null, "Dilluns", "Dimarts", "Dimecres", "Dijous", "Divendres", "Dissabte", "Diumenge");
            ?>
            <div class="clubLogo">
                <img src="http://historic.futsal.cat/webImages/clubsImages/<? echo $image; ?>" />
            </div>
            <div class="clubTitle">
                <h1><? echo $name; ?></h1><br /><span class='clubCode'><?php
                    if ($playingDay) {
                        echo "Juga " . $dies[$playingDay] . " a les $playingHour h a <a target=_blank href='http://maps.google.com/?q=" . urlencode($complexAddress) . "'>" . $complexName . "</a>";
                    }
                    ?>.</span>
            </div>
        </div>
        <div class="row" style='margin-top:40px;'>
            <?php
            echo "<img style='-webkit-filter: grayscale(50%);    filter: grayscale(50%);' src='http://historic.futsal.cat/images/dynamic/teamsImages/" . $get_team_image['image'] . "'/>";
            ?>
        </div>
        <div class="row">
            <div style='clear:both;margin-top:55px;'></div>
            <div  class="large-12 medium-12 columns"><h2>Plantilla</h2>

                <?php
                foreach ($get_players_by_idTeam_and_idSeason as $row):
                    $p = explode(" ", $row->name);
                    $playername = $p[0] . " " . $p[1] . " " . $p[2];
                    echo "\n\t\t<div style='width:200px; height:300px; overflow:hidden; float:left; margin-right:15px; margin-bottom:40px; '>\n\t\t\t<h3 align=center style='font-size:18px; font-weight:bold; padding:0px; margin;0px; display:inline; '>" . $playername . "</h3><br />";
                    echo "\n\t\t\t<span  style='font-size:16px;'>" . $row->position . "</span>";
                    echo "\n\t\t\t<img style='-webkit-filter: grayscale(80%); /* Safari 6.0 - 9.0 */    filter: grayscale(80%);' width=200 src='http://historic.futsal.cat/images/dynamic/playersImages/" . $row->image . "'>\n\t\t</div>";
                endforeach;
                ?>
            </div>
        </div>
        <div class="row">

            <div  class="large-6 medium-6 columns"><h2>Tarjetes</h2>
                <table>
                    <thead><tr><th>Jugador</th><th>Grogues</th><th>Blaves</th></tr></thead>
                    <tbody>
                        <?php
                        foreach ($get_players_by_idTeam_and_idSeason as $row):
                            if ($row->yellow or $row->blue) {
                                echo "\n\t<tr>\n\t\t<td>\n\t\t\t<a href='" . base_url() . "/jugador/" . $row->id . "-" . teamUrlFormat($row->name) . "'>" . $row->name . "\n\t\t</td>\n\t\t<td align>" . $row->yellow . "</td>\n\t\t<td>" . $row->blue . "</td>\n\t</tr>";
                            }

                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
            <div  class="large-6 medium-6 columns"><h2>Golejadors</h2>
                <table>
                    <thead><tr><th>Jugador</th><th>Gols</th></tr></thead>
                    <tbody>
                        <?php
                       foreach ($get_scorers_by_idTeam_and_idSeason as $row):
                        echo "\n\t<tr>\n\t\t<td>\n\t\t\t<a href='".base_url()."/jugador/".$row->id."-".teamUrlFormat($row->name)."'>".$row->name."\n\t\t</td>\n\t\t<td>".$row->goals."</td>\n\t</tr>";

                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
