<div class='rightContainerShadow' id="matchResults">

    <div id="resultsContainer">
        <h1>&Uacute;ltims resultats</h1><br />
        <?php
        $sql = "select
                m.id,
                l.id as idLeague,
                l.name as league,
                t1.id as idLocal,
                t2.id as idVisitor,
                t1.name as local,
                t2.name as visitor,
                localResult,
                visitorResult ,
                c1.image as localImage,
                c2.image as visitorImage
     from results r
join matches m on m.id=r.idmatch
join teams t1 on t1.id=m.idlocal
join teams t2 on t2.id=m.idvisitor
join clubs c1 on c1.id=t1.idclub
join clubs c2 on c2.id=t2.idclub
join rounds ro on ro.id=m.idround
join leagues l on l.id=ro.idleague
 where  l.idseason=8 and datediff(m.datetime,now())>=-3 and l.hide=0

order by l.id asc, r.id desc limit 0,100 ";
        $res = mysql_query($sql);
        $league = "";
        $a = 0;
        if (mysql_num_rows($res) > 0) {
           
            while ($row = mysql_fetch_array($res)) {
                if ($row['idLeague'] != $league) {
                    $leagueArray = $leagueArray . $row['idLeague'] . ",";
                    if ($a == 0) {
                        $display = "block";

                        $firstLeague = $row['idLeague'];
                    } else {
                        echo "</div>";
                        $display = "none";
                    }
                    $a++;
                    echo "\n\n\n\n<!-- Resultats lliga " . $row['league'] . " -->\n\n<div style='display:$display;' id=\"matchResults_" . $a . "\"><h2 style='color:#990c00;'>" . strtoupper($row['league']) . "</h2><br />";
                }
                echo "\n\t<div style='width:20px; float:left; font-size:15px;font-weight:bold; color:#990d00; text-align:right; margin-right:10px;'>" . $row['localResult'] . "</div>";
                echo "\n\t<div style='width:20px; float:left; font-weight:bold; color:#cc0d00; text-align:right; margin-right:10px;'>\n\t\t<img style='vertica-align:middle; 'src='http://historic.futsal.cat/webImages/clubsImages/" . $row['localImage'] . "' height=20 width=20>\n\t</div>";
                echo "\n\t<div style='width:250px; float:left; font-size:15px; font-weight:bold; color:#424242; text-align:left;'>\n\t\t<a href='" . $serverUrl . "equip/" . $row['idLocal'] . "-" . teamUrlFormat($row['local']) . "'> " . strtoupper($row['local']) . "</a>\n\t</div>\n\t<div style='clear:both'></div>";
                echo "\n\t<div style='width:20px; float:left; font-size:15px;font-weight:bold; color:#990d00; text-align:right; margin-right:10px;'>" . $row['visitorResult'] . "</div>";
                echo "\n\t<div style='width:20px; float:left; font-weight:bold; color:#cc0d00; text-align:right; margin-right:10px;'>\n\t\t<img style='vertica-align:middle; ' src='http://historic.futsal.cat/webImages/clubsImages/" . $row['visitorImage'] . "' height=20 width=20>\n\t</div>";
                echo "\n\t<div style='width:250px; float:left; font-size:15px; font-weight:bold; color:#424242; text-align:left;'>\n\t\t<a href='" . $serverUrl . "equip/" . $row['idVisitor'] . "-" . teamUrlFormat($row['visitor']) . "'> " . strtoupper($row['visitor']) . "</a\n\t></div>\n\t<div style='clear:both;padding:0px; margin-bottom:19px;border-bottom:1px solid #ddd;'>&nbsp;</div>";
                $league = $row['idLeague'];
            }
            echo "</div>";
            $numberOfSlides = $a;
        }
        ?>
        <script text="javascript">
            var currentSlide=1;

            function initSlider(numberOfSlides){
                //alert(numberOfSlides);
                if(numberOfSlides){
                    document.getElementById("matchResults").style.display="block";
                }else{
                     document.getElementById("matchResults").style.display="none";
                }
                if(numberOfSlides>1){
                    var s=setInterval( function() { sliderChange(numberOfSlides); }, 5000 );
                }
            }

            function sliderChange(numberOfSlides){

                if(currentSlide){
                    if(currentSlide==numberOfSlides){
                        document.getElementById("matchResults_"+numberOfSlides).style.display="none";
                        currentSlide=1;
                        document.getElementById("matchResults_1").style.display="block";

                    }else{
                        document.getElementById("matchResults_"+currentSlide).style.display="none";
                        currentSlide++;
                        document.getElementById("matchResults_"+currentSlide).style.display="block";}
                }else{
                    currentSlide=1;
                    document.getElementById("matchResults_"+currentSlide).style.display="none";
                    currentSlide++;
                    document.getElementById("matchResults_"+currentSlide).style.display="block";

                }


            }
            initSlider(<? echo $numberOfSlides; ?>);
        </script>

    </div>
</div>