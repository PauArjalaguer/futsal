<div class="row" id="content" style='padding:12px;'><div  class="large-12 medium-12 columns">
        <div class="row">
            <h2><?php
                echo str_replace(">", "", $league_name);
                ?>
            </h2>
            <ul class="tabs" data-tabs id="example-tabs">
                <li class="tabs-title is-active"><a class="tabAactive" href="#resultsTab" >Resultats</a></li>
                <li class="tabs-title"><a href="#classificationTab">Classificaci&oacute;</a></li>
                <!--  <li class="tabs-title"><a href="#bansTab">Sancions</a></li>-->
                <li class="tabs-title"><a href="#scorersTab">Golejadors</a></li>
                <li class="tabs-title "><a  href="#calendarTab">Calendaris </a> </li>

            </ul>
            <div class="tabs-content" data-tabs-content="example-tabs">

                <div class="tabs-panel" id="resultsTab">
                    <select id='competitionLeagueRoundSelect'>
                        <option>Selecciona jornada</option><?php
                        foreach ($rounds_by_idLeague as $row):
                            if ($row->id == $current_round_id) {
                                $s = "selected";
                                $roundNumber = $row->id;
                            } else {
                                $s = "";
                            }
                            echo "\n\t\t\t<option value=\"" . $row->id . "\" $s>Jornada " . $row->name . "</option>";
                        endforeach;
                        ?>
                    </select>
                    <table>
                        <?php
                        foreach ($get_results_by_idLeague_and_idRound as $row):
                            
                                if ($row->teamImage1) {
                                    $localImage = $row->teamImage1;
                                }else{
                                    $localImage = "https://www.futsal.cat/webImages/clubsImages/" . $row->club1Image;
                               
                                }
                                 if ($row->teamImage2) {
                                    $visitorImage = $row->teamImage2;
                                }else{
                                    $visitorImage = "https://www.futsal.cat/webImages/clubsImages/" . $row->club2Image;
                               
                                }
                            echo "\n\t<tr>";
                            echo "\n\t\t<td><a href='" . base_url() . "clubs/equip/" . $row->localId . "-" . teamUrlFormat($row->local) . "'><img src=\"$localImage\" width=60 ></td>";
                            echo "\n\t\t<td align=right><a href='" . base_url() . "clubs/equip/" . $row->localId . "-" . teamUrlFormat($row->local) . "'>" . $row->local . "</a></td>";
                            echo "\n\t\t<td style='background-color:#828282; color:#fff; font-size:20px; font-weight:bold; text-align:center;'>" . $row->localResult . " - " . $row->visitorResult . "</td>";
                            echo "\n\t\t<td><a href='" . base_url() . "clubs/equip/" . $row->visitorId . "-" . teamUrlFormat($row->visitor) . "'>" . $row->visitor . "</a></td>";
                            echo "\n\t\t<td><a href='" . base_url() . "clubs/equip/" . $row->visitorId . "-" . teamUrlFormat($row->visitor) . "'><img src=\"$visitorImage\" width=60></a></td>";
                            echo "\n\t\t<td style='border-left:1px solid #626262;'>\n\t\t\t<i class=\"fa fa-map-o\" aria-hidden=\"true\"></i> <span style='text-transform:uppercase; font-weight:bold;'>" . $row->complexName . "</span><br />\n\t\t\t<i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <a target=_blank href='http://maps.google.com/?q=" . urlencode($row->complexAddress) . "'>" . $row->complexAddress . "</a><br />\n\t\t\t<i class=\"fa fa-clock-o\" aria-hidden=\"true\"></i> " . invertdateformat($row->updateddatetime) . "<br />\n\t\t<i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> <a href='https://www.futsal.cat/competicio/acta/" . $row->idMatch . "'>Veure acta</a></td>";
                            echo "\n\t</tr>";
                        endforeach;
                        ?>
                    </table>
                </div>

                <div class="tabs-panel" id="classificationTab">
                    <select id='competitionLeagueRoundSelectInClassification'>
                        <option>Selecciona jornada</option>
                        <?php
                        foreach ($rounds_by_idLeague as $row):
                            if ($row->id == $current_round_id) {
                                $s = "selected";
                                $roundNumber = $row->id;
                            } else {
                                $s = "";
                            }
                            echo "\n\t\t\†<option value=\"" . $row->id . "\" $s>Jornada " . $row->name . "</option>";
                        endforeach;
                        ?>
                    </select>
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">P</th>
                                <th colspan=2>Equip</th>
                                <th style='text-align:center;' >Pts</th>
                                <th style='text-align:center;'>J</th>
                                <th style='text-align:center;'>G</th>
                                <th style='text-align:center;'>E</th>
                                <th style='text-align:center;'>P</th>
                                 <th style='text-align:center; border-left:1px solid #ccc'>GF</th>
                                 <th style='text-align:center;'>GC</th>
                                <!--<th style='text-align:center;'>GF</th>
                                <th style='text-align:center;'>GC</th>-->
                            </tr>
                        </thead>
                        <tbody>				
                            <?php
                            foreach ($get_classification_by_idLeague_and_idRound as $row):
                                $dif = $row->position - $row->prevPosition;
                                echo "\n\t<tr>";
                                if ($dif >= 1) {
                                    $difIcon = "<i style='color:#900; font-size:20px;' class=\"fa fa-arrow-circle-o-down\" aria-hidden=\"true\"></i>";
                                } else {
                                    $difIcon = "<i style='color:#090; font-size:20px;' class=\"fa fa-arrow-circle-o-up\" aria-hidden=\"true\"></i>";
                                }
                                if ($dif == 0 || $roundNumber == 1) {
                                    $difIcon = "";
                                }
                                echo "\n\t\t<td>" . $row->position . "</td><td>$difIcon</td>";
                                echo "\n\t\t<td><a href='" . base_url() . "clubs/equip/" . $row->idTeam . "-" . teamUrlFormat($row->name) . "'><img src=\"https://www.futsal.cat/webImages/clubsImages/" . $row->image . "\" width=20 ></td>";
                                echo "\n\t\t<td><a href='" . base_url() . "clubs/equip/" . $row->idTeam . "-" . teamUrlFormat($row->name) . "'>" . $row->name . "</a></td>";
                                echo "\n\t\t<td style='background-color:#424242; color:#fff;  font-weight:bold; text-align:center;'>" . $row->points . "</td>";
                                echo "\n\t\t<td style='text-align:center;'>" . $row->playedMatches . "</a></td>";
                                echo "\n\t\t<td style='text-align:center;'>" . $row->wonMatches . "</td>";
                                echo "\n\t\t<td style='text-align:center;'>" . $row->drawMatches . "</td>";
                                echo "\n\t\t<td style='text-align:center;'>" . $row->lostMatches . "</td>";
                                echo "\n\t\t<td  style='text-align:center;border-left:1px solid #ccc;'>" . $row->goalsMade . "</td>";
                                echo "\n\t\t<td style='text-align:center;'>" . $row->goalsReceived . "</td>";
                                //echo "\n\t\t<td style='border-left:1px solid #626262;'><i class=\"fa fa-map-o\" aria-hidden=\"true\"></i> <span style='text-transform:uppercase; font-weight:bold;'>".$row->complexName."</span><br /> <i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <a target=_blank href='http://maps.google.com/?q=".urlencode($row->complexAddress)."'>".$row->complexAddress."</a><br /><i class=\"fa fa-clock-o\" aria-hidden=\"true\"></i> ".$competition->invertdateformat($row->updateddatetime)."</td>";
                                echo "\n\t</tr>";
                            endforeach;
                            ?></tbody>
                    </table>
                </div>
                <div class="tabs-panel" id="scorersTab">
                    <table>
                        <thead>
                            <tr>
                                <th >Gols</th>
                                <th style='text-align:left;' >Jugador</th>
                                <th >Equip</th>
                                <th style='text-align:center;'>Partits <br />jugats</th>
                                <th style='text-align:center;'>Gols per <br />partit</th>
                            </tr>
                        </thead>
                        <tbody><?php
                            foreach ($get_max_scorers_by_idLeague as $row):

                                if ($row->playOffImage) {
                                    $localImage = $row->playOffImage;
                                } else if ($row->image) {
                                    $localImage = "https://www.futsal.cat/images/dynamic/playersImages/" . $row->image;
                                }
                                if ($row->teamImage) {
                                    $localImage = $row->teamImage;
                                }
                                $median = intval($row->goals) / intval($row->matches);
                                echo "\n\t<tr>";
                                echo "\n\t\t<td>" . $row->goals . "</td>";
                                // echo "\n\t\t<td><a href='" . base_url() . "jugador/" . $row->idPlayer . "-" . teamUrlFormat($row->playerName) . "'><img src=\"$localImage\" width=20 ></a></td>";
                                echo "\n\t\t<td><a href='" . base_url() . "jugador/" . $row->idPlayer . "-" . teamUrlFormat($row->playerName) . "'>" . $row->playerName . "</a></td>";
                                echo "\n\t\t<td><a href='" . base_url() . "clubs/equip/" . $row->idTeam . "-" . teamUrlFormat($row->teamName) . "'>" . $row->teamName . "</a></td>";
                                echo "\n\t\t<td align=center>" . $row->matches . "</td>";
                                echo "\n\t\t<td align=center>" . number_format($median, 1) . "</td>";

                                echo "\n\t</tr>";
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="tabs-panel" id="bansTab">
                    <select id='competitionLeagueRoundSelectInBans'>
                        <option>Selecciona jornada</option>
                        <?php
                        foreach ($rounds_by_idLeague as $row):
                            if ($row->id == $current_round_id) {
                                $s = "selected";
                                $roundNumber = $row->id;
                            } else {
                                $s = "";
                            }
                            echo "\n\t\t<option value=\"" . $row->id . "\" $s>Jornada " . $row->name . "</option>";
                        endforeach;
                        ?>
                    </select>
                    <table>
                        <thead>
                            <tr>
                                <th colspan=2>Jugador</th>
                                <th >Equip</th>
                                <th >Sanci&oacute;</th>
                            </tr>
                        </thead>
                        <tbody><?php
                            foreach ($get_bans_by_idRound as $row):
                                echo "\n\t<tr>";
                                echo "\n\t\t<td><a href='" . base_url() . "jugador/" . $row->id . "-" . teamUrlFormat($row->name) . "'><img src=\"https://www.futsal.cat/images/dynamic/playersImages/" . $row->image . "\" width=20 ></td>";
                                echo "\n\t\t<td><a href='" . base_url() . "jugador/" . $row->id . "-" . teamUrlFormat($row->name) . "'>" . $row->name . "</a></td>";
                                echo "\n\t\t<td><a href='" . base_url() . "clubs/equip/" . $row->idTeam . "-" . teamUrlFormat($row->teamName) . "'>" . $row->teamName . "</a></td>";
                                echo "\n\t\t<td>" . $row->money . " &euro; " . $row->comment . "</td>";
                                echo "\n\t</tr>";
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div> 
                 <?php // echo "<pre>"; print_r($get_next_matches_by_idLeague); echo "</pre>"; ?>
                <div class="tabs-panel" id="calendarTab">
                    <table>
                        <tr>
                            <td colspan="8" align="right" style="text-align:right;"> 
                                <a href="<?php echo base_url(); ?>/manteniment/excelPartits.php?idLeague=<?php echo $id_league; ?>"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></td></tr>

                        <?php

                        $idR = '';
                        foreach ($get_next_matches_by_idLeague as $row):
                            $borderTop = '';
                            if ($idR != $row->roundName) {
                                $borderTop = 'border-top:2px solid #c0c0c0';
                            }
                            $localImage = "";
                            $visitorImage = "";
                            if ($row->club1playOffImage) {
                                $localImage = $row->club1playOffImage;
                            } else if ($row->localImage) {
                                $localImage = "https://www.futsal.cat/webImages/clubsImages/" . $row->localImage;
                            }
                            if ($row->teamImage1) {
                                $localImage = $row->teamImage1;
                            }
                            if ($row->club2playOffImage) {
                                $visitorImage = $row->club2playOffImage;
                            } else if ($row->visitorImage) {
                                $visitorImage = "https://www.futsal.cat/webImages/clubsImages/" . $row->visitorImage;
                            }
                            if ($row->teamImage2) {
                                $visitorImage = $row->teamImage2;
                            }
                            echo "\n\t<tr>";
                            echo "\n\t\t<td style='$borderTop'><a href='" . base_url() . "clubs/equip/" . $row->idLocal . "-" . teamUrlFormat($row->local) . "'>\n\t\t\t<img src=\"$localImage\" width=60 ></td>";
                            echo "\n\t\t<td style='$borderTop' align=right><a href='" . base_url() . "clubs/equip/" . $row->idLocal . "-" . teamUrlFormat($row->local) . "'>" . $row->local . "</a></td>";
                            echo "\n\t\t<td style='background-color:#828282; color:#fff; font-size:20px; font-weight:bold; text-align:center;$borderTop'>Jornada <br />" . $row->roundName . "</td>";
                            echo "\n\t\t<td style='$borderTop'><a href='" . base_url() . "clubs/equip/" . $row->idVisitor . "-" . teamUrlFormat($row->visitor) . "'>" . $row->visitor . "</a></td>";
                            echo "\n\t\t<td style='$borderTop'><a href='" . base_url() . "clubs/equip/" . $row->idVisitor . "-" . teamUrlFormat($row->visitor) . "'>\n\t\t\t<img src=\"$visitorImage\" width=60></a></td>";
                            $h = explode(" ", $row->updateddatetime);
                            $hour = substr($h[1], 0, 5);
                            echo "\n\t\t<td style='border-left:1px solid #626262;$borderTop'>\n\t\t\t<i class=\"fa fa-map-o\" aria-hidden=\"true\"></i> <span style='text-transform:uppercase; font-weight:bold;'>" . $row->complexName . "</span><br />\n\t\t\t<i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <a target=_blank href='http://maps.google.com/?q=" . urlencode($row->complexAddress) . "'>" . $row->complexAddress . "</a><br />\n\t\t\t<i class=\"fa fa-clock-o\" aria-hidden=\"true\"></i> " . invertdateformat($row->updateddatetime) . " $hour\n\t\t</td>";
                            echo "\n\t</tr>";
                            $idR = $row->roundName;
                        endforeach;
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $(function () {
        // bind change event to select
        $('#competitionLeagueRoundSelect').on('change', function () {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = "<?php echo base_url() . "competicio/lliga/" . $id_league; ?>/jornada/" + url + "/resultats"; // redirect
            }
            return false;
        });
        $('#competitionLeagueRoundSelectInClassification').on('change', function () {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = "<?php echo base_url() . "competicio/lliga/" . $id_league; ?>/jornada/" + url + "/classificacio"; // redirect
            }
            return false;
        });
        $('#competitionLeagueRoundSelectInBans').on('change', function () {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = "<?php echo base_url() . "competicio/lliga/" . $id_league; ?>/jornada/" + url + "/sancions"; // redirect
            }
            return false;
        });
        var tab = "<?php echo $tab; ?>";
        if (tab == "resultats") {

            $("#resultsTab").addClass("is-active");
            $("#classificationTab").removeClass("is-active");
            $("#bansTab").removeClass("is-active");
            $("#scorersTab").removeClass("is-active");
            $("#calendarTab").removeClass("is-active");

            $("#resultsTab-label").addClass("tabActive");
            $("#classificationTab-label").removeClass("tabActive");
            $("#bansTab-label").removeClass("tabActive");
            $("#scorersTab-label").removeClass("tabActive");
            $("#calendarTab-label").removeClass("tabActive");
            $("#example-tabs").foundation("selectTab", $("#resultsTab"));

        }
        if (tab == "classificacio") {
            $("#example-tabs").foundation("selectTab", $("#classificationTab"));
        }
        if (tab == "sancions") {
            $("#example-tabs").foundation("selectTab", $("#bansTab"));
        }
        if (tab == "calendar") {
            $("#example-tabs").foundation("selectTab", $("#resultsTab"));
        }


    });
</script>