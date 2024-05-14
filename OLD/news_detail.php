<?
if (!isset($_GET['f'])) {
    header("Location: index.php?f=news_detail&id=" . $_GET['id']);
}
setlocale(LC_TIME, 'spanish');
?><div style="height:5px;" ></div>


<?
//include ("includes/db.inc");
//include("Classes/News_class.php");

if (!isset($_GET['id'])) {
    $url = explode("-", $_GET['title']);
    $id = $url[0];
} else {
    $id = $_GET['id'];
}
mysql_query("update news set visits=visits+1 where id=" . $id);
$news = new News;
$news->idNew = $id;
$news->tablename = "news n join newscategories c on n.categoryId=c.id";
$news->order = "id desc";
$news->fields = "n.Id,Title,Content,PathImage,InsertDate,c.id as categoryId, c.category,visits,(select count(*) from newscomments where idnew=n.id and checked=1)";
$news->pageno = $_GET['p'];
$news->rows_per_page = 3;
$data = $news->getNewById(" n.id=" . $id);
foreach ($data as $noticia) {

    echo "<div class=\"newHeader\">";
    echo "\n\t<div class=\"newDate\">" . dateformat($noticia[4]) . "</div>";
    echo "\n\t<h2 id='title' class=\"newTitle\">" . stripslashes($noticia[1]) . "</h2>";
    echo "<a class='tags' href='" . $serverUrl . "categoria/" . $noticia[5] . "-" . str_replace(" ", "-", treuAccents($noticia[6])) . "'>" . $noticia[6] . "</a><br />";
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
    $l = strlen($noticia[7]);
    if ($l == 1) {
        $noticia[7] = "000" . $noticia[7];
    }
    if ($l == 2) {
        $noticia[7] = "00" . $noticia[7];
    }
    if ($l == 3) {
        $noticia[7] = "0" . $noticia[7];
    }
    echo "<div class='newsInfo'><span class='newsNum'>$noticia[7]</span>&nbsp;&nbsp;&nbsp; <strong>visites</strong></div>&nbsp;<div class='newsInfo'><span class='newsNum'>$noticia[8]</span>&nbsp;&nbsp;&nbsp; <strong><a href='" . $serverUrl . "noticia/$noticia[0]-" . str_replace(" ", "-", treuAccents($noticia[1])) . "#comments'>comentaris</a></strong></div>";


    echo "</div>";
    if (!empty($noticia[3])) {
        echo "\n\t<div class=\"newFullImage\"><img src=\"http://www.futsal.cat/newsImages/$noticia[3]\" width=\"570\" alt=\"$noticia[1] - Federaci— Catalana de Futbol Sala\" /></div>";
    }
     $data2 = $news->getMatchInfoByIdNew();
        $n = 1;
        if (count($data2) > 0) {

            /* echo "<hr>";
              echo "<div style='padding:20px 15px; border:1px solid #ccc; background-color:#fafafa;'>";
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
              echo ". ";
              $team = $players[12];
              $n++;
              }
              echo "</div>";

             */
            echo "<div class='cupMatch' style='background-color:#fafafa; padding-top:20px;'> ";

            //hi ha cronica?

            echo "<div class='cupMatchResult'>";

            //equip assignat local

            echo "<div class='cupMatchLocal'><a href='" . $serverUrl . "equip/" . $data2[1][1] . "-" . teamUrlFormat($data2[1][2]) . "'>" . $data2[1][2] . "</div>";
            echo "<div class='cupMatchLocalImage'> <img src='http://www.futsal.cat/webImages/clubsImages/" . $data2[1][4] . "' width=40 /></div>";




            echo "<div class='cupMatchScore'>" . $data2[1][3] . "&nbsp; - &nbsp; " . $data2[1][7] . "</div>";



            echo "<div class='cupMatchVisitorImage'> <img src='http://www.futsal.cat/webImages/clubsImages/" . $data2[1][8] . "' width=40/></div>";
            echo "<div class='cupMatchVisitor'><a href='" . $serverUrl . "equip/" . $data2[1][5] . "-" . teamUrlFormat($data2[1][6]) . "'>" . $data2[1][6] . "</a></div>";
            echo "<div style='clear:both;'></div>";
            foreach ($data2 as $players) {
                if ($team != $players[12]) {
                    if ($n > 1) {
                        echo "</div>";
                        $ta= "text-align: left; border-left:1px solid #ddd; ";

                    }else{
                        $ta=" text-align:right; ";
                    }

                    echo "<div style='padding:5px;float:left;  font-size:12px;width:47%; $ta '> ";
                }
                echo $players[10] . " ";
                if ($players[15] > 0) {
                    echo "(" . $players[15] . " <img src=\"" . $server . "webImages/soccer.png\">) ";
                }
                if ($players[16] > 0) {
                    echo "(" . $players[16] . " <img src=\"" . $server . "webImages/yellowcard.png\">) ";
                }
                if ($players[17] > 0) {
                    echo "(" . $players[17] . " <img src=\"" . $server . "webImages/bluecard.png\">) ";
                }
                echo "<br />";
                $team = $players[12];
                $n++;
            }




            // echo $match[13] . ", " . $match[14] . " <br />Codi partit:" . $data2[1][0] . "</div>";

            echo "</div></div><div style='clear:both;'></div></div>";
            echo "<div style='clear:both;'></div>";
        }
    echo "<div  class=\"newContainer\">";
      $noticia[2]= strip_tags($noticia[2],"<img>,<b>,<strong>,<i>,<em>,<li>,<ul>,<iframe>,<a>");
     $noticia[2]=str_replace("width: 600px;","max-width: 580px;",$noticia[2]);
    $noticia[2] = str_replace("[img]", "</p><div align=center><div class='news_image'><img src='" . $serverUrl . "newsImages/", $noticia[2]);
    $noticia[2] = str_replace("[/img]", "' alt='Futsal.cat' width='460'/></div></div><p class=\"newFullText\">", $noticia[2]);
    $noticia[2] = str_replace("[salta]", " ", $noticia[2]);









    echo "\n\t<p id=\"text\" class=\"newFullText\">" . nl2br(stripslashes($noticia[2])) . "</p>";
    $sql2 = "select * from newsattachments na join news_attachments a on na.id=a.idattachment where a.idnew=" . $id;
    $res2 = mysql_query($sql2);
    if (mysql_num_rows($res2) > 0) {
        echo "<div class='attachmentsDiv'>";
        while ($atrow = mysql_fetch_array($res2)) {
            echo "<img src=\"$serverUrlattachment.png\" width=\"16\" alt=\"Adjunt\" /> <a href=\"download.php?file=newsAttachments/" . urlencode($atrow['FilePath']) . "\">" . $atrow['FilePath'] . "</a><br>";
        }
        echo "</div>";
    }

    echo "</div>";

    $news->tablename = "news_flickrImages";
    $news->order = "flickrId";
    $news->fields = "distinct flickrId,flickrPath,flickrPathThumb";
    $news->rows_per_page = 100;
    $data = $news->getFlickrImagesByIdNew("idNews=" . $id);
    $c = 0;
    if (count($data) > 0) {

        echo "<div style=\"background-color: #f0f0f0; border-top:1px solid #d0d0d0; padding:10px; \"><h3 style='padding:3px; margin:3px;'>Galería</h3>
 <table  border=0 cellspacing=\"20\"><tr>";

        foreach ($data as $image) {
            if (strlen($image[1]) < 1) {
                $rest = "http://flickr.com/services/rest/?method=flickr.photos.getSizes&api_key=9ad0d60ee22731d828426ae5d003452a&photo_id=" . $image[0];
                //echo "\n\t\t\t........".$rest;
                $xml = simplexml_load_file($rest);
                $total = count($xml->sizes->size);
                for ($a = 0; $a < $total; $a++) {
                    if ($xml->sizes->size[$a]['label'] == "Small") {
                        $thumbImage = $xml->sizes->size[$a]['source'];
                    }
                    if ($xml->sizes->size[$a]['label'] == "Large") {
                        $largeImage = $xml->sizes->size[$a]['source'];
                    }
                    if ($xml->sizes->size[$a]['label'] == "Original") {
                        $original = $xml->sizes->size[$a]['source'];
                    }
                    mysql_query("update news_flickrImages set flickrPath='$largeImage', flickrPathThumb='$thumbImage' where flickrId=" . $image[0]) or die(mysql_error());
                }
            } else {
                $largeImage = $image[1];
                $thumbImage = $image[2];
            }



            echo "\n\t<td align=left width=240><br><div style='cursor:pointer;' class='imgtable_div yoxview' target='yoxview' style='margin:10px;' >$ca <a href='" . $largeImage . "' /><img src='" . $thumbImage . "' /></a></div></td>";
            $c++;
            if ($c == 2) {
                echo "<!--$c-->\n</tr>\n<tr>";
                $c = 0;
            }
        }

//echo "<div style='clear:both;'></div>";
        echo "</tr></table></div>";
    }
?>
<?
    echo "
    <div class=\"newsButtonLine\" >";
    echo "<div id=\"newsShare\">";
    //echo "<h2 class=\"newsOptions\">Comparteix aquesta noticia</h2>";
    echo "<ul>";
    echo "<li><a href='" . $_SERVER['HTTP_REFERER'] . "'><img src=\"http://www.futsal.cat/webImages/back.png\" alt=\"Enrere\" title=\"Enrere\"  /></a></li>";
    echo "<li><a href='http://www.futsal.cat/print.php?id=" . $noticia[0] . "' ><img  alt='Imprimir' src='http://www.futsal.cat/webImages/print.png'  />  </a></li>&nbsp;";
    echo "<li onClick=\"newsOpenMailSend(" . $id . ");\"><img  alt='Enviar mail' src='http://www.futsal.cat/webImages/mail.png'  />  </a></li>&nbsp;<li>&nbsp;&nbsp;</li>";
    echo "<li><a href='http://www.facebook.com/share.php?u=http://www.futsal.cat/noticia/$noticia[0]-" . str_replace(" ", "-", treuAccents($noticia[1])) . "' ><img width=\"16\" alt='Facebook' src='http://www.futsal.cat/webImages/socialNetwork/facebook.png'  />  </a></li>";
    echo "<li><a href='http://twitter.com/home/?status=" . urlencode($noticia[1]) . " http://www.futsal.cat/noticia/$noticia[0]-" . str_replace(" ", "-", treuAccents($noticia[1])) . "'><img width=\"16\" alt='Twitter' src='http://www.futsal.cat/webImages/socialNetwork/twitter.png'  /></a></li>";
    echo "<li> <a  href='http://digg.com/submit?phase=2&amp;url=http://www.futsal.cat/noticia/$noticia[0]-" . str_replace(" ", "-", treuAccents($noticia[1])) . "&title=" . urlencode($noticia[1]) . "' ><img width=\"16\" alt='Digg'  src='http://www.futsal.cat/webImages/socialNetwork/digg.png'  /></a></li>";
    echo "<li><a  href='http://www.technorati.com/faves?add=http://www.futsal.cat/noticia/$noticia[0]-" . str_replace(" ", "-", treuAccents($noticia[1])) . "' ><img width=\"16\" alt='Technorati' src='http://www.futsal.cat/webImages/socialNetwork/technorati.png'  /></a></li>";
    echo "<li><a  href='http://del.icio.us/post?url=http://www.futsal.cat/noticia/$noticia[0]-" . str_replace(" ", "-", treuAccents($noticia[1])) . "' ><img alt='Del.icio.us' width=\"16\" src='http://www.futsal.cat/webImages/socialNetwork/delicious.png'  /></a></li>";
    echo "<li><a href='http://www.myspace.com/Modules/PostTo/Pages/?l=3&u=http://www.futsal.cat/noticia/$noticia[0]-" . str_replace(" ", "-", treuAccents($noticia[1])) . "' ><img alt='My Space' width=\"16\" src='http://www.futsal.cat/webImages/socialNetwork/myspace.png'  /></a></li>";


    /* echo "<li>&nbsp;</li>";
      echo "<li><img src='".$serverUrl."webImages/flags/uk.png' onClick='translate(\"en\")' height=16 ></li>";
      echo "<li><img src='".$serverUrl."webImages/flags/france.png' onClick='translate(\"fr\")' height=16></li>
      <li><img src='".$serverUrl."webImages/flags/deustch.png' onClick='translate(\"de\")' height=16></li>
      <li><img src='".$serverUrl."webImages/flags/spain.png' onClick='translate(\"es\")' height=16></li>
      <li><img src='".$serverUrl."webImages/flags/italia.png' onClick='translate(\"it\")' height=16></li>"; */
    echo "</ul>";


    echo "</div>";
    echo "<div id=\"newsVote\">";

    $avg = "SELECT avg(value ) as average, count(1) as number FROM news_votes where  idNew=" . $id;

    $avg_res = mysql_query($avg);
    $row_a = mysql_fetch_array($avg_res);

    global $a;
    $a = 1;
    //echo $avg ." ".$row_a['average']." ".$row_a['number'];
    for ($i = 0; $i < floor($row_a['average']); $i++) {
        $out .= "\n\t\t\t<span><img  onMouseOver='highlight_poll($a," . $id . ");'  id='star" . $a . "_" . $id . "' onclick='file_vote($a," . $id . ");'  align='absbottom' src=http://www.futsal.cat/webImages/star.png></span>\n";
        $a++;
    }

    $rest = 5 - $row_a['average'];

    $rest2 = $row_a['average'] - floor($row_a['average']);
    for ($i = 0; $i < $rest2; $i++) {
        $out .= "\n\t\t\t<span><img  onMouseOver='highlight_poll($a," . $id . ");'  id='star" . $a . "_" . $id . "' onclick='file_vote($a," . $id . ");'  align='absbottom' src=http://www.futsal.cat/webImages/half_star.png></span>\n";
        $a++;
    }

    if ($rest2 > 0) {
        $rest--;
    }
    for ($i = 0; $i < $rest; $i++) {
        $out .= "\n\t\t\t<span><img  onMouseOver='highlight_poll($a," . $id . ");'  id='star" . $a . "_" . $id . "' onclick='file_vote($a," . $id . ");'  align='absbottom' src=http://www.futsal.cat/webImages/star2.png></span>\n";
        $a++;
    }
    echo $out . " " . $row_a['number'] . " vots";

    //echo "</div>";
    echo "</div>";
    echo "</div>";

    $web = "http://www.futsal.cat" . $_SERVER['REQUEST_URI'];
    echo "<div style='padding:5px; margin:5px;'><a href=\"http://twitter.com/share\" class=\"twitter-share-button\" data-count=\"horizontal\" data-via=\"futsalcat\" data-lang=\"es\">Tweet</a><script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script></div>";
    //echo "<div style='padding:5px;'><iframe src=\"http://www.facebook.com/plugins/like.php?href=" . urlencode($web) . "&amp;layout=standard&amp;show_faces=true&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=100\" scrolling=\"no\" frameborder=\"0\" style=\"border:none; overflow:hidden; width:450px; height:100px;\" allowTransparency=\"true\"></iframe></div>";
    /* echo "<a name='comments'><h2>&nbsp;Comentaris</h2></a>";

      $news = new News;
      $news->tablename = "newscomments c join users u  on c.idUser=u.id";
      $news->order = "id desc";
      $news->fields = "c.id,c.comment,u.userName,u.avatar,c.datetime";

      $news->rows_per_page = 100;
      $data = $news->getCommentsByIdNew(" checked=1 and c.idNew=" . $id);
      foreach ($data as $comment) {
      if ($n == 1) {
      $color = "#f6f6f6";
      $n = 2;
      } else {
      $color = "";
      $n = 1;
      }
      setlocale(LC_TIME, 'spanish');
      $data = strftime('%d de %B de %Y %h', strtotime($comment[4]));

      echo "<div class='commentContainer' style='background-color:$color;'>";
      echo "<div class='commentAvatar'>$comment[2]<br />";
      if (!empty($comment[3])) {
      echo "<img src='" . $serverUrl . "users/avatars/$comment[3]' width=100>";
      } else {
      echo "<img src='" . $serverUrl . "users/avatars/anonim.jpg' width=100>";
      }

      echo "</div>";
      echo "<div class='commentText'><span class='commentDate'>" . $comment[4] . "</span><br /><br />" . nl2br($comment[1]) . "</div>";
      echo "</div>";
      echo "<div style='clear:both; border-bottom:1px solid #ddd; height:1px;'>&nbsp;</div>";
      } */

    /*  if (!$_COOKIE['userId']) {
      echo "<div class='commentsNotLogged'>» <a href='usuari/login'>Inicia sessió</a> o <a href='usuari/registre'>registra't</a> per a introduïr comentaris.</div>";
      } else {
      echo "<h2>&nbsp;Comenta</h2><div class='commentsTextArea'>";
      echo "<form action='commentInsert.php' enctype=\"multipart/form-data\" method=\"post\">";

      echo "<textarea name='commentText' style='width:580px; height:100px;'></textarea><p style='font-size:9px;width:580px;'>El teu comentari serà revisat abans de la seva publicació. No es permeten comentaris ofensius respecte a la Federació, als seus membres o als altres usuaris de la web. Gràcies per la teva comprensió.</p>";
      echo "<input type=\"hidden\" name=\"commentIdNew\" value=\"$id\">";
      echo "<input type=\"hidden\" name=\"commentIdUser\" value=\"" . $_COOKIE['userId'] . "\">";
      echo "<input type=\"submit\" name=\"commentSubmit\" value='Enviar'>";
      echo "</div>";
      } */
}
?>
<div style="padding:5px; margin:5px;">
    <div id="fb-root" ></div>
    <script src="http://connect.facebook.net/ca_ES/all.js#appId=167759963251783&amp;xfbml=1"></script>
    <meta property="fb:app_id" content="114828529581">
    <fb:comments numposts="10" width="580" publish_feed="true"></fb:comments>
</div>

<script type="text/javascript">
    $(document).ready(function(){
     
        $(".yoxview").yoxview();
        
    });
</script>
