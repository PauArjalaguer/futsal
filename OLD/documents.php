<div class="newHeader">
    <h1 id="sectionTitle"><span style='color:#600;'>></span>
        <?
        $url = explode("-", $_GET['title']);
        $id = $url[0];
        $sql = "select  title,orderBy from downloadcategories where id=" . $id;
        $res = mysql_query($sql);
        $row = mysql_fetch_array($res);
        echo $row['title'];
        ?>
    </h1></div>

<div class="Container"><br /><br />
    <?
        //echo $row['order'] . "...";
        $numberofnews = 20;
        if (isset($_GET['p']) and ($_GET['p'] != 1)) {
            $p = $_GET['p'] - 1;
            $limit = "" . ($p * $numberofnews) . ",$numberofnews";
        } else {
            $limit = $numberofnews;
            $_GET['p'] = 1;
        }

        $sql = "select  * from documents where category=" . $id . " order by fileName " . $row['orderBy'] . " limit $limit";
        //echo $sql;
        $res = mysql_query($sql);
        while ($row = mysql_fetch_array($res)) {

            echo "\n\t<h2 class=\"newTitle\"><img src='http://www.futsal.cat/webImages/attach.png' align=absbottom> <a href='documentacio/" . urlencode($row['filepath']) . "'>" . $row['fileName'] . "</a></h2><br />";

            //echo "<div class=\"newSpacer\">&nbsp;</div>";
        }
        $total = mysql_num_rows(mysql_query("SELECT id FROM documents where category=" . $id));
        echo "<div style='margin-top:20px;' align=center><div class=\"newsPaginator\">";

        $pages = ($total / $numberofnews) + 1;
//echo "Pàgina ".$_GET['p']. " de ".floor($pages)." | " ;
//echo "<a href=?f=documents&id=".$_GET['id']."&p=1><<</a> ";
        if (empty($_GET['p'])) {
            $p = 1;
        } else {
            $p = $_GET['p'];
        }
        if (floor($pages) > 1) {
            for ($i = 1; $i < $pages; $i++) {
                if ($i == $p) {
                    $class = 'actiu';
                }
                echo "<a class='$class'   href='" . $serverUrl . "documents/" . $_GET['title'] . "/$i'>$i</a> ";
            }
            //echo "<a  href=?f=documents&id=".$_GET['id']."&p=".floor($pages).">>></a>";
        }
        echo "</div></div>";
        echo "<div style='clear:both; margin-bottom:20px;'></div>";
    ?>

    </div>
    <div class="newsButtonLine" ><a href='<? echo $_SERVER['HTTP_REFERER']; ?>'><img src="http://www.futsal.cat/webImages/back.png" alt="Enrere" title="Enrere"  /></a></div>


