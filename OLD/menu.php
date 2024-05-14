<div>
    <?
    if (!$_GET) {
        // echo "<iframe width=\"960\" height=\"570\" src=\"//www.youtube.com/embed/RluSWG93ulw\" frameborder=\"0\" allowfullscreen></iframe>";
        // echo "<img src='TrobadaSolidariaAlella.jpg' />";
      //echo "<iframe width=\"960\" height=\"570\" src=\"//www.youtube.com/embed/DgVLBy2AwkU?autoplay=1\" frameborder=\"0\" allowfullscreen></iframe>";
       
    }
    ?>
    <ul class="topnav">
        <!--<li ><a href="" style="padding-top:0px;"><img src="http://png.findicons.com/files/icons/772/token_light/128/home.png"  width="24"></a></li>-->
        <li ><a href=""> Inici</a></li>

        <li><a>Federaci&oacute;</a>
            <ul class="subnav">

                <li > <a href="<? echo $serverUrl; ?>junta">Junta</a></li>
                <!--<li > <a href="<? echo $serverUrl; ?>documentacio/EstatutsFederacio2011.pdf">Estatuts</a></li>
                <li > <a href="<? echo $serverUrl; ?>historia">Historia FCFS</a></li>-->
                <li > <a href="<? echo $serverUrl; ?>delegacions">Seu</a></li>
                <li > <a href="<? echo $serverUrl; ?>defensordelclub">Defensor del club</a></li>

            </ul><span></span>
        </li>

        <!--<li><a>Futsal</a>
            <ul class="subnav">
        <?
        $res = mysql_query("select id, title from futsal order by id asc");
        while ($row = mysql_fetch_array($res)) {
            //echo "<li class=\"subMenuLi\"> <a href='?f=futsal&amp;id=".$row['id']."'>".$row['title']."</a></li>\n";}
            echo "<li> <a href='" . $serverUrl . "esport/" . $row['id'] . "-" . $row['title'] . "'>" . $row['title'] . "</a></li>\n";
        }
        ?>
                                                            </ul><span></span>
                                                        </li>-->
        <li > <a href="<? echo $serverUrl; ?>clubs">Clubs</a></li>
        <li><a href="<? echo $serverUrl; ?>competicio">Competici&oacute;</a>
            <!--<div class="divNav">
                <?
                /* $res2 = mysql_query("select s.id, s.name as season, d.id, d.name as division, c.id, c.name as championship, l.id as leagueId, l.name as league, isPlayoff from leagues l
join championship c on c.id=l.idchampionship
join divisions d on d.id=l.iddivision
join seasons s on s.id=l.idseason
where l.idseason=6 and hide=0
order by d.order asc,s.id, d.id, c.orderby, l.name  ");
                $a = 0;
                $b = 0;
                while ($row2 = mysql_fetch_array($res2)) {
                    if ($row2['division'] != $division) {
                        if ($a == 0) {
                            echo "\n\t\t<div style='background: rgb(238,238,238); 
background: -moz-linear-gradient(top, rgba(238,238,238,1) 0%, rgba(204,204,204,1) 100%); 
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(238,238,238,1)), color-stop(100%,rgba(204,204,204,1))); 
background: -webkit-linear-gradient(top, rgba(238,238,238,1) 0%,rgba(204,204,204,1) 100%); 
background: -o-linear-gradient(top, rgba(238,238,238,1) 0%,rgba(204,204,204,1) 100%); 
background: -ms-linear-gradient(top, rgba(238,238,238,1) 0%,rgba(204,204,204,1) 100%);
background: linear-gradient(to bottom, rgba(238,238,238,1) 0%,rgba(204,204,204,1) 100%); 
border-radius:5px; padding:5px; background-color:#ccc;width:214px; min-height:200px;  float:left; margin-right:10px;'><span style='color:#900; width:200px;background:none;'>" . $row2['division'] . "</span>";
                        } else {
                            echo "\n\t\t</div>\n\t\t<div style='background: rgb(238,238,238); 
background: -moz-linear-gradient(top, rgba(238,238,238,1) 0%, rgba(204,204,204,1) 100%); 
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(238,238,238,1)), color-stop(100%,rgba(204,204,204,1))); 
background: -webkit-linear-gradient(top, rgba(238,238,238,1) 0%,rgba(204,204,204,1) 100%); 
background: -o-linear-gradient(top, rgba(238,238,238,1) 0%,rgba(204,204,204,1) 100%); 
background: -ms-linear-gradient(top, rgba(238,238,238,1) 0%,rgba(204,204,204,1) 100%); 
background: linear-gradient(to bottom, rgba(238,238,238,1) 0%,rgba(204,204,204,1) 100%); 
border-radius:5px; padding:5px; margin-bottom:4px;background-color:#ccc;min-height:200px;width:214px; float:left; margin-right:10px;'><span style='color:#900;width:200px;background:none;'>" . $row2['division'] . "</span>";
                        }
                        $b = 0;
                    }
                    if ($row2['championship'] != $championship) {
                        if ($b != 0) {
                            echo "<br />";
                            echo "<br /><br /><span style='color:#333;width:200px;background:none;'>" . $row2['championship'] . "</span>";
                        }
                    }
                    if ($row2['isPlayoff'] == 1) {

                        echo "\n\t\t\t<br /><a style='width:200px; font-size:12px;padding:0; color:#666;' href='" . $serverUrl . "copa/" . $row2['leagueId'] . "-" . str_replace(" ", "-", treuAccents($row2['league'])) . "'> " . str_replace($row2['championship'], "", $row2['league']) . "</a>";
                    } else {
                        echo "\n\t\t\t<br /><a style='width:200px;font-size:12px;padding:0; color:#666;' href='" . $serverUrl . "divisio/" . $row2['leagueId'] . "-" . str_replace(" ", "-", treuAccents($row2['league'])) . "'> " . str_replace($row2['championship'], "", $row2['league']) . "</a>";
                    }
                    $b = 0;
                    $division = $row2['division'];
                    $championship = $row2['championship'];
                    $a++;
                    $b++;
                }
                echo "</div>"; */
                ?>
            </div>
            <span></span>-->
        </li>
        <li><a>Not&iacute;cies</a>
            <ul class="subnav floatedUl">
                <?
                $res = mysql_query("select nc.id, category, (select count(*) from news where categoryId=nc.id) as count from newscategories nc order by category asc") or die(mysql_error());
                while ($row = mysql_fetch_array($res)) {
                    echo "<li class='floatedLi'> <a href='" . $serverUrl . "categoria/" . $row['id'] . "-" . treuAccents($row['category']) . "'>" . strtoupper($row['category']) . " (" . $row['count'] . ")</a> </li>\n";
                }
                ?>
            </ul>
            <span></span>
        </li>
        <!--<li><a>Seleccions</a>
            <ul class="subnav">
                <?
                $res = mysql_query("select id, name from selections order by id asc");
                while ($row = mysql_fetch_array($res)) {
                    //echo "<li class=\"subMenuLi\"> <a href='?f=seleccions&amp;id=".$row['id']."'>".$row['name']."</a></li>\n";
                    //echo "<li> <a href='" . $serverUrl . "seleccio/" . $row['id'] . "-" . str_replace(" ", "-", treuAccents($row['name'])) . "'>" . $row['name'] . "</a></li>\n";
                }
                ?>
            </ul><span></span>
        </li>-->
        <!--i>-->
        <!--<li><a href="<? echo $serverUrl; ?>documents/24-junta_gestora">Junta gestora</a></li>-->
        <li ><a>Documents</a>
            <ul class="subnav">
                <?
                $res = mysql_query("select id, title from downloadcategories order by id asc");
                while ($row = mysql_fetch_array($res)) {
                    echo "<li> <a href='" . $serverUrl . "documents/" . $row['id'] . "-" . str_replace(" ", "-", treuAccents($row['title'])) . "'>" . $row['title'] . "</a></li>\n";
                }
                ?>
            </ul><span></span>
        </li>
        <li onClick="showMenu('menuPremsa', 7)"><a>Media</a>
            <ul class="subnav">
                <!--<li > Resum not�cies</li>-->

                <li > <a href='<? echo $serverUrl; ?>imatges'>Recull de fotografies</a></li>
                <li > <a href='<? //echo $serverUrl;                           ?>videos'>Recull de videos</a></li>
            </ul><span></span>
        </li>
    </ul>
