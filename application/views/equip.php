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
                <img src="<?php echo $teamImage; ?>" />
            </div>
            <div class="clubTitle">
                <h1><?php echo $name; ?></h1><br /><span class='clubCode'><?php
                    if ($playingDay) {
                       // echo "Juga " . $dies[$playingDay] . " a les $playingHour h a <a target=_blank href='http://maps.google.com/?q=" . urlencode($complexAddress) . "'>" . $complexName . "</a>";
                    }
                    ?></span>
            </div>
        </div>
        <!-- <div class="row" style='margin-top:40px;'>
        <?php
        echo "<img style='-webkit-filter: grayscale(50%);    filter: grayscale(50%);' src='https://www.futsal.cat/images/dynamic/teamsImages/" . $get_team_image['image'] . "'/>";
        ?>
         </div>-->
        <div class="row">
            <div style='clear:both;margin-top:55px;'></div>
            <div  class="large-6 medium-12 columns">
                <h2>&Uacute;ltims resultats</h2>
                <table id='simpleTable'>
                    <thead>
                        <tr>
                            <th>Jor</th>
                            <th>Local</th>
                            <th>Resultat</th>
                            <th>Visitant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($get_last_results_by_idTeam_and_idSeason as $row):
                            echo "\n\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t";
                            echo "<td>" . $row->roundName . "</td>\n\t\t\t\t\t\t\t";
                            echo "<td><a href='" . base_url() . "clubs/equip/" . $row->idLocal . "-" . teamUrlFormat($row->localName) . "'>" . $row->localName . "\n\t\t</td>\n\t\t\t\t\t\t\t";
                            echo "<td class='text-center'><a href='" . base_url() . "competicio/acta/".$row->idMatch."'>" . $row->localResult . " - " . $row->visitorResult . "</a></td>\n\t\t\t\t\t\t\t";
                            echo "<td><a href='" . base_url() . "clubs/equip/" . $row->idVisitor . "-" . teamUrlFormat($row->visitorName) . "'>" . $row->visitorName . "\n\t\t</td>\n\t\t\t\t\t\t\t";
                            echo "</tr>";
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
            <div  class="large-6 medium-12 columns">
                <h2>Propers partits</h2>
                <table id='simpleTable'>
                    <thead>
                        <tr>
                            <th>Jor</th>
                            <th>Data</th>
                            <th>Local</th>
                              <th>Visitant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($get_next_matches_by_idTeam_and_idSeason as $row):
                            echo "\n\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t";
                            echo "<td>" . $row->roundName . "</td>\n\t\t\t\t\t\t\t";
                            echo "<td class='text-center'><a href='" . base_url() . "competicio/acta/".$row->idMatch."'>" . invertdateformatshort($row->updateddatetime) . "</a></td>\n\t\t\t\t\t\t\t";
                            
                            echo "<td><a href='" . base_url() . "clubs/equip/" . $row->idLocal . "-" . teamUrlFormat($row->localName) . "'>" . $row->localName . "\n\t\t</td>\n\t\t\t\t\t\t\t";
                            echo "<td><a href='" . base_url() . "clubs/equip/" . $row->idVisitor . "-" . teamUrlFormat($row->visitorName) . "'>" . $row->visitorName . "\n\t\t</td>\n\t\t\t\t\t\t\t";
                            echo "</tr>";
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
            <div  class="large-12 medium-12 columns"><h2>Plantilla</h2>
                <table id='simpleTable'>
                    <thead>
                        <tr>
                            <th style='width:60px;'>&nbsp;</th>
                            <th data-sort='string'>Nom</th>
                            <th data-sort='string'>Posició</th>
                            <th data-sort='int'>Edat</th>
                            <th data-sort='int'>PJ</th>
                            <th data-sort='int'>G</th>                    
                            <th data-sort='int'>TG</th>
                            <th data-sort='int'>TB</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($get_players_by_idTeam_and_idSeason as $row):
                            $p = explode(" ", $row->name);
                             if (!strstr( strtoupper($row->name),'DE')) {
                                //echo "<br />Nom ".strtoupper($row->name);
                                $playername = $p[0] . " " . $p[1] . " " . $p[2];
                            }else{
                               // echo "<br />No nom ".strtoupper($row->name);
                                $playername=$row->name;
                            }
                            if (!$row->goals) {
                                $row->goals = 0;
                            }
                            if (!$row->yellow) {
                                $row->yellow = 0;
                            }
                            if (!$row->blue) {
                                $row->blue = 0;
                            }
                            if ($row->playOffImage) {
                                $image = $row->playOffImage;
                            } else if ($row->image) {
                                $image = "https://www.futsal.cat/images/dynamic/playersImages/" . $row->image;
                            }
                           

                            echo "\n\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<td><img  style='-webkit-filter: grayscale(10%); /* Safari 6.0 - 9.0 */    filter: grayscale(10%);'  src='$image'></td>\n\t\t\t\t\t\t\t";
                            echo "<td><a href='" . base_url() . "jugador/" . $row->id . "-" . teamUrlFormat($playername) . "'>" . $playername . "\n\t\t</td>\n\t\t\t\t\t\t\t";
                            echo "<td>" . $row->position . "</td>\n\t\t\t\t\t\t\t";
                            echo "<td>" . calculaedad($row->birthdate) . "</td>\n\t\t\t\t\t\t\t";
                            echo "<td>" . $row->played . "</td>\n\t\t\t\t\t\t\t";
                            echo "<td>" . $row->goals . "</td>\n\t\t\t\t\t\t\t";
                            echo "<td>" . $row->yellow . "</td>\n\t\t\t\t\t\t\t";
                            echo "<td>" . $row->blue . "</td>\n\t\t\t\t\t\t";


                            echo "</tr>";
                        endforeach;
                        ?>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

