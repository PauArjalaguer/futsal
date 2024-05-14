<div class="row" id="content" style='padding:12px;'>
    <div  class="small-12 columns">

        <?php
        //echo "<pre>"; print_r(get_defined_vars()); echo "</pre>";
        echo "<h1> <a style='color:#424242;' href='" . base_url() . "clubs/equip/" . $idLocal . "-" . teamUrlFormat($localName) . "'>" . $localName . " </a> - <a style='color:#424242;' href='" . base_url() . "clubs/equip/" . $idVisitor . "-" . teamUrlFormat($visitorName) . "'>" . $visitorName . ".</a></h1> ";
        ?>
    </div>


    <div class="small-6 columns" style='border-bottom: 1px solid #f6f6f6;'>
        <?php
        $leagueName=str_replace(">","",$leagueName);
        echo "<span style='font-size:20px; font-weight:bold; '><a style='color:#626262;' href='" . base_url() . "competicio/lliga/" . $idLeague . "-" . teamUrlFormat($leagueName) . "'> $leagueName</a></span>";
        ?>
    </div>
    <div class="small-6 columns" align="right" style='border-bottom: 1px solid #f6f6f6;'>
        <?php
        echo "<span style='font-size:20px; font-weight:bold; '><a style='color:#626262;' href='" . base_url() . "competicio/lliga/" . $idLeague . "/jornada/" . $idRound . "/resultats'>Jornada $roundName</a></span>";
        ?>
    </div>
    <div  class="small-12 columns">
        <b>Arbitrat per:</b> 
        <?php
        echo $refereeString;
        ?>
    </div>
    <div class="small-6 columns">
        <b>Data: </b>
        <?php
        $d = explode(" ", $updateddatetime);
        $date = $d[0];
        $hour = $d[1];
        $hour = substr($hour, 0, -3);
        echo invertdateformat($date) . " " . $hour;
        ?>
    </div>
    <div class="small-6 columns set-right-justified" align="right"><?php echo $complexName . "<br /><span style='color:#424242;font-size:12px;'>($complexAddress)</span>"; ?></div>

    <div class="small-12 columns"><div>&nbsp;</div>
        <div class="small-3 columns">
            <img  src="<?php echo $localImage; ?>" style='max-height: 100px; max-width: 100px;' >
        </div>
        <div class="small-3 columns" align="right">
            <input disabled value="<?php echo $localResult; ?>" name="localResult" type="number" style="border:1px solid #ddd; font-size:54px; width:100px; height:100px; text-align: center;"> 
        </div>
        <div class="small-3 columns" align="left">
            <input disabled value="<?php echo $visitorResult; ?>" name="visitorResult" type="number" style="border:1px solid #ddd; font-size:54px; width:100px; height:100px;text-align: center;"> </td>
        </div>
        <div class="small-3 columns" align="right">
            <img style='max-height: 100px; max-width: 100px;' src="<?php echo $visitorImage; ?>">
        </div>
    </div>
    <div class="clearfix"></div>


    <div class="small-6 columns" align="right">&nbsp;

        <?php
        foreach ($localGoals as $row) {
            echo "Minut " . $row->minute . " - <a  href='" . base_url() . "jugador/" . $row->id . "-" . teamUrlFormat($row->name)."'>".$row->name . "</a><br />";
        }
        ?>


    </div>
    <div class="small-6 columns" align="left">

        <?php
        foreach ($visitorGoals as $row) {
            echo "Minut " . $row->minute . " -  <a  href='" . base_url() . "jugador/" . $row->id . "-" . teamUrlFormat($row->name)."'>".$row->name . "</a><br />";
        }
        ?>

&nbsp;
    </div>


    <div class="clearfix"></div>
    <div class="small-6 columns">
        <table class="table table-condensed strie" id="playersTable">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>TG</th>
                    <th>TB</th>
                    <th>Gols</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $pos = "";
                //echo "<pre>"; print_r(get_defined_vars()); echo "</pre>";
                foreach ($localPlayers as $row) {
                    if ($row->position != $pos and $row->position != "Jugador") {
                        echo "<tr><td colspan=6><h3>" . $row->position . "</h3></td></tr>";
                    }
                    $n = explode(" ", $row->name);
                    $row->name = $n[0] . " " . $n[1] . " " . $n[2];
                    if (!$row->yellowCards) {
                        $row->yellowCards = 0;
                    }
                    if (!$row->blueCards) {
                        $row->blueCards = 0;
                    }
                    if ($row->playOffImage) {
                        $localImage = $row->playOffImage;
                    } else if ($row->image) {
                        $localImage = "https://www.futsal.cat/images/dynamic/playersImages/" . $row->image;
                    }
                    echo "\n<tr>";
                    //echo "\n\t<td style='max-width:20px;'><img src='" . $localImage . "' style='max-height:50px;'>";
                   echo "\n\t<td>";
                    if ($row->position == "Jugador") {
                        echo "<b> [" . $row->number . "]</b> ";
                    }
                    echo "<a  href='" . base_url() . "jugador/" . $row->id . "-" . teamUrlFormat($row->name)."'>".$row->name . "</a>";
                    echo "</td>";

                    echo "\n\t<td style=\"width: 20px\">" . $row->yellowCards . "</td>";
                    echo "\n\t<td style=\"width: 20px\">" . $row->blueCards . "</td>";
                    echo "\n\t<td style=\"width: 20px\">" . $row->goals . "</td>";
                    echo "\n</tr>";
                    $pos = $row->position;
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="small-6 columns">
        <table class="table table-condensed" id="playersTable2">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>TG</th>
                    <th>TB</th>
                    <th>Gols</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //echo "<pre>"; print_r(get_defined_vars()); echo "</pre>";
                foreach ($visitorPlayers as $row) {
                    if ($row->position != $pos and $row->position != "Jugador") {
                        echo "<tr><td colspan=6><h3>" . $row->position . "</h3></td></tr>";
                    }
                    $n = explode(" ", $row->name);
                    $row->name = $n[0] . " " . $n[1] . " " . $n[2];
                    if (!$row->yellowCards) {
                        $row->yellowCards = 0;
                    }
                    if (!$row->blueCards) {
                        $row->blueCards = 0;
                    }
                    if ($row->playOffImage) {
                        $localImage = $row->playOffImage;
                    } else if ($row->image) {
                        $localImage = "https://www.futsal.cat/images/dynamic/playersImages/" . $row->image;
                    }
                    echo "\n<tr>";
                    //echo "\n\t<td style=' max-width:20px;'><img src='" . $localImage . "' style='max-height:50px;'>";

                    echo "\n\t<td>";
                    if ($row->position == "Jugador") {
                        echo "<b> [" . $row->number . "]</b> ";
                    }
                   echo "<a  href='" . base_url() . "jugador/" . $row->id . "-" . teamUrlFormat($row->name)."'>".$row->name . "</a>";
                    echo "</td>";

                    echo "\n\t<td style=\"width: 20px\">" . $row->yellowCards . "</td>";
                    echo "\n\t<td style=\"width: 20px\">" . $row->blueCards . "</td>";
                    echo "\n\t<td style=\"width: 20px\">" . $row->goals . "</td>";
                    echo "\n</tr>";
                    $pos = $row->position;
                }
                ?>
            </tbody>
        </table>
    </div>


</div>
