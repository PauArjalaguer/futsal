<div class="row" id="content" style='padding:12px;'>
    <div  class="large-12 medium-12 columns">
        <div class="row">

            <div class="clubLogo">
               
           <?php $this->load->helper('functions_helper');
            if ($playOffImage) {
                            echo "<img src=\"" . $playOffImage . "\">";
                        } else {
                            echo "<img src='https://www.futsal.cat/webImages/clubsImages/" . $image . "'>";
                        }
                    ?>    
            </div>
            <div class="clubTitle">
                <h1><?php echo $name; ?></h1>
            </div>
            <div style='clear:both;margin-top:55px;'></div>
            <div  class="large-12 medium-12 columns">
                <div class="row">
                    <table >
                        <tr><td><strong>Provincia:</strong></td><td><?php echo $province; ?></td></tr>
                        <tr><td><strong>Adreça:</strong></td><td><a target=_blank href='http://maps.google.com/?q=<? echo urlencode($address.",". $city); ?>'><? echo $address; ?>, <? echo $city; ?></a></td></tr>
                        <tr><td><strong>Telèfons:</strong></td><td><?php echo $phone1; ?> <?php echo $phone2; ?></td></tr>
                        <!--<tr><td><strong>Contacte:</strong></td><td><?php echo $contact; ?></td></tr>
                        <tr><td><strong>Facebook:</strong></td><td><?php echo $facebook; ?></td></tr>
                        <tr><td><strong>Twitter:</strong></td><td><? echo $twitter; ?></td></tr>-->
                  

                    </table>
                </div>
            </div>
            <div  class="large-6 medium-6 columns" style="display:none;">
                <div class="row">
                    <table >
                        <tr><td><strong>Codi club:</strong></td><td><? echo $clubCode; ?></td></tr>
                        <tr><td><strong>President:</strong></td><td><? echo $president; ?></td></tr>
                        <tr><td><strong>Vicepresidents:</strong></td><td><? echo $vicepresident1; ?> <? echo $vicepresident2; ?></td></tr>
                        <tr><td><strong>Email:</strong></td><td><? echo $email; ?></td></tr>
                          </table>

                </div>
            </div>
            <p style='padding:0px 5px;'><strong>Descripció:</strong><br /><? echo nl2br($description); ?></p>

            <table><thead><tr><th>Equips</th><th>Competició</th></tr></thead>
                <tbody>
                    <?php
                    foreach ($get_teams_by_idClub as $row):

                        if (empty($row->leagueName)) {
                            $row->leagueName = "No juga aquesta temporada";
                        } else {
							   $row->leagueName =  str_replace(">", "",  $row->leagueName);
                            $row->leagueName = "<a href='" . base_url() . "competicio/lliga/" . $row->idLeague . "-" . teamUrlFormat($row->leagueName) . "'>" . $row->leagueName . "</a>";
 echo "\n\t<tr>\n\t\t<td>\n\t\t\t<a href='" . base_url() . "clubs/equip/" . $row->idTeam . "-" . teamUrlFormat($row->teamName) . "'>" . $row->teamName . "\n\t\t</td>\n\t\t<td>" . $row->leagueName . "</td>\n\t</tr>";
                       
					   }
                       


                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>