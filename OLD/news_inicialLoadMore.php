<?php

include ("includes/test/db.inc");
include("Classes/News_class.php");
include ("includes/test/config.php");
include ("includes/funciones.php");
if (preg_match("/MSIE 7.0/", $_SERVER['HTTP_USER_AGENT'])) {
    $browser = 'ie7';
}
$news = new News;
$news->tablename = "news n join newscategories c on n.categoryId=c.id";
$news->order = "updatedate desc, id desc";
$news->fields = "n.Id,Title,Content,PathImage,InsertDate, Keywords, c.id as categoryId, c.category,visits,(select count(*) from newscomments where idnew=n.id and checked=1)";
if (isset($_GET['tag'])) {
    $url = explode("-", $_GET['tag']);
    $tag = $_GET['tag'];
    $news->where = "categoryId=" . $tag;
}
$news->pageno = $_GET['p'];
$news->rows_per_page = 5;
$data = $news->getInitialNews($where);
foreach ($data as $noticia) {
    if (!empty($noticia[3])) {
        if ($browser) {
            $out .="\n\t<div class=\"newFullImage\"><img src=\"http://www.futsal.cat/newsImages/$noticia[3]\" width=\"570\" alt=\"$noticia[1] - Federaci— Catalana de Futbol Sala\" /></div>";
        } else {
            $out .="\n\t<div style='position:relative; left:-10px; background-color:#fff; padding:3px; border:1px solid #ddd;z-index:1;'><a href='" . $serverUrl . "noticia/$noticia[0]-" . str_replace(" ", "-", treuAccents($noticia[1])) . "'><img  src=\"http://www.futsal.cat/newsImages/" . $noticia[3] . "\" width=\"592\"  alt=\"" . $noticia[1] . "\"  style='z-index:0;' ></a></div>";
            $out .="<div style='position:relative; left:-5px; height:10px; '><img src='" . $serverUrl . "webImages/newsImageShadow.png'></div>";
        }
    }
    $noticia[2] = str_replace("[img]", "</p><div align=center><div class='news_image'><img src='http://www.futsal.cat/newsImages/", $noticia[2]);
    $noticia[2] = str_replace("[/img]", "' alt='Futsal.cat' width=460/></div></div><p class=\"newFullText\">", $noticia[2]);
    // $out .="<div><img src=webImages/newsHeader.png></div>";
    $out .="\n\t<div class=\"newHeader\"><div class=\"newDate\" style='height:80px;'>" . dateformat($noticia[4]) . "</div>";

    /* $out .="\n\t<h2 class=\"newTitle\"><a href='?f=news_detail&amp;id=" . $noticia[0] . "&amp;title=" . urlencode($noticia[1]) . "'>" . stripslashes($noticia[1]) . "</a></h2>"; */

    $out .="\n\t<h2 class=\"newTitle\"> <a href='" . $serverUrl . "noticia/$noticia[0]-" . str_replace(" ", "-", treuAccents($noticia[1])) . "'>" . stripslashes($noticia[1]) . "</a></h2>";
    $out .="<a class='tags' href='" . $serverUrl . "categoria/" . $noticia[6] . "-" . str_replace(" ", "-", treuAccents($noticia[7])) . "'>" . $noticia[7] . "</a><br />";
    $l = strlen($noticia[8]);
    if ($l == 1) {
        $noticia[8] = "000" . $noticia[8];
    }
    if ($l == 2) {
        $noticia[8] = "00" . $noticia[8];
    }
    if ($l == 3) {
        $noticia[8] = "0" . $noticia[8];
    }
    $l = strlen($noticia[9]);
    if ($l == 1) {
        $noticia[9] = "000" . $noticia[9];
    }
    if ($l == 2) {
        $noticia[9] = "00" . $noticia[9];
    }
    if ($l == 3) {
        $noticia[9] = "0" . $noticia[9];
    }
    $out .="<div class='newsInfo'><span class='newsNum'>$noticia[8]</span>&nbsp;&nbsp;&nbsp; <strong>visites</strong></div>&nbsp;<div class='newsInfo'><span class='newsNum'>$noticia[9]</span>&nbsp;&nbsp;&nbsp; <strong><a href='" . $serverUrl . "noticia/$noticia[0]-" . str_replace(" ", "-", treuAccents($noticia[1])) . "#comments'>comentaris</a></strong></div>";
    $out .="</div>";


    $out .="<div class=\"newContainer\">";

    $salta = explode("[salta]", $noticia[2]);
    $text = $salta[0];
    if (!empty($salta[1])) {
        $link = "<br /><br /><a href='" . $serverUrl . "noticia/$noticia[0]-" . str_replace(" ", "-", treuAccents($noticia[1])) . "'><img src='http://www.futsal.cat/webImages/ReadMore.png'   alt=\"ReadMore\" /></a>";
    } else {
        $link = "";
    }

    $paragraf = "newFullText";



    $out .="\n\t<p class=\"$paragraf\" style='width:570px'>" . nl2br(stripslashes($text)) . " $link</p>";
    /* if (!empty($noticia[5])) {
      $w = " WHERE ";
      $palabras = explode(",", $noticia[5]);

      foreach ($palabras as $p) {
      $w .= ( $w == " WHERE ") ? " " : " and ";
      $w .= "content LIKE '%" . str_replace("'", "", $p) . "%'";
      }

      $q = "select id,title from news $w limit 0,10";
      //$out .="<h3>$q</h3>";
      $r = mysql_query($q);
      if (mysql_num_rows($r) > 1) {
      $out .="<img src='http://www.futsal.cat/webImages/relatedNews.png'> ";

      while ($row = mysql_fetch_array($r)) {
      if ($noticia[0] != $row['id']) {
      $out .="<a href='" . $serverUrl . "noticia/" . $row['id'] . "-" . str_replace(" ", "-", treuAccents($row['title'])) . "' style='font-size:10px; color:#3476fc;'>" . stripslashes($row['title']) . "</a> ";
      }
      }
      }
      } */
    $news->idNew = $noticia[0];
        $data2 = $news->getMatchInfoByIdNew();
        $n = 1;
        if (count($data2) > 100) {

            echo "<hr>";
            echo "<div style='padding:10px 5px; border:1px solid #ccc; background-color:#ddd;'>";
            foreach ($data2 as $players) {
                if ($team != $players[12]) {
                    if ($n > 1) {
                        echo "<br /><br />";
                    }

                    echo "<strong>" . $players[12] . "</strong>: ";
                }
                echo $players[10]." ";
                if ($players[15] > 0) {
                    echo "(" . $players[15] . " <img src=\"" . $server . "webImages/soccer.png\">)";
                }
                if ($players[16] > 0) {
                    echo "(" . $players[16] . " <img src=\"" . $server . "webImages/yellowcard.png\">)";
                }
                if ($players[17] > 0) {
                    echo "(" . $players[17] . " <img src=\"" . $server . "webImages/bluecard.png\">)";
                }
                echo ", ";
                $team = $players[12];
                $n++;
            }
            echo "</div>";
        }
    $out .="<br /><br /></div><div class=\"newSpacer\">&nbsp;</div>";
}
echo utf8_encode($out);
?>
