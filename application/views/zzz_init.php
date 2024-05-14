<div class="row" id="content">
    <div  class="large-8 medium-8 columns">
        <div class="row">
            <div class="large-6 medium-6 columns">
                <img src="http://www.sampleprepconference.com/uploadedImages/_Assets/banner.jpg">
            </div>
            <div class="large-6 medium-6 columns">
                <img src="http://www.sampleprepconference.com/uploadedImages/_Assets/banner.jpg">
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="large-12 columns">
                <h2>Not&iacute;cies</h2>
            </div>
            <?php
            $short = array(null,
                'Gen',
                'Feb',
                'Mar',
                'Abr',
                'Mai',
                'Jun',
                'Jul',
                'Ago',
                'Set',
                'Oct',
                'Nov',
                'Des'
            );
            $this->load->helper('functions_helper');
            foreach ($get_news as $row):
                ?>
                <?php
                echo "\n\t<!--Noticia-->
                    \n\t\t<div class=\"large-6 medium-6 columns\">
                        \n\t\t\t<div class=\"newsThumbnail\" >
                           \n\t\t\t<a href=\"" . base_url() . "noticies/detall/" . $row->id . "-" . teamUrlFormat($row->title) . "\">
                                <img src=\"http://v3.futsal.cat/newsImages/" . $row->pathImage . "\" width=\"350\" height=175 >
                            </a>
                        </div>
                        \n\t\t\t<div class=\"newsHeader\"> 
                            \n\t\t\t\t<h3><a href=\"" . base_url() . "noticies/detall/" . $row->id . "-" . teamUrlFormat($row->title) . "\">" . substr(strip_tags($row->title), 0, 70) . "</a></h3>
                        </div>
                        \n\t\t\t<div class=\"newsInfo\">
                            \n\t\t\t\t<div class=\"newsInfoDate\">
                                <i class=\"fi-calendar\" style=\"font-size:15px;\"></i> " . $row->updateDate . "
                            </div>
                        </div>
                        \n\t\t\t<div class=\"newsContent\" >
                            " . substr(strip_tags($row->content), 0, 110) . "...<br /><a href=\"" . base_url() . "noticies/detall/" . $row->id . "-" . teamUrlFormat($row->title) . "\" class=\"read-more\">Llegir</a>
                        </div>
                    </div>
                    <!--/Noticia-->";
                ?>


            <?php endforeach; ?>

        </div>

    </div>
    <div class="large-4 medium-4 columns" >
        <h2>M&uacute;tua</h2>
        <table class="classificationTable">


            <?php
            foreach ($get_documents_by_mutua as $row):
                echo "\n<tr >
                      <td><a href='documentacio/" . $row->id . "' target=_blank><span class=\"classificationTableTeamCount\">" . $row->fileName . "</a></span></td>";
                echo "<td align=right><span ><a href='documentacio/" . $row->filePath . "' target=_blank><i class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i></a></td>

                      </tr>";
            endforeach;
            ?>

        </table>
    </div>
    <div class="large-4 medium-4 columns" >
        <h2>Comit&egrave;s</h2>
        <table class="classificationTable">


            <?php
            foreach ($get_documents_by_comite as $row):

                echo "\n<tr >
                      <td><a href='documentacio/" . $row->id . "' target=_blank><span class=\"classificationTableTeamCount\">" . $row->fileName . "</span></a></td>";
                echo "<td align=right><a href='documentacio/" . $row->filePath . "' target=_blank><span ><i class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i></a></td>

                      </tr>";
            endforeach;
            ?>

        </table>
    </div>

    <div class="large-4 medium-4 columns">
        <a class="twitter-timeline" href="https://twitter.com/futsalcat"  data-height="550">Twitter</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
</div>
<div class="expanded row" id="scorers">
    <div class="large-16 medium-16 colums">
        <div class="row collapse" >
            <h2>Calendaris</h2><div >
                <?php
                $division = "";
                foreach ($get_competitions as $row):

                    if ($row->division != $division) {
                        echo "\n\t</div>\n\t<div class='large-4 medium-4 columns' >\n\t\t<h3 style='color:" . $row->color . "; font-weight:bold; font-size:20px;'>" . $row->division . "</h3>";
                    }

                    $league = str_replace($row->division, "", $row->name);
                    echo "\n\t\t<div style='border:1px solid " . $row->color . "; height:40px; font-size:15px; width:80px; margin:5px 10px; padding-top:8px; text-align:center; float:left; color:" . $row->color . "'><a style='color:" . $row->color . ";' href='competicio/lliga/" . $row->id . "-" . $league . "'>" . $league . "</a></div>";
                    $division = $row->division;
                endforeach;
                ?>
            </div>

        </div>
    </div>

