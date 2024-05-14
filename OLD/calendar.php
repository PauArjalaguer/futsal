<!--<script type="text/javascript">
$(document).ready(function(){
$(".calendarTd").wTooltip({follow:false})

});
</script>-->
<style>
    .tooltip {
        
        border-bottom: 1px dotted #000000;
        color: #000000; outline: none;
        cursor: help;
        text-decoration: none;
        position: relative;
    }
    .tooltip span {

        margin-left: -999em;
        position: absolute;
        border-radius: 5px 5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.1);
        -webkit-box-shadow: 3px 3px rgba(0, 0, 0, 0.1);
        -moz-box-shadow: 3px 3px rgba(0, 0, 0, 0.1);
    }
    .tooltip:hover span {
        font-family: Calibri, Tahoma, Geneva, sans-serif;
        position: absolute;
        left: 1em;
        top: 0em;
        z-index: 99;
        margin-left: 0;
        width: 250px;
        text-align: left;
        left:-270px;
        top:10px;

    }
    .tooltip:hover img {
        border: 0;
        margin: -10px 0 0 -55px;
        float: left;
        position: absolute;
    }
    .tooltip:hover em {
        font-family: Candara, Tahoma, Geneva, sans-serif;
        font-size: 1.2em;
        font-weight: bold;
        display: block;
        padding: 0.2em 0 0.6em 0;
    }
    .classic { padding: 0.8em 1em; }
    .classic { background: #c90211; border: 1px solid #B0010d; }
    .custom { padding: 0.5em 0.8em 0.8em 2em; }
    * html a:hover { background: transparent; }</style>
    <?php
    if (isset($_GET['month'])) {
        include ("includes/config.php");
        include ("includes/funciones.php");
        conectar();
    }
    $loc = setlocale(LC_TIME, 'ca_ES', 'ca', 'es');


    $date = time();

//This puts the day, month, and year in seperate variables
    $day = date('d', $date);
    if (!isset($_GET['month'])) {
        $month = abs(date('m', $date));
        $year = date('Y', $date);
    } else {

        $month = $_GET['month'];
        $year = $_GET['year'];
    }
    $title = ucwords(strftime("%B", strtotime("$month/01/$year")));

//Here we generate the first day of the month

    $first_day = mktime(0, 0, 0, $month, 1, $year);



//This gets us the month name
//$title = strftime(date('F', $first_day));
//Here we find out what day of the week the first day of the month falls on
    $day_of_week = date('D', $first_day);

//Once we know what day of the week it falls on, we know how many blank days occure before it. If the first day of the week is a Sunday then it would be zero
    switch ($day_of_week) {
        case "Mon":
            $blank = 0;
            break;
        case "Tue":
            $blank = 1;
            break;
        case "Wed":
            $blank = 2;
            break;
        case "Thu":
            $blank = 3;
            break;
        case "Fri":
            $blank = 4;
            break;
        case "Sat":
            $blank = 5;
            break;
        case "Sun":
            $blank = 6;
            break;
    }


//We then determine how many days are in the current month
    $days_in_month = cal_days_in_month(0, $month, $year);
    if ($month == 12) {
        $nextMonth = 1;
        $nextYear = $year + 1;
        $previousMonth = $month - 1;
        $previousYear = $year - 1;
    } else if ($month == 1 or $month == "01") {
        $nextMonth = $month + 1;
        $nextYear = $year;
        $previousMonth = 12;
        $previousYear = $year - 1;
    } else {
        $nextMonth = $month + 1;
        $nextYear = $year;
        $previousMonth = $month - 1;
        $previousYear = $year;
    }



//Here we start building the table heads
    $out .= "<table border=\"0\" cellspacing=1 style='font-size:12px;' >";
    $out .= "<tr><th colspan=\"7\" align=\"center\"> <img class='button' onclick='calendarChangeMonth($previousMonth,$previousYear);' src='" . $serverUrl . "webImages/previous.png'> $title $year <img class='button' onclick='calendarChangeMonth($nextMonth,$nextYear);' src='" . $serverUrl . "webImages/next.png'></th></tr>";
    $out .= "<tr><td style=\"width:41px;\">Dil</td><td style=\"width:41px;\">Di</td><td style=\"width:41px;\">Dim</td><td style=\"width:41px;\">Dij</td><td style=\"width:41px;\">Div</td><td style=\"width:41px;\">Dis</td><td style=\"width:41px;\">Diu</td></tr>";

//This counts the days in the week, up to 7
    $day_count = 1;

    $out .= "<tr>";
//first we take care of those blank days
    while ($blank > 0) {
        $out .= "<td style='border:0px solid #ddd;'></td>";
        $blank = $blank - 1;
        $day_count++;
    }

//sets the first day of the month to 1
    $day_num = 1;

//count up the days, untill we've done all of them in the month
    while ($day_num <= $days_in_month) {
        //$style = "style='border:1px solid #ddd;'";
        $style = " class='calendarWhite' ";
        $title = "";
        $href = "";
        $onmouseover = "";
        $class = "";
        $today = "";
        $res = mysql_query("select * from calendar where dayofmonth(datetime)=$day_num and month(datetime)=$month and year(datetime)=$year order by datetime");
        if (mysql_num_rows($res) > 0) {
            $title = "";
            while ($row = mysql_fetch_array($res)) {
                $d = explode(" ", $row['datetime']);
                $hour = substr($d[1], 0, 5);
                if ($hour == "00:00") {
                    $hour = "--:--";
                }
                $title .="$hour " . $row['name'] . "\n<br /> ";
            }
            $title .="";
            //$style = "style='border:1px solid #ddd;background-color:#999; color:#fff;'";
            $style = " class='calendarGrey tooltip ' ";
            $href = "href='" . $serverUrl . "calendari/dia/$day_num-$month-$year'";

            //$onmouseover="onMouseOver=agendaShowEvents($day_num,$month);";

            $class = "class='calendarTd tooltip'";
            //$title = "title='?day=$day_num&month=$month'";
        } elseif ($day_num == date('d') and $month == date('m')) {
            // $style = "style='border:1px solid #000;background-color:#c00; color:#fffff; font-weight:bold; background-image:url(webImages/taulaclassificacioBackground.png); '";
            $style = " class='calendarRed tooltip' ";
        }

        $out .= "\n\t<td  $style align=\"center\" >\n\t\t<a $href $class >$day_num";
        if ($title) {
            $out .= "<span class='classic'>$title</span>";
        }
        $out .= "</a>\n\t </td>";

        $day_num++;
        $day_count++;

        //Make sure we start a new row every week
        if ($day_count > 7) {
            $out .= "\n</tr>\n\n<tr>";
            $day_count = 1;
        }
    }
//Finaly we finish out the table with some blank details if needed
    while ($day_count > 1 && $day_count <= 7) {
        $out .= "<td> </td>";
        $day_count++;
    }

    $out .= "</tr></table>";

    if (isset($_GET['month'])) {
        echo utf8_encode($out);
    } else {
        echo $out;
    }
    ?>
 





