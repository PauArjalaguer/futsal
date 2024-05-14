<div class="row" id="content" style='padding:12px;'>
    <?php
    $this->load->helper('functions_helper');
    if ($search == 1) {
        $visible = "none";
    }
    ?>
    <div  class="large-12 medium-12 columns">
        <div class="row" style='background-color:#600; display:<?php echo $visible; ?>'>
            <div class="large-4 medium-4 columns">
                <label>Club
                    <input onKeyUp="clubsSearch()" id="clubsSearchInputText" type="text" placeholder="Buscar per nom" aria-describedby="Buscar per nom">
                </label>
            </div>
            <div class="large-4 medium-4 columns">
                <label>Ciutat
                    <select onChange="clubsSearch()" id="clubsSearchCitiesSelect">
                        <option></option>
                        <?php
                        $this->load->helper('functions_helper');
                        foreach ($get_distinct_cities as $row):
                            if ($row->city) {
                                echo "\n\t<option value=\"" . $row->city . "\">" . $row->city . "</option>";
                            }
                        endforeach;
                        ?>
                    </select>
                </label>
            </div>
            <div class="large-4 medium-4 columns">
                <label>Provincia
                    <select onChange="clubsSearch()" id="clubsSearchProvincesSelect">
                        <?php
                        foreach ($get_distinct_provinces as $row):
                            echo "\n\t<option value=\"" . $row->province . "\">" . $row->province . "</option>";
                        endforeach;
                        ?>
                    </select>
                </label>
            </div>

        </div>
        <div class="row" id="clubsSearchContainer">
            <table width=100%>
                <thead>
                    <tr>
                        <th colspan=2>Club</th>
                        <th scope="column">Població</th>
                        <th>Provincia</th>
                       <!-- <th>Equips</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($get_clubs as $row):
                        echo "\n\t<tr>\n\t\t<td valign=top><a href='clubs/info/" . $row->idClub . "-" . teamUrlFormat($row->clubName) . "'>";
                        if ($row->playOffImage) {
                            echo "<img width=90 src=\"" . $row->playOffImage . "\">";
                        } else {
                            echo "<img width=90 src='https://www.futsal.cat/webImages/clubsImages/" . $row->image . "'>";
                        }
                        echo "</a></td>";
                        echo "\n\t\t<td valign=top ><span style='text-transform:uppercase;font-weight:bold; '><a href='clubs/info/" . $row->idClub . "-" . teamUrlFormat($row->clubName) . "'>" . $row->clubName . "</a></span><br /><!--<i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i><a target=_blank href='http://maps.google.com/?q=" . urlencode($row->address . " ," . $row->city) . "'> " . $row->address . "</a><br /><i class=\"fa fa-envelope\" aria-hidden=\"true\"></i> " . $row->email . "<br /><i class=\"fa fa-phone-square\" aria-hidden=\"true\"></i> " . $row->phone1 . "<br />--></td>";
                        echo "\n\t\t<td valign=top>" . $row->city . "</td>";
                        echo "\n\t\t<td valign=top>" . $row->province . "</td>";
                        echo "\n\t\t<td valign=top>";
                        echo "</td></tr>";
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>