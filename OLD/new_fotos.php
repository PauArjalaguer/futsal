<style>
    .imgtable_div
    {
        background-color: #ddd;
        float: left;

    }
    .imgtable_div img
    {
        background-color: #fff;
        border: 1px solid #a9a9a9;
        display: block;
        margin: -3px 3px 3px -3px;
        padding: 4px;
        position: relative;
    }

</style>
<div class="newHeader">
    <h1 id='sectionTitle'>
        <span style='color:#600;'>></span>
        <?
        if(!$_COOKIE['numberOfThumbs']){
        $numberOfThumbs = 6;

        }else{
            $numberOfThumbs=$_COOKIE['numberOfThumbs'];
        }
        //echo $numberOfThumbs;
        if ($_GET['photoset']) {
            $url = explode("-", $_GET['photoset']);
            $id = $url[0];

            $rest = "http://flickr.com/services/rest/?method=flickr.photosets.getInfo&api_key=9ad0d60ee22731d828426ae5d003452a&photoset_id=" . $id;
            $xml = simplexml_load_file($rest);
            echo utf8_decode($title = $xml->photoset->title);
        } else if ($_GET['tag']) {
            echo $_GET['tag'];
        } else {
            echo "Recull de fotografíes";
        }
        ?>
    </h1>
</div>
<div class="newContainer">
    <?
        /*
          $url = explode("-", $_GET['photoset']);
          $id = $url[0];
          $title = $url[1];
          if (!isset($_GET['photoset'])) {
          $sub_title = "<h2 class=\"newTitle\">Galeries</h2>";
          }
          if (isset($_GET['photoset'])) {
          $sub_title = "<h2 class=\"newTitle\">Galeria: '" . $title . "'</h2>";
          }
          if (isset($_GET['tag'])) {
          $sub_title = "<h2 class=\"newTitle\">Etiqueta: '" . $_GET['tag'] . "'</h2>";
          }

          echo "<span class='title_small'>$sub_title</span>"; */
    ?>
        <table  border=0 cellspacing="20">
            <tr>


            <?php
            if (!isset($_GET['photoset']) and !isset($_GET['tag'])) {

                $c = 0;
                $api_key = "0df858f7d07620ceb376242e418a08a9"; // get yours at http://flickr.com/services/api/key.gne
                $my_id = "42695980@N02"; // use idgetr (http://idgettr.com/) to find yours if you already changed it to a name
                $method = "http://flickr.com/services/rest/?method=flickr.photosets.getList&user_id=$my_id&api_key=$api_key";
                //echo $method;
                $xml = simplexml_load_file("http://flickr.com/services/rest/?method=flickr.photosets.getList&user_id=$my_id&api_key=$api_key");
                $total = count($xml->photosets->photoset);
                if (!$_GET['page'] or $_GET['page'] == 1) {
                    $p = 0;
                } else {
                    $p = ($_GET['page'] - 1) * $numberOfThumbs;
                }
                $t = $p + $numberOfThumbs;
                //echo $p;
                for ($i = $p; $i < $t and $i < $total; $i++) {
                    $photoset = $xml->photosets->photoset[$i]['id'];
                    $server = $xml->photosets->photoset[$i]['server'];
                    $primary = $xml->photosets->photoset[$i]['primary'];
                    $secret = $xml->photosets->photoset[$i]['secret'];
                    $images = $xml->photosets->photoset[$i]['photos'];
                    $title = utf8_decode($xml->photosets->photoset[$i]->title);

                    $img = "<img src=\"http://static.flickr.com/" . $server . "/" . $primary . "_" . $secret . "_m.jpg\" id=\"$primary\" alt=\"$title\" width=240 height=159  >";
                    echo "\n\t\t<td align=left valign=top width=240  >\n\t\t\t\n\t\t\t<div class='imgtable_div'><a href='" . $serverUrl . "imatges/photoset/" . $photoset . "-" . treuAccents($title) . "'>";
                    echo "$img</a>\n\t\t\t</div><div style='clear:both;'><h2 class=\"newTitle\" >$title<br />$images imatges</h2></div>\n\t\t</td>";
                    $c++;
                    if ($c == 2) {
                        echo "\n\t</tr>\n\t<tr>";
                        $c = 0;
                    }
                }

                echo "<tr><td>&nbsp;</td></tr><tr><td colspan=8><span class='title'><h2 class='newTitle'>Buscar per etiquetes</h2></span></td></tr><tr><td colspan=8>";
                $api_key = "0df858f7d07620ceb376242e418a08a9"; // get yours at http://flickr.com/services/api/key.gne
                $my_id = "42695980@N02"; // use idgetr (http://idgettr.com/) to find yours if you already changed it to a name

                $xml = simplexml_load_file("http://flickr.com/services/rest/?method=flickr.tags.getListUserPopular&user_id=$my_id&api_key=$api_key&count=100");
                $totalTags = count($xml->who->tags->tag);
                for ($i = 0; $i < $totalTags; $i++) {
                    if (!empty($xml->who->tags->tag[$i])) {
                        $title = utf8_decode($xml->who->tags->tag[$i]);
                        $count = $xml->who->tags->tag[$i]['count'];
                        $count = $count * 0.5;
                        if ($count < 7) {
                            $count = 7;
                        }
                        if ($count > 20) {
                            $count = 20;
                        }
                        echo "<a href=" . $serverUrl . "imatges/etiqueta/" . treuAccents($title) . "><span style='font-size:" . $count . "px;'>" . $title . " </span></a> ";
                    }
                }

                echo "</td></tr>";
            }

            if (isset($_GET['photoset'])) {
                $xml = simplexml_load_file("http://flickr.com/services/rest/?method=flickr.photosets.getPhotos&user_id=42695980@N02&api_key=9ad0d60ee22731d828426ae5d003452a&photoset_id=" . $_GET['photoset']);
//echo "http://flickr.com/services/rest/?method=flickr.photosets.getPhotos&user_id=42695980@N02&api_key=9ad0d60ee22731d828426ae5d003452a&photoset_id=".$_GET['photoset'];
                $total = count($xml->photoset->photo);
                if (!$_GET['page'] or $_GET['page'] == 1) {
                    $p = 0;
                } else {

                    $p = ($_GET['page'] - 1) * $numberOfThumbs;
                }

                $t = $p + $numberOfThumbs;

                for ($a = $p; $a < $t and $a < $total; $a++) {
                    if (!empty($xml->photoset->photo[$a]['id'])) {
                        $farm = "farm" . $xml->photoset->photo[$a]['farm'];
                        $id = $xml->photoset->photo[$a]['id'];
                        $secret = $xml->photoset->photo[$a]['secret'];
                        $server = $xml->photoset->photo[$a]['server'];
                        $p_title = $xml->photoset->photo[$a]['title'];
                        $img = "<img src=\"http://static.flickr.com/" . $server . "/" . $id . "_" . $secret . "_m.jpg\" alt='i' >";
                        $bigImg = "http://farm3.static.flickr.com/" . $server . "/" . $id . "_" . $secret . "_o.jpg ";
                        $big_url = str_replace("_s", "_o", $row['url']);
                        echo "<td align=left><br /><div style='cursor:pointer;' class='imgtable_div'><a href='" . $serverUrl . "imatge/$id-" . treuAccents(utf8_decode($p_title)) . "'>$img</a></div></td>";
                        $c++;
                        if ($c == 2) {
                            echo "</tr><tr>";
                            $c = 0;
                        }
                    }
                }
            }

            if (isset($_GET['tag'])) {
                $xml = simplexml_load_file("http://flickr.com/services/rest/?method=flickr.photos.search&tags=" . $_GET['tag'] . "&user_id=42695980@N02&api_key=0df858f7d07620ceb376242e418a08a9&per_page=1000");
                $total = count($xml->photos->photo);

                if (!$_GET['page'] or $_GET['page'] == 1) {
                    $p = 0;
                } else {

                    $p = ($_GET['page'] - 1) * $numberOfThumbs;
                }

                $t = $p + $numberOfThumbs;

                for ($a = $p; $a < $t and $a < $total; $a++) {

                    $farm = "farm" . $xml->photos->photo[$a]['farm'];
                    $id = $xml->photos->photo[$a]['id'];
                    $secret = $xml->photos->photo[$a]['secret'];
                    $server = $xml->photos->photo[$a]['server'];
                    $p_title = $xml->photos->photo[$a]['title'];
                    $bigImg = "http://static.flickr.com/" . $server . "/" . $id . "_" . $secret . "_b.jpg ";
                    //$img = "<img src=\"http://static.flickr.com/" . $server . "/" . $id . "_" . $secret . "_m.jpg\">";
                    $big_url = str_replace("_s", "_b", $row['url']);
                    echo "<td align=left width=240><br><div style='cursor:pointer;' class='imgtable_div' ><a href='" . $serverUrl . "imatge/$id-" . treuAccents(utf8_decode($p_title)) . "'>$img</a></div></td>";
                    $c++;
                    if ($c == 2) {
                        echo "</tr><tr>";
                        $c = 0;
                    }
                }
            }
            ?>
        </tr>
    </table>

