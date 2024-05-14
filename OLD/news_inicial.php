<div id="newsContainer">
    <?php
    if (preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT'])) {
        $browser = 'ie7';
    }
    $news = new News;
    $news->tablename = "news n join newscategories c on n.categoryId=c.id";
    $news->order = "pinned desc,updatedate desc, id desc";
    $news->fields = "n.Id,Title,Content,PathImage,InsertDate, Keywords, c.id as categoryId, c.category,visits,(select count(*) from newscomments where idnew=n.id and checked=1)";
    if (isset($_GET['tag'])) {
        $url = explode("-", $_GET['tag']);
        $tag = $url[0];
        $news->where = "categoryId=" . $tag;
        
    }
    $news->pageno = $_GET['p'];
    $news->rows_per_page = 4;
    $data = $news->getInitialNews($where);
    foreach ($data as $noticia) {
        if (!empty($noticia[3])) {
            if ($browser) {
                echo "\n\t<div class=\"newFullImage\"><img src=\"http://historic.futsal.cat/newsImages/$noticia[3]\" width=\"570\"  alt=\"$noticia[1] - Federaci� Catalana de Futbol Sala\" /></div>";
            } else {
                echo "\n\t<div style='position:relative; left:-10px; background-color:#fff; padding:3px; border:1px solid #ddd;z-index:1;'><a href='" . $serverUrl . "noticia/$noticia[0]-" . str_replace(" ", "-", treuAccents($noticia[1])) . "'><img  src=\"http://historic.futsal.cat/newsImages/" . $noticia[3] . "\" width=\"592\"  alt=\"" . $noticia[1] . "\"  style='z-index:0;' ></a></div>";
                echo "<div style='position:relative; left:-5px; height:10px; '><img src='http://historic.futsal.cat/webImages/newsImageShadow.png'></div>";
            }
        }
         $noticia[2]= strip_tags($noticia[2],"<img>,<b>,<strong>,<i>,<em>,<li>,<ul>,<iframe>,<a>");
        $noticia[2] = str_replace("[img]", "</p><div align=center><div class='news_image'><img src='" . $serverUrl . "newsImages/", $noticia[2]);
        $noticia[2] = str_replace("[/img]", "' alt='Futsal.cat' width=460/></div></div><p class=\"newFullText\">", $noticia[2]);
        // echo "<div><img src=webImages/newsHeader.png></div>";
        echo "\n\t<div class=\"newHeader\"><div class=\"newDate\" style='height:80px;'>" . dateformat($noticia[4]) . "</div>";

        /* echo "\n\t<h2 class=\"newTitle\"><a href='?f=news_detail&amp;id=" . $noticia[0] . "&amp;title=" . urlencode($noticia[1]) . "'>" . stripslashes($noticia[1]) . "</a></h2>"; */

        echo "\n\t<h2 class=\"newTitle\"><a href='" . $serverUrl . "noticia/$noticia[0]-" . str_replace(" ", "-", treuAccents($noticia[1])) . "'>" . stripslashes($noticia[1]) . "</a></h2>";
        echo "<a class='tags' href='" . $serverUrl . "categoria/" . $noticia[6] . "-" . str_replace(" ", "-", treuAccents($noticia[7])) . "'>" . $noticia[7] . "</a><br />";
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
        echo "<div class='newsInfo'><span class='newsNum'>$noticia[8]</span>&nbsp;&nbsp;&nbsp; <strong>visites</strong></div>&nbsp;<div class='newsInfo'><span class='newsNum'>$noticia[9]</span>&nbsp;&nbsp;&nbsp; <strong><a href='" . $serverUrl . "noticia/$noticia[0]-" . str_replace(" ", "-", treuAccents($noticia[1])) . "#comments'>comentaris</a></strong></div>";
        echo "</div>";

        $news->idNew = $noticia[0];
        $data2 = $news->getMatchInfoByIdNew();
        $n = 1;
        if($browser){
            $num=1000;
        }else{
            $num=0;
        }
        if (count($data2) > $num) {

            
            echo "<div class='cupMatch' style='background-color:#fff; padding-top:20px;background: #eeeeee; /* Old browsers */
background: -moz-linear-gradient(-45deg,  #eeeeee 1%, #efefef 16%, #ffffff 33%, #ffffff 61%, #efefef 71%, #ffeeee 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, right bottom, color-stop(1%,#eeeeee), color-stop(16%,#efefef), color-stop(33%,#ffffff), color-stop(61%,#ffffff), color-stop(71%,#efefef), color-stop(100%,#ffeeee)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(-45deg,  #eeeeee 1%,#efefef 16%,#ffffff 33%,#ffffff 61%,#efefef 71%,#ffeeee 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(-45deg,  #eeeeee 1%,#efefef 16%,#ffffff 33%,#ffffff 61%,#efefef 71%,#ffeeee 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(-45deg,  #eeeeee 1%,#efefef 16%,#ffffff 33%,#ffffff 61%,#efefef 71%,#ffeeee 100%); /* IE10+ */
background: linear-gradient(135deg,  #eeeeee 1%,#efefef 16%,#ffffff 33%,#ffffff 61%,#efefef 71%,#ffeeee 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eeeeee', endColorstr='#ffeeee',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
'> ";

            //hi ha cronica?

            echo "<div class='cupMatchResult'>";

            //equip assignat local

            echo "<div class='cupMatchLocal'><a href='" . $serverUrl . "equip/" . $data2[1][1] . "-" . teamUrlFormat($data2[1][2]) . "'>" . $data2[1][2] . "</div>";
            echo "<div class='cupMatchLocalImage'> <img src='http://historic.futsal.cat/webImages/clubsImages/" . $data2[1][4] . "' width=40 /></div>";




            echo "<div class='cupMatchScore'>" . $data2[1][3] . "&nbsp; - &nbsp; " . $data2[1][7] . "</div>";



            echo "<div class='cupMatchVisitorImage'> <img src='http://historic.futsal.cat/webImages/clubsImages/" . $data2[1][8] . "' width=40/></div>";
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
        echo "<div class=\"newContainer\">";

        $salta = explode("[salta]", $noticia[2]);
        $text = $salta[0];
        if (!empty($salta[1])) {
            $link = "<br /><br /><a href='" . $serverUrl . "noticia/$noticia[0]-" . str_replace(" ", "-", treuAccents($noticia[1])) . "'><img src='http://historic.futsal.cat/webImages/ReadMore.png'   alt=\"ReadMore\" /></a>";
        } else {
            $link = "";
        }

        $paragraf = "newFullText";



        echo "\n\t<p class=\"$paragraf\" style='width:570px'>" . nl2br(stripslashes($text)) . " $link</p>";
        /* if (!empty($noticia[5])) {
          $w = " WHERE ";
          $palabras = explode(",", $noticia[5]);

          foreach ($palabras as $p) {
          $w .= ( $w == " WHERE ") ? " " : " and ";
          $w .= "content LIKE '%" . str_replace("'", "", $p) . "%'";
          }

          $q = "select id,title from news $w limit 0,10";
          //echo "<h3>$q</h3>";
          $r = mysql_query($q);
          if (mysql_num_rows($r) > 1) {
          echo "<img src='http://historic.futsal.cat/webImages/relatedNews.png'> ";

          while ($row = mysql_fetch_array($r)) {
          if ($noticia[0] != $row['id']) {
          echo "<a href='" . $serverUrl . "noticia/" . $row['id'] . "-" . str_replace(" ", "-", treuAccents($row['title'])) . "' style='font-size:10px; color:#3476fc;'>" . stripslashes($row['title']) . "</a> ";
          }
          }
          }
          } */


        echo "<br /><br /></div><div class=\"newSpacer\">&nbsp;</div>";
    }
    echo "</div>";
    echo "<div style='width:90%; background-color:#fdd; border:1px solid #966; margin:auto; margin-bottom:40px; float:none; padding:5px 0; display:none; text-align:center; color:#633;' id=\"infiniteScrollLoader\">Carregant m�s not�cies...<br /><img src='http://ww.futsal.cat/webImages/ajax-loader.gif' /></div>";

    $numberOfPages = $news->buildPaginator();
    echo "<div><div class=\"newsPaginator\">";

    $pages = $news->buildPaginator();

    if (empty($_GET['p'])) {
        $n = $serverUrl . "noticies";
        $p = 1;
    } else {
        $n = $serverUrl . "noticies";
        $p = $_GET['p'];
    }
    if ($_GET['tag']) {
        $n = $serverUrl . "categoria/" . $_GET['tag'];
    }
    if ($pages > 10) {
        $linksPerPage = 10;
    } else {
        $linksPerPage = $pages;
    }

    if (floor($pages) > 1) {


        if ($p <= 5) {
            for ($i = 1; $i <= $linksPerPage; $i++) {
                $class = "";
                if ($i == $p) {
                    $class = 'actiu';
                }
                echo "\n<a class=\"$class\"   href=\"$n/$i\" id='page_$i'>$i</a> ";
            }
        } else {
            echo "\n<a class=\"$class\"   href=\"$n/1\" id='page_$i'><<</a> ";
            $lastPage = $p + 4;
            if ($lastPage > floor($pages)) {
                $lastPage = floor($pages);
            }

            for ($i = $p - 4; $i <= $lastPage; $i++) {
                $class = "";
                if ($i == $p) {
                    $class = 'actiu';
                }
                echo "\n<a class=\"$class\"   href=\"$n/$i\" id='page_$i'>$i</a>";
            }
        }
    }


    /* if (floor($pages) > 1) {
      for ($i = 1; $i <= floor($pages) ; $i++) {
      $class = "";
      if ($i == $p) {
      $class = 'actiu';
      }
      echo "<a class=\"$class\"   href=\"$n/$i\">$i</a> ";
      }
      } */

    echo "</div><div class='totalPages' style='margin-top:20px; font-weight:bold; color:#ddd; font-size:12px;'>$pages pagines</div></div>";
    ?>

    <script type="text/javascript">
        var initial=1;

        var scrollPosition;

        function getDocHeight() {
            var D = document;
            return Math.max(
            Math.max(D.body.scrollHeight, D.documentElement.scrollHeight),
            Math.max(D.body.offsetHeight, D.documentElement.offsetHeight),
            Math.max(D.body.clientHeight, D.documentElement.clientHeight)
        );
        }
        var num=1;
        function scroll(){
            num++;
            var pageHeight = getDocHeight();
            document.getElementById("contador").innerHTML="";
            if(navigator.appName == "Microsoft Internet Explorer"){
                scrollPosition = document.documentElement.scrollTop;
            }else{
                scrollPosition = window.pageYOffset;
            }
            if((pageHeight - scrollPosition) < 1500){
                document.getElementById("infiniteScrollLoader").style.display="block";

                newsLoadMore(<? echo $tag; ?>);

            }
            var p= pageHeight+" "+scrollPosition;
            // document.getElementById("contador").innerHTML=num+" "+p;


        }
        var page=<?
    if ($_GET['p']) {
        echo $_GET['p'];
    } else {
        echo "1";
    }
    ?>;
        function newsLoadMore(tag){
            clearInterval(interval);
            if(page<=10){
                //


                page++;
if(tag){
    var t="&tag="+tag;
}
                ajax = nuevoAjax();
                ajax.open("GET","news_inicialLoadMore.php?p="+page+t, true);
                ajax.onreadystatechange = function() {
                    if (ajax.readyState == 4) {
                        var time= setTimeout(function(){document.getElementById("page_"+(page-1)).className="";document.getElementById("page_"+page).className="actiu";document.getElementById("newsContainer").innerHTML += ajax.responseText;document.getElementById("infiniteScrollLoader").style.display="none";interval= setInterval('scroll()', 1000);},2000);

                    }
                }
                ajax.send(null)
            }
        }

<?
    if (!$_GET['p']) {
       // echo "var interval= setInterval('scroll()', 1000);";
    }
?>
       
    </script>