</div>
<div class="row" id="results">
    <div class="large-12 medium-12 columns">
        <h2>Propers partits</h2>
        <table class="matchesTable">
            <?php
            foreach ($get_next_matches as $row):

                $dt = explode(" ", $row->updatedDateTime);
                $hour = $dt[1];
                $d = explode("-", $dt[0]);
                $data = $d[2] . " " . $short[floor($d[1])] . " - " . substr($hour, 0, 5);
                $row->local = str_replace($row->divisionName, "", $row->local);
                $row->visitor = str_replace($row->divisionName, "", $row->visitor);
                echo "<tr class=\"matchesTableRow\">
  <td class=\"matchesTableDate\"><span class=\"classificationTableTeamCount\">" . $data . " </span></td>
  <td class=\"matchesTableTeam\" align=right  ><a href='equip/" . $row->localId . "-" . teamUrlFormat($row->local) . "'><img src=\"http://v3.futsal.cat/webImages/clubsImages/" . $row->localImage . "\" width=\"25\"></a><a href='equip/" . $row->localId . "-" . teamUrlFormat($row->local) . "'> " . $row->local . "</a></td>

  <td class=\"matchesTableTeam\" align=left><a href='equip/" . $row->visitorId . "-" . teamUrlFormat($row->visitor) . "'>" . $row->visitor . "</a> <a href='equip/" . $row->visitorId . "-" . teamUrlFormat($row->visitor) . "'><img src=\"http://v3.futsal.cat/webImages/clubsImages/" . $row->visitorImage . "\" width=\"25\"></a></td>
  <td class=\"matchesTableComplex\" colspan=4><strong>" . $row->divisionName . "</strong><br /> <span class=\"matchesTableComplexName\">" . $row->complexName . "</span><br /> <span class=\"matchesTableComplexAddress\"> " . $row->complexAddress . "</span></td>
  </tr>";
            endforeach;
            ?>

        </table>
    </div>
    <div class="large-12 medium-12 columns " id="results">
        <h2>&Uacute;ltims resultats</h2>
        <table class="matchesTable responsive">
            <?php
            foreach ($get_last_results as $row):

                $dt = explode(" ", $row->updatedDateTime);
                $hour = $dt[1];
                $d = explode("-", $dt[0]);
                $data = $d[2] . " " . $short[floor($d[1])] . " - " . substr($hour, 0, 5);
                $row->local = str_replace($row->visitorId, "", $row->local);
                $row->visitor = str_replace($row->visitorId, "", $row->visitor);
                echo "<tr class=\"matchesTableRow\">";
                echo "<td class=\"matchesTableDate\"><span class=\"classificationTableTeamCount\">" . $data . " </span></td>";
                echo "<td class=\"matchesTableTeam\" align=right ><a href='equip/" . $row->localId . "-" . teamUrlFormat($row->local) . "'> " . $row->local . "</a>&nbsp;<a href='equip/" . $row->localId . "-" . teamUrlFormat($row->local) . "'><img src=\"http://v3.futsal.cat/webImages/clubsImages/" . $row->localImage . "\" width=\"25\"></a></td>
  <td style='width:50px;'>" . $row->localResult . " - " . $row->visitorResult . "</td>
  <td class=\"matchesTableTeam\" align=left><a href='equip/" . $row->visitorId . "-" . teamUrlFormat($row->visitor) . "'> <img src=\"http://v3.futsal.cat/webImages/clubsImages/" . $row->visitorImage . "\" width=\"25\"></a>&nbsp;<a href='equip/" . $row->visitorId . "-" . teamUrlFormat($row->visitor) . "'>" . $row->visitor . "</a>  </td>

  </tr>";
            endforeach;
            ?>

        </table>
    </div>
</div>