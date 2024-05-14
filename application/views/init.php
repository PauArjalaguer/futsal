<style>
    .vid-clip-sm {
        width: 165px;
        height: 120px;
        position: relative;
        margin: 0 8px 8px 0;
        float: left;
    }

    .vid-clip-sm .vid-clip-play {
        width: 165px;
        height: 84px;
        position: absolute;
        top: 0;
        left: 0;
        -webkit-transition-property: background-color;
        -moz-transition-property: background-color;
        -o-transition-property: background-color;
        transition-property: background-color;
        -webkit-transition-duration: 0.4s;
        -moz-transition-duration: 0.4s;
        -o-transition-duration: 0.4s;
        transition-duration: 0.4s;
    }

    .vid-clip-sm .vid-clip-play:hover {
        background-color: rgba(0, 0, 0, 0.3);
        filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#66000000', endColorstr='#66000000'); /* IE */

    }

    .vid-clip-sm .vid-clip-play img {
        position: absolute;
        top: 50%;
        left: 50%;
        margin: -22px 0 0 -22px;
        width: 60px;
    }
</style>
<div class="row" id="content" >
      <!--<div  class="large-8 medium-8 columns">
       <div class="row">
        <div class="small-12 medium-12 columns">
        <iframe allow="autoplay; encrypted-media" allowfullscreen="" frameborder="0"  src="https://www.youtube.com/embed/XqjlIt8FLFo" width="1120" height="660"></iframe>
        </div></div>
</div>-->
    <div  class="large-8 medium-8 columns">
       <div class="row">
			<div class="small-12 medium-12 columns">
                <a href='http://futsal.playoffinformatica.net/InscripcioWeb.php?idLliga=19' target="_blank">  <img src="<?php echo base_url(); ?>content/images/banners/entrenadors.jpg" ></a>
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
                    \n\t\t<div class=\"small-12 medium-6 columns end\" >
                        \n\t\t\t<div class=\"newsThumbnail\" >
                           \n\t\t\t<a href=\"" . base_url() . "noticies/detall/" . $row->id . "-" . teamUrlFormat($row->title) . "\">
                                <img src=\"http://www.futsal.cat/images/dynamic/newsImages/" . $row->pathImage . "\" width=\"350\" height=175 >
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
 <div class="large-4 medium-4 columns columns">
                <a href='http://futsal.playoffinformatica.net/AfiliacioFederatWeb.php' target="_blank">  <img src="<?php echo base_url(); ?>content/images/banners/afiliat.jpg" ></a>
            </div>
            <div class="large-4 medium-4 columns columns">
                <a href='http://www.futsal.cat/content/documentacio/Instruccions_Playoff.pdf' target="_blank">  <img src="<?php echo base_url(); ?>content/images/banners/instruccions.jpg" ></a>
            </div>
    <div class="large-4 medium-4 columns" style='display:none;' >
        <h2>Sancions </h2>
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

    <div class="large-4 medium-4 columns" style='display:none;'>
        <h2>Sancions</h2>
        <table class="classificationTable">


            <?php
            foreach ($get_documents_by_comite as $row):

                echo "\n<tr >
                      <td><a href='content/documentacio/" . $row->filePath . "' target=_blank><span class=\"classificationTableTeamCount\">" . $row->fileName . "</span></a></td>";
                echo "<td align=right><a href='content/documentacio/" . $row->filePath . "' target=_blank><span ><i class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i></a></td>

                      </tr>";
            endforeach;
            ?>

        </table>
    </div>
	<div class="large-4 medium-4 columns" >&nbsp;</div>
    <div class="large-4 medium-4 columns" >
<img src="https://futsal.cat/content/images/banners/barri.jpg" />
        <h2>Videos</h2>
        <?php
        foreach ($get_videos as $row):
            echo "\n<div class='vid-clip-sm'>"
            . "\n\t<a href=\"" . base_url() . "multimedia/video/" . $row->id . "\">"
            . "\n\t\t<img width=100% src='" . $row->image . "'>"
            . "\n\t</a>"
            . "\n\t<div class=\"vid-clip-play\">"
            . "\n\t\t<a href=\"" . base_url() . "multimedia/video/" . $row->id . "\">"
            . "\n\t\t\t<img src=\"" . base_url() . "content/images/backgrounds/playButton.png\" ></a>
  </div></div>";
        endforeach;
        ?>
        <div style='clear: both;'></div>
    </div>
    <div class="large-4 medium-4 columns">
        <a class="twitter-timeline" href="https://twitter.com/futsalcat"  data-height="550">Twitter</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>