</div>
<div id="menuSearch"></div>
<div style="clear:both;height:0px; background-color: #000;"></div>
<style>
    .btn {
  background: #d93434;
  background-image: -webkit-linear-gradient(top, #d93434, #b82b2b);
  background-image: -moz-linear-gradient(top, #d93434, #b82b2b);
  background-image: -ms-linear-gradient(top, #d93434, #b82b2b);
  background-image: -o-linear-gradient(top, #d93434, #b82b2b);
  background-image: linear-gradient(to bottom, #d93434, #b82b2b);
  -webkit-border-radius: 9;
  -moz-border-radius: 9;
  border-radius: 9px;
  font-family: Verdana;
  color: #ffffff;
  font-size: 20px;
  padding: 10px 40px 20px 40px;
  text-decoration: none;
  width:145px;
  margin:5px;
  text-align: center;
  float:left;
  height:30px;
  vertical-align: middle;
}

.btn:hover {
  background: #fc3c3c;
  background-image: -webkit-linear-gradient(top, #fc3c3c, #e82121);
  background-image: -moz-linear-gradient(top, #fc3c3c, #e82121);
  background-image: -ms-linear-gradient(top, #fc3c3c, #e82121);
  background-image: -o-linear-gradient(top, #fc3c3c, #e82121);
  background-image: linear-gradient(to bottom, #fc3c3c, #e82121);
  text-decoration: none;
}
</style>

<? include "announcements.php"; ?>
