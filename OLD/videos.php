<div class="newHeader"><div id='sectionTitle'><span style='color:#600;'>></span> Recull de videos</div>
</div>
<div style='margin:0; padding:0; ' >

    <?php
    include("Classes/Videos_class.php");
    $videos = new Video;
    $videos->tablename = "videos";
    $videos->order = "id desc";
    $videos->fields = "Id,Title,Code,Image,Website,Description, Keywords";
    $videos->pageno = $_GET['p'];
    $videos->rows_per_page = 12;
    $data = $videos->getAllVideos($where);
    foreach ($data as $video) {
        /* if (!empty($video[3])) {
          echo "\n\t<p><img  src=\"" . $video[3] . "\" width=\"100\"  alt=\"" . $video[1] . "\" /></p>";
          } */
        echo "\n\t<div style='margin-top:20px;width:180px; height:150px; float:left; margin-left:14px; margin-bottom:20px; -webkit-box-shadow: 0px 2px 5px 2px rgba(99, 99, 99, 0.2);
box-shadow: 0px 2px 5px 2px rgba(99, 99, 99, 0.2);'>";
        if (!empty($video[3])) {
            //echo "\n\t<p style='float:left;' >";
            if ($video[4] != "youtube" and $video[4] != "vimeo" and $video[4] != "blipTv" and $video[4] != "livestream"  ) {
                echo "\n\t\t<img src=\"http://www.futsal.cat/futsalTv/files/" . $video[3] . "\"   width=180 height=90  /><br />";
            } else {
                echo "\n\t\t<img src=\"$video[3]\"  width=180 height=90  /><br />";
            }
        } else {
            echo "\n\t\t<img src='http://www.futsal.cat/webImages/videoNoThumb.jpg'   width=180 height=90  >";
        }
        echo "\n\t\t<div style='border:1px solid #ddd; border-top:0; height:50px; padding:5px 10px;'>";
        echo "\n\t\t\t<div style='width:50%; float:left; padding-top:5px'>";
        echo "\n\t\t\t\t<a  style='font-size:11px; font-family:Arial; font-weight:bold;'  href='" . $serverUrl . "clip/" . $video[0] . "-" . treuAccents($video[1]) . "'>" . $video[1] . "</a>";
        echo "\n\t\t\t</div>";
        echo "\n\t\t\t<div style=' width:50%; height:50px; float:left; text-align:center; vertical-align:middle;'>\n\t\t\t\t<a href='" . $serverUrl . "clip/" . $video[0] . "-" . treuAccents($video[1]) . "'><img src='http://www.selenitastic.com/wp-content/uploads/2012/07/iconPlay.png' width=30></a>\n\t\t\t</div>\n\t\t\t<div style='clear:both;'>&nbsp;</div>\n\t\t</div></div>";
        $text = strip_tags($video[5]);

        // echo "\n\t<p class=\"$paragraf\">" . nl2br($text) . " $link</p></li>";
        // echo "<div style='clear:both;'>&nbsp;</div>";
    }
    
    echo "<div style='clear:both;'></div>";
    $numberOfPages = $videos->buildPaginator();

    echo "<div align=\"center\"><div class=\"newsPaginator\">";

    $pages = $videos->buildPaginator();
    if (empty($_GET['p'])) {
        $p = 1;
    } else {
        $p = $_GET['p'];
    }
    //echo "Pàgina " . $p . " de " . floor($pages) . "  &nbsp;  ";
    //echo "<a  class='white_link' href=\"?f=videos&amp;p=1\"> &lt;&lt; </a> ";
    if (floor($pages) > 1) {
        if ($i == $p) {
            $class = 'actiu';
        }
        for ($i = 1; $i <= floor($pages); $i++) {
            echo "<a  class='$class' href=\"" . $serverUrl . "videos/$i\">$i</a> ";
        }
        //echo "<a  class='white_link' href=\"?f=videos&amp;p=" . floor($pages) . "\">  &gt;&gt; </a>";
    }
    echo "</div></div>";
    ?>

</div>