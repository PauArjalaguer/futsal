
<div>
    <ul class="topnav">
        <li><a>Federació</a>
            <ul class="subnav">
                <li > <a href="">Inici</a></li>
                <li > <a href="<? echo $serverUrl; ?>junta">Junta</a></li>
                <li > <a href="<? echo $serverUrl; ?>estatuts">Estatuts</a></li>
                <li > <a href="<? echo $serverUrl; ?>historia">Historia FCFS</a></li>
                <li > <a href="<? echo $serverUrl; ?>delegacions">Seu</a></li>
                <!-- <li > Clubs</li>-->
            </ul><span></span>
        </li>
        <li><a>Notícies</a>
            <ul class="subnav floatedUl">
                <?
                $res = mysql_query("select nc.id, category, (select count(*) from news where categoryId=nc.id) as count from newscategories nc order by category asc");
                while ($row = mysql_fetch_array($res)) {
                    echo "<li class='floatedLi'> <a href='" . $serverUrl . "categoria/" . $row['id'] . "-" . treuAccents($row['category']) . "'>" . strtoupper($row['category']) . " (" . $row['count'] . ")</a> </li>\n";
                }
                ?>
            </ul><span></span>
        </li>
        <li><a>Futsal</a>
            <ul class="subnav">
                <?
                $res = mysql_query("select id, title from futsal order by id asc");
                while ($row = mysql_fetch_array($res)) {
                    //echo "<li class=\"subMenuLi\"> <a href='?f=futsal&amp;id=".$row['id']."'>".$row['title']."</a></li>\n";}
                    echo "<li> <a href='" . $serverUrl . "esport/" . $row['id'] . "-" . $row['title'] . "'>" . $row['title'] . "</a></li>\n";
                }
                ?>
            </ul><span></span>
        </li>

        <li><a>Competició</a>
            <ul class="subnav">

                <?
                //$res = mysql_query("select id, name from divisions order by id asc");
                //$res = mysql_query("select name,(select id from leagues where idDivision=d.id  and hide=0 order by idSeason desc limit 0,1 ) as idLeague  from divisions d ");
                $res = mysql_query("select name,c.id,(select count(*) from leagues where  idchampionship=c.id) as count from championship c order by orderby asc ");
                while ($row = mysql_fetch_array($res)) {
                    if ($row['count'] > 0) {
                        echo "\n\t<li> <a> " . $row['name'] . "</a>\n\t\t<ul class=subnav2>";

                        $res2 = mysql_query("select name,id from leagues where idchampionship=" . $row['id'] . " order by id  ");
                        while ($row2 = mysql_fetch_array($res2)) {
                            echo "\n\t\t\t<li> <a href='" . $serverUrl . "divisio/" . $row2['id'] . "-" . str_replace(" ", "-", treuAccents($row2['name'])) . "'> " . $row2['name'] . "</a></li>";
                        }

                        echo "\n\t\t</ul>";
                        echo "\n\t</li>\n";
                    }
                }
                ?>
               

            </ul><span></span>
        </li>
        <li><a>Seleccions</a>
            <ul class="subnav">
                <?
                $res = mysql_query("select id, name from selections order by id asc");
                while ($row = mysql_fetch_array($res)) {
                    //echo "<li class=\"subMenuLi\"> <a href='?f=seleccions&amp;id=".$row['id']."'>".$row['name']."</a></li>\n";
                    echo "<li> <a href='" . $serverUrl . "seleccio/" . $row['id'] . "-" . str_replace(" ", "-", treuAccents($row['name'])) . "'>" . $row['name'] . "</a></li>\n";
                }
                ?>
            </ul><span></span>
        </li>
        <li><a href="<? echo $serverUrl; ?>calendari">Agenda</a></li>
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
        <li onClick="showMenu('menuPremsa',7)"><a>Media</a>
            <ul class="subnav">
                <!--<li > Resum notícies</li>-->

                <li > <a href='<? echo $serverUrl; ?>imatges'>Recull de fotografies</a></li>
                <li > <a href='<? //echo $serverUrl;    ?>videos'>Recull de videos</a></li>
            </ul><span></span>
        </li>
    </ul>
</div>
<script>
    $(document).ready(function(){

        //$("ul.subnav").parent().append("<span></span>"); //Only shows drop down trigger when js is enabled (Adds empty span tag after ul.subnav*)
        /*
        $("ul.topnav li").click(function() { //When trigger is clicked...

                //Following events are applied to the subnav itself (moving subnav up and down)
                $(this).find("ul.subnav").slideDown('fast').show(); //Drop down the subnav on click

                $(this).hover(function() {
                }, function(){
                        $(this).find("ul.subnav").slideUp('slow'); //When the mouse hovers out of the subnav, move it back up
                });

                //Following events are applied to the trigger (Hover events for the trigger)
                }).hover(function() {
                        $(this).addClass("subhover"); //On hover over, add class "subhover"
                }, function(){	//On Hover Out
                        $(this).removeClass("subhover"); //On hover out, remove class "subhover"
        });
	
        $("ul.topnav li ul.subnav li").hover(function() { //When trigger is clicked...

                //Following events are applied to the subnav itself (moving subnav up and down)
                $(this).find("ul.subnav2").slideDown('fast').show(); //Drop down the subnav on click
                $(this).hover(function() {
                }, function(){
                        $(this).find("ul.subnav2").slideUp('fast'); //When the mouse hovers out of the subnav, move it back up
                });

});*/
    });
</script>
