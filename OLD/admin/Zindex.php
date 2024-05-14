<?
if (!$_COOKIE['userName']) {
    header("Location: http://www.futsal.cat");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <? $temporadaActual = 5; ?>
        <link rel="stylesheet" href="css/css.css" />
        <link rel="stylesheet" href="scripts/jquery.wysiwyg.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Administració</title>
        <script type="text/javascript" src="scripts/newjavascript.js"></script>
        <script type="text/javascript" src="scripts/jquery.js"></script>
        <script type="text/javascript" src="scripts/jquery.wysiwyg.js"></script>
        <script type="text/javascript" src="scripts/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript" src="scripts/fancybox/jquery.easing-1.3.pack.js"></script>
        <link rel="stylesheet" href="scripts/fancybox/jquery.fancybox-1.3.4.css" type="text/css" />


    </head>

    <body>

        <div id="left">
            <div id="logo"><img src="images/logo.png" /></div>
            <div id="loginInfo">Hola, <? echo $_COOKIE['userName']; ?> | <a href="logout.php">Sortir</a></div>

            <div id="nav">
                <ul>


                    <li><a id="ul_competicio_a" class="nav-top-item" onClick="ulShow('ul_competicio')";>Competició</a>
                        <ul id="ul_competicio">
                            <?
                            include ("../includes/config.php");
                            include ("../includes/funciones.php");
                            conectar();
                            $lastSeason = lastSeason();
                            $lastSeasonId = $lastSeason[0];
                            $lastSeasonName = $lastSeason[1];
                            $res = mysql_query("select name,id from leagues where idseason=$lastSeasonId  order by name ");
                            while ($row = mysql_fetch_array($res)) {

                                echo "\n\t\t\t\t<li> <img src='images/drafts-open.gif' style='vertical-align:text-bottom;'> <span onClick=\"roundsByLeagueId(" . $row['id'] . ");\"> " . $row['name'] . "</span> <img src='images/refresh.png' style='vertical-align:text-bottom;' onClick='classificationRecalculate(" . $row['id'] . ",$lastSeasonId);'><ul id=\"roundsByLeagueId_" . $row['id'] . "\"> </ul></li>";
                            }
                            ?>
                        </ul>
                    </li>
                    <li><a id="ul_ccompeticio_a" class="nav-top-item" onClick="ulShow('ul_ccompeticio');">Comitè de Competició</a>
                        <ul id="ul_ccompeticio">
                            <?
                            $res = mysql_query("select distinct initialdate from rounds r where idseason=$lastSeasonId and initialdate<=now() order by  initialdate ");
                            while ($row = mysql_fetch_array($res)) {

                                //echo "\n\t\t\t\t<li> <img src='images/drafts-open.gif'> <span onClick=\"comiteeGenerateWord('" . $row['initialdate'] . "');\">" . invertdateformat($row['initialdate']) . "</span></li>";
                                echo "\n\t\t\t\t<li> <img src='images/drafts-open.gif'> <span onClick=\"comiteeShowInfo('" . $row['initialdate'] . "');\">" . invertdateformat($row['initialdate']) . "</span></li>";
                            }
                            ?>
                        </ul>
                    </li>
                    <li><a class="nav-top-item" id="ul_teams_a"  onClick="ulShow('ul_teams');">Equips i clubs</a>
                        <ul id="ul_teams">
                            <li onClick="clubsNew()">Nou club</li>
                            <?
                            $res = mysql_query("select name,id from clubs order by name ");
                            while ($row = mysql_fetch_array($res)) {

                                echo "\n\t\t\t\t<li > <img src='images/drafts-open.gif'><span onClick=\"teamsByClubId(" . $row['id'] . ");\"> " . $row['name'] . "</span><ul id=\"teamsByClubId_" . $row['id'] . "\"></ul></li>";
                            }
                            ?>
                        </ul>
                    </li>
                    <li><a class="nav-top-item">Lligues</a></li>
                    
                </ul>
            </div>

        </div>

        <div id="right" >

            <div id="rightContent">
                <?
                            $out .="<div class='contentBox'>";
                            $out .="<div class='contentBoxHeader'><h2>" . mysql_num_rows($res) . " jugadors amb fitxa pagada i no inclosos a relació.</h2></div>";
                            $out .="<div class='contentBoxContent'>";

                                  $sql = "select
                            p.id
                            , p.name,t.name as team
                            , (select count(*) from  matches_players mp join matches m on m.id=mp.idmatch join rounds r on r.id=m.idround where idseason=5 and mp.idplayer=p.id and mp.idteam!=pts.idteam)  as count
                            ,matchesPlayedWithAnotherTeam
                            from players p
join player_team_season pts on pts.idplayer=p.id
                            join teams t on t.id=pts.idteam
where idseason=$temporadaActual  and pts.matchesPlayedWithAnotherTeam>=10 order by pts.matchesPlayedWithAnotherTeam desc";
                                  //echo $sql;

                                  //$sql="select * from players where name like '%sfgg%'";
                            $res = mysql_query($sql) or die(mysql_error());
                            $a = 1;
                            $out .="<table class='playersTable' cellspacing=0><tr><th width=300>Jugador</th><th width=100>Equip</th><th width=5%>Partits</th></tr>";

                            while ($row = mysql_fetch_array($res)) {
                               
                                if ($row['count'] > 0) {
                                     if ($n == 1) {
                                    $n = 2;
                                } else {
                                    $n = 1;
                                }

                                    $out .="<tr>";
                                    $out .="<td class='zebra$n' >" . $row['name'] . "</td><td class='zebra$n'> " . $row['team'] . "</td><td class='zebra$n'>" . $row['count'] . "</td>";
                                    $out .="</tr>";
                                }
                            }
                            $out .="</div>";
                            echo $out;
                ?>
            </div>

        </div>

    </body>
    <script type="text/javascript">
        document.body.onresize = function (){
            var w=window.innerWidth-350+"px";
       
            document.getElementById("right").style.width=w;}
        var w=window.innerWidth-350+"px";

        document.getElementById("right").style.width=w;
        Cufon.replace('.sectionTitle', { fontFamily: 'Inconsolata', hover: true });


        $(document).ready(function() {

            /* This is basic - uses default settings */



            $("a.inline").fancybox(

            {   'padding':0,
                'centerOnScroll':true,
                'scrolling':'no',
                'type':'iframe',
                'width':700,
                'height':480,
                'hideOnContentClick': true,
                'centerOnScroll:':true
            });

            /* Apply fancybox to multiple items */



        });

    </script>
</html>
