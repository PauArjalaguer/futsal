<div class="row" id="content" style='padding:12px;'>
    <div  class="large-12 medium-12 columns">
        <div class="row">
            <div class="playerImage">

                <?php
                $this->load->helper('functions_helper');
                if ($playOffImage) {
                    $image = $playOffImage;
                } else if ($image) {
                    $image = "https://www.futsal.cat/images/dynamic/playersImages/" . $image;
                }

                echo "<img src='$image'>";
                ?>
            </div>
            <div class="playerTitle">
                <h1><?php echo $playerName; ?></h1><br /><span class='playerSubTitle'><?php
                    echo "<a href='" . base_url() . "clubs/equip/" . $idTeam . "-" . teamUrlFormat($teamName) . "'>$teamName</a>";
                    echo " &bull; Edat: " . calculaedad($birthdate);
                    ?></span>
            </div>
        </div>
        <div class='row'>
            <div style='clear:both;margin-top:55px;'></div>
            <div  class="large-12 medium-12 columns"><h2>Estadístiques</h2>
                <table>
                    <tbody>
                        <tr>
                            <td>Gols</td><td><?php
                                if (!$get_player_stats['goals']) {
                                    $get_player_stats['goals'] = 0;
                                }
                                if (!$get_player_stats['yellow']) {
                                    $get_player_stats['yellow'] = 0;
                                }
                                if (!$get_player_stats['blue']) {
                                    $get_player_stats['blue'] = 0;
                                }echo $get_player_stats['goals'];
                                ?></td>
                        </tr>
                        <tr>
                            <td>Tarjetes grogues</td><td><?php echo $get_player_stats['yellow']; ?></td>
                        </tr>
                        <tr>
                            <td>Tarjetes blaves</td><td><?php echo $get_player_stats['blue']; ?></td>
                        </tr>
                        <tr>   
                            <td>Partits jugats</td><td><?php echo $get_player_stats['played']; ?></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class='row'>
            <div style='clear:both;margin-top:55px;'></div>
            <div  class="large-12 medium-12 columns">
                <h2>Temporades anteriors</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Equip</th>
                            <th>Competició</th>
                            <th>Temporada</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($get_previous_teams as $row):
                            echo "<tr><td><a href='" . base_url() . "clubs/equip/" . $row->idTeam . "-" . teamUrlFormat($row->teamName) . "'>" . $row->teamName . "</a></td><td><a href='" . base_url() . "competicio/lliga/" . $row->idLeague . "-" . teamUrlFormat($row->leagueName) . "'>" . $row->leagueName . "</a></td><td>" . $row->seasonName . "</td></tr>";
                        endforeach;
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>