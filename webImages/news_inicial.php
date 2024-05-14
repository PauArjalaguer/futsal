<div id="newsContainer">
    <?php
    if (preg_match("/MSIE 7.0/", $_SERVER['HTTP_USER_AGENT'])) {
        $browser = 'ie7';
    }
    $news = new News;
    $news->tablename = "news n join newscategories c on n.categoryId=c.id";
    $news->order = "updatedate desc, id desc";
    $news->fields = "n.Id,Title,Content,PathImage,InsertDate, Keywords, c.id as categoryId, c.category,visits,(select count(*) from newscomments where idnew=n.id and checked=1)";
    if (isset($_GET['tag'])) {
        $url = explode("-", $_GET['tag']);
        $tag = $url[0];
        $news->where = "categoryId=" . $tag;
    }
    $news->pageno = $_GET['p'];
    $news->rows_per_page = 5;
    $data = $news->getInitialNews($where);
    foreach ($data as $noticia) {
        if (!empty($noticia[3])) {
            if ($browser) {
                echo "\n\t<div class=\"newFullImage\"><img src=\"http://www.futsal.cat/newsImages/$noticia[3]\" width=\"570\" alt=\"$noticia[1] - Federaci— Catalana de Futbol Sala\" /></div>";
            } else {
                echo "\n\t<div style='position:relative; left:-10px; background-color:#fff; padding:3px; border:1px solid #ddd;z-index:1;'><a href='" . $serverUrl . "noticia/$noticia[0]-" . str_replace(" ", "-", treuAccents($noticia[1])) . "'><img  src=\"http://www.futsal.cat/newsImages/" . $noticia[3] . "\" width=\"592\"  alt=\"" . $noticia[1] . "\"  style='z-index:0;' ></a></div>";
                echo "<div style='position:relative; left:-5px; height:10px; '><img src='" . $serverUrl . "webImages/newsImageShadow.png'></div>";
            }
        }
        $noticia[2] = str_replace("[img]", "</p><div align=center><div class='news_image'><img src='http://www.futsal.cat/newsImages/", $noticia[2]);
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


        echo "<div class=\"newContainer\">";

        $salta = explode("[salta]", $noticia[2]);
        $text = $salta[0];
        if (!empty($salta[1])) {
            $link = "<br /><br /><a href='" . $serverUrl . "noticia/$noticia[0]-" . str_replace(" ", "-", treuAccents($noticia[1])) . "'><img src='http://www.futsal.cat/webImages/ReadMore.png'   alt=\"ReadMore\" /></a>";
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
          echo "<img src='http://www.futsal.cat/webImages/relatedNews.png'> ";

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
    echo "<div style='width:90%; background-color:#fdd; border:1px solid #966; margin:auto; margin-bottom:40px; float:none; padding:5px 0; display:none; text-align:center; color:#633;' id=\"infiniteScrollLoader\"><img src='http://ww.futsal.cat/webImages/ajax-loader.gif' /></div>";

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
                echo "<a class=\"$class\"   href=\"$n/$i\">$i</a> ";
            }
        } else {
            echo "<a class=\"$class\"   href=\"$n/1\"><<</a> ";
            $lastPage = $p + 4;
            if ($lastPage > floor($pages)) {
                $lastPage = floor($pages);
            }

            for ($i = $p - 4; $i <= $lastPage; $i++) {
                $class = "";
                if ($i == $p) {
                    $class = 'actiu';
                }
                echo "<a class=\"$class\"   href=\"$n/$i\">$i</a> ";
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
      
        var scrollPosition;
        function scroll(){
            var pageHeight = document.height;
            document.getElementById("contador").innerHTML="";
            if(navigator.appName == "Microsoft Internet Explorer"){
                scrollPosition = document.documentElement.scrollTop;
            }else{
                scrollPosition = window.pageYOffset;
            }
            if((pageHeight - scrollPosition) < 1000){
                document.getElementById("infiniteScrollLoader").style.display="block";
        
                newsLoadMore();

            }
            var p= pageHeight+" "+scrollPosition;
            //document.getElementById("contador").innerHTML=p;
   
       
        }
        var page=<? if($_GET['p']){echo $_GET['p'];}else{echo "1";} ?>;
        function newsLoadMore(){
            if(page<=10){
                page++;
           
                ajax = nuevoAjax();
                ajax.open("GET","news_inicialLoadMore.php?p="+page, true);
                ajax.onreadystatechange = function() {
                    if (ajax.readyState == 4) {
                        document.getElementById("newsContainer").innerHTML += ajax.responseText;
                        document.getElementById("infiniteScrollLoader").style.display="none";
                    }
                }
                ajax.send(null)
            }
        }
        setInterval('scroll()', 1000);
    </script>