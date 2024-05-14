
    <?php $this->load->helper('functions_helper'); ?>
    <div  class="large-12 medium-12 columns">
       
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
                      echo "\n\t<tr>\n\t\t<td valign=top><a href='clubs/info/".$row->idClub."-".teamUrlFormat($row->clubName)."'>";
                     if ($row->playOffImage) {
                            echo "<img width=90 src=\"" . $row->playOffImage . "\">";
                        } else {
                            echo "<img width=90 src='https://www.futsal.cat/webImages/clubsImages/" . $row->image . "'>";
                        }
                        echo "</a></td>";
                      echo "\n\t\t<td valign=top ><span style='text-transform:uppercase;font-weight:bold; '><a href='clubs/info/".$row->idClub."-".teamUrlFormat($row->clubName)."'>".$row->clubName."</a></span><!--<br /><i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i><a target=_blank href='http://maps.google.com/?q=".urlencode($row->address." ,". $row->city)."'> ".$row->address."</a><br /><i class=\"fa fa-envelope\" aria-hidden=\"true\"></i> ". $row->email."<br /><i class=\"fa fa-phone-square\" aria-hidden=\"true\"></i> ". $row->phone1."<br />--></td>";
                      echo "\n\t\t<td valign=top>".$row->city."</td>";
                      echo "\n\t\t<td valign=top>".$row->province."</td>";
                      echo "\n\t\t<td valign=top>";
                      //$teams->idClub=$row->idClub;
                      //$data2 = $teams->TeamsGetByClubId();
                      /*foreach($data2 as $t){
                      echo "\n\t\t".$t[1]."&nbsp; <i class=\"fa fa-arrow-circle-o-right\" aria-hidden=\"true\"></i><br />";
                      }*/
                      endforeach;


                      echo "</td></tr>";
                     
                    ?>
                </tbody>
            </table>
        </div>
    </div>
