<div class="newHeader">
    <h1 id="sectionTitle"><span style='color:#600;'>></span> Clubs
    </h1>
</div>


<div class="Container"><br /><br />
    <?
    echo "<div class='clubsListName titleList' style='font-size:16px;'>Club</a><!-- ($club[2] equips)--></div>";
    echo "<div class='clubsListCity titleList' style='font-size:16px;'>Ciutat </div>";
    echo "<div class='clubsListInfo zebra$n'>&nbsp;</div>";
    include("Classes/Teams_class.php");
    $clubs = new Teams;
    $clubs->pageno = $_GET['p'];
    $clubs->orderby = "order by name asc";
    $clubs->rows_per_page = 500;
    $where = "isHidden=0";
    $data = $clubs->clubsGetList($where);
    foreach ($data as $club) {
        if ($n == 2) {
            $n = 1;
        } else {
            $n = 2;
        }
        if (empty($club[4])) {
            $club[4] = "genericClub.png";
        }
        if (!empty($club[5])) {
            $facebook = "<a href='" . $club[5] . "' target=_blank><img src='http://www.futsal.cat/webImages/socialNetwork/facebook.png'></a>";
        }
        if (!empty($club[6])) {
            $twitter = "<a href='https://twitter.com/" . $club[6] . "' target=_blank><img src='http://www.futsal.cat/webImages/socialNetwork/twitter.png'></a>";
        }
        echo "<div class='zebra$n' style='width:70px; float:left;height:60px;  padding:10px 10px; padding-bottom:0; vertical-align:middle;'><a href=\"" . $serverUrl . "club/$club[0]-" . teamUrlFormat($club[1]) . "\"><img src='http://www.futsal.cat/webImages/clubsImages/" . $club[4] . "' width=40 height=40></a></div>";
        echo "<div class='zebra$n' style='width:400px; float:left;height:60px; padding:10px; padding-bottom:0;'><span style='font-size:20px;'><a href=\"" . $serverUrl . "club/$club[0]-" . teamUrlFormat($club[1]) . "\">$club[1]</a>&nbsp;</span><br /><span style='color:#828282;'>" . ucwords(strtolower($club[3])) . "</span><!-- ($club[2] equips)--></div>";
        echo "<div class='zebra$n' style='width:50px; float:left;height:60px; padding:10px; padding-bottom:0;'><span style='font-size:20px;'>$facebook $twitter</div><div style='clear:both;'></div>";
        $facebook = "";
        $twitter = "";
    }
    $pages = $clubs->buildPaginator();
    echo "<div style='margin-top:30px;clear:both;'><div class=\"newsPaginator\">";



    if (empty($_GET['p'])) {
        $n = $serverUrl . "clubs";
        $p = 1;
    } else {
        $n = $serverUrl . "clubs";
        $p = $_GET['p'];
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


    echo "</div><!--<div class='totalPages' style='margin-top:20px; font-weight:bold; color:#ddd; font-size:12px;'>$pages pagines</div>--></div>";
    ?>

</div>