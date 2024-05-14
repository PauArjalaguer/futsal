<div class="newHeader">
    <h1 id='sectionTitle'><span style='color:#600;'>></span> Agenda</h1>
</div>
<div class="Container">
    <?
//echo "---".$_GET['day']."-----";
    $calendar = new Calendar;
    $calendar->tablename = "calendar";
    $calendar->order = "datetime asc";
    $calendar->fields = "Id,Name,Description,Datetime,Lloc, complexName, complexAddress join  ";
    $calendar->pageno = $_GET['p'];
    $calendar->rows_per_page = 10;
    if (!isset($_GET['day'])) {
        $date_where = " datetime>='" . date("Ymd") . "'";
    } else {
        $d = explode("-", $_GET['day']);
        $date_where = " dayofmonth(datetime)=" . $d[0] . " and month(datetime)=" . $d[1] . " and year(datetime)=" . $d[2];
    }
    $data = $calendar->getAllActs($date_where);
    foreach ($data as $act) {
        echo "\n\t<h2 class=\"newTitle\">" . $act[1] . "</h2>";
        echo "\n\t<h3 class=\"newDate\">" . dateformat($act[3]) . "</h3>";
        echo "\n\t<p class=\"newFullText\">" . nl2br($act[2]) . " </p><p style='clear:both;'></p>";
        $address=$act[4].$act[6];
        if (!empty($address)) {

            $xml = simplexml_load_file("http://maps.google.com/maps/geo?q=" .$address . "&output=xml&sensor=false&key=ABQIAAAADKIrSO8QhdePb69IgQyNhRTAhSjkIBiGptVx9X9HprP3Oe5yPBS9Rp5ikn1ivqG2JoW8Gnyd-1jQAw");

            $coor = $xml->Response->Placemark->Point->coordinates;

            //echo $coor;
            $c = explode(",", $coor);

            echo "<div align=center style=''><div  id=\"map_canvas" . $act[0] . "\" style=\"width: 500px; height: 300px; margin-bottom:10px;padding:3px; border:1px solid #ddd;\"></div></div>";
            echo "\n\n<script src=\"http://maps.google.com/maps?file=api&v=2&key=ABQIAAAADKIrSO8QhdePb69IgQyNhRTAhSjkIBiGptVx9X9HprP3Oe5yPBS9Rp5ikn1ivqG2JoW8Gnyd-1jQAw&sensor=false\"
        type=\"text/javascript\"  charset=\"utf-8\"></script>
		\n<script type='text/javascript'>
		\t var map" . $act[0] . " = new GMap2(document.getElementById(\"map_canvas" . $act[0] . "\"));
				
		\t var point" . $act[0] . " = new GLatLng(" . $c[1] . "," . $c[0] . ");
		\t map" . $act[0] . ".addOverlay(new GMarker(point" . $act[0] . "));
		
		\t var mapControl" . $act[0] . " = new GMapTypeControl();
		\t map" . $act[0] . ".addControl(mapControl" . $act[0] . ");
		\t map" . $act[0] . ".addControl(new GLargeMapControl());
		
		\t map" . $act[0] . ".setCenter(new GLatLng(" . $c[1] . "," . $c[0] . "), 17);
		
		\n</script>\n\n";
        }echo "<div class=\"newSpacer\">&nbsp;</div>";
    }

    echo "<div align=\"center\"><div class=\"newsPaginator\">";
    if (!isset($_GET['day'])) {
        $pages = $calendar->buildPaginator();

        $p = 1;
    } else {
        $p = $_GET['p'];
    }
    if (empty($_GET['p'])) {
        $n = $serverUrl . "calendari";
        $p = 1;
    } else {
        $n = $serverUrl . "calendari";
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
    echo "</div>";
    echo "<div class='totalPages' style='margin-top:20px; font-weight:bold; color:#ddd; font-size:12px;'>$pages pagines</div></div>";
    ?>
</div>