</div>
<div class="expanded row" id="scorers" >
    <div class="large-16 medium-16 colums">
        <div class="row collapse" >
            <h2>Calendaris</h2><div >
                <?php
                $division = "";
                if (count($get_competitions) > 0) {
                    foreach ($get_competitions as $row):

                        if ($row->division != $division) {
                            echo "\n\t</div>\n\t<div class='large-4 medium-4 columns end' >\n\t\t<h3 style='color:" . $row->color . "; font-weight:bold; font-size:20px;'>" . $row->division . "</h3>";
                        }

                        $league = str_replace($row->division, "", $row->name);
                        $league = str_replace(">", "<i class=\"fi-torsos-all large\"></i>", $league);
                        echo "\n\t\t<div style='border:1px solid " . $row->color . "; height:40px; font-size:15px; width:80px; margin:5px 10px; padding-top:8px; text-align:center; float:left; color:" . $row->color . "'>";
                        $league2 = str_replace($row->division, "", $row->name);
                        echo "<a style='color:" . $row->color . ";' href='competicio/lliga/" . $row->id . "-" . $league2 . "'>" . $league . "</a></div>";
                        $division = $row->division;
                    endforeach;
                } else {
                    echo "<h3>Els calendaris 2018/19 seràn publicats en breu</h3>";
                }
                ?>
            </div>

        </div>
    </div>
</div>
<div class="row" id="results" >
    <div class="large-12 medium-12 columns" >
        <h2>Propers partits</h2>
        <table class="responsive">
            <tbody>
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
  <td class=\"matchesTableTeam\" align=right  ><a href='clubs/equip/" . $row->localId . "-" . teamUrlFormat($row->local) . "'><img src=\"http:/www.futsal.cat/webImages/clubsImages/" . $row->localImage . "\" width=\"15\"></a><a href='equip/" . $row->localId . "-" . teamUrlFormat($row->local) . "'> " . $row->local . "</a></td>

  <td class=\"matchesTableTeam\" align=left><a href='clubs/equip/" . $row->visitorId . "-" . teamUrlFormat($row->visitor) . "'>" . $row->visitor . "</a> <a href='clubs/equip/" . $row->visitorId . "-" . teamUrlFormat($row->visitor) . "'><img src=\"http://www.futsal.cat/webImages/clubsImages/" . $row->visitorImage . "\" width=\"15\"></a></td>
  <td class=\"matchesTableComplex\" colspan=4><strong>" . $row->divisionName . "</strong></td><td> <span class=\"matchesTableComplexName\">" . $row->complexName . "</span></td><td> <span class=\"matchesTableComplexAddress\"> " . $row->complexAddress . "</span></td>
  </tr>";


                endforeach;
                ?>
            </tbody>
        </table>
    </div>
    <div class="large-12 medium-12 columns " id="results" >
        <h2>&Uacute;ltims resultats</h2>
        <table class=" responsive">
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
                echo "<td class=\"matchesTableTeam\" align=right ><a href='clubs/equip/" . $row->localId . "-" . teamUrlFormat($row->local) . "'> " . $row->local . "</a>&nbsp;<a href='clubs/equip/" . $row->localId . "-" . teamUrlFormat($row->local) . "'><img src=\"http://www.futsal.cat/webImages/clubsImages/" . $row->localImage . "\" width=\"15\"></a></td>
  <td style='width:50px;'>" . $row->localResult . " - " . $row->visitorResult . "</td>
  <td class=\"matchesTableTeam\" align=left><a href='clubs/equip/" . $row->visitorId . "-" . teamUrlFormat($row->visitor) . "'> <img src=\"http://www.futsal.cat/webImages/clubsImages/" . $row->visitorImage . "\" width=\"15\"></a>&nbsp;<a href='clubs/equip/" . $row->visitorId . "-" . teamUrlFormat($row->visitor) . "'>" . $row->visitor . "</a>  </td>
<td class=\"matchesTableTeam\" align=left><a href='".base_url()."competicio/acta/".$row->idMatch."'>Veure acta</a></td>
  </tr>";
            endforeach;
            ?>

        </table>
    </div>
</div>