</div>

<div>
    <div class="thumbsPerPage" style="wiadth:50%; float:left; margin-bottom: 20px;">
        Fotos per pàgina:
        <a href="fotosChangeThumbsNumber.php?n=4">4</a>
        <a href="fotosChangeThumbsNumber.php?n=8">8</a>
        <a href="fotosChangeThumbsNumber.php?n=12">12</a>
        <a href="fotosChangeThumbsNumber.php?n=<? echo $total; ?>">Totes</a>
    </div>
    <div class="newsPaginator"  style="wiadth:50%; float:left; margin-bottom: 10px;">

        <?
            //echo "-..." . $total . " " . $p;

            $numberOfPages = floor($total / $numberOfThumbs) + 1;

            if ($_GET['photoset']) {
                if (empty($_GET['page'])) {
                    $n = $serverUrl . "imatges/photoset/" . $_GET['photoset'];
                    $p = 1;
                } else {
                    $n = $serverUrl . "imatges/photoset/" . $_GET['photoset'];
                    $p = $_GET['page'];
                }
            } else if ($_GET['tag']) {
                if (empty($_GET['page'])) {
                    $n = $serverUrl . "imatges/etiqueta/" . $_GET['tag'];
                    $p = 1;
                } else {
                    $n = $serverUrl . "imatges/etiqueta/" . $_GET['tag'];
                    $p = $_GET['page'];
                }
            } else {
                if (empty($_GET['page'])) {
                    $n = $serverUrl . "imatges";
                    $p = 1;
                } else {
                    $n = $serverUrl . "imatges";
                    $p = $_GET['page'];
                }
            }




            if (floor($total) > 1) {


                if ($p <= 5) {
                    for ($i = 1; $i <= $numberOfPages; $i++) {
                        $class = "";
                        if ($i == $p) {
                            $class = 'actiu';
                        }
                        echo "<a class=\"$class\"   href=\"$n/$i\">$i</a> ";
                    }
                } else {
                    echo "<a class=\"$class\"   href=\"$n/1\"><<</a> ";
                    $lastPage = $p + 4;
                    if ($lastPage > floor(
                                    $numberOfPages)) {
                        $lastPage = floor(
                                        $numberOfPages);
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
        ?>

        <? echo "</div><div class='totalPages' style='margin-bottom:20px;margin-top:20px; font-weight:bold; color:#ddd; font-size:12px;'> $numberOfPages pagines</div></div>"; ?>


        <?
            if (isset($_GET['photoset']) or isset($_GET['tag'])) {
                echo "<div class=\"newsButtonLine\" ><a href='" . $serverUrl . "imatges'><img src=\"" . $serverUrl . "webImages/back.png\" alt=\"Enrere\" title=\"Enrere\" /> </a></div>";
            }
        ?>

