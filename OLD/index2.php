<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="X-UA-Compatible" content="IE=8"/>

        <?
        include ("includes/test/db.inc");
        include("Classes/News_class.php");
        include("Classes/Calendar_class.php");
        include("Classes/Competition_class.php");
        include ("includes/config.php");
        include ("includes/funciones.php");
		
include("Classes/Announcements_class.php");
        conectar();
        $serverUrl = "http://www.futsal.cat/";
        //$serverUrl = "http://localhost:8081/futsal/";
        include ("webTitle.php");
        ?>

       <link rel="stylesheet" type="text/css"
              href="<? echo $serverUrl; ?>css/css.css?1" />

        <base href="<? echo $serverUrl; ?>" />
        <link rel="alternate" type="application/rss+xml"  title="Federació Catalana de Futbol Sala - Noticies" href="http://www.futsal.cat/rss/newsRss.php" />
        <script type="text/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript"
        src="<? echo $serverUrl; ?>scripts/jquery-ui-1.7.2.custom.min.js"></script>

       <!-- <script type="text/javascript"        src="<? echo $serverUrl; ?>scripts/wtooltip.min.js"></script>-->
        <script type="text/javascript"
        src="<? echo $serverUrl; ?>scripts/scripts.js"></script>
        <script src="http://cufon.shoqolate.com/js/cufon-yui.js" type="text/javascript"></script>
        <script src="<? echo $serverUrl; ?>scripts/bebas-neue.cufonfonts.js" type="text/javascript"></script>
        <script src="<? echo $serverUrl; ?>scripts/swfobject.js" type="text/javascript"></script>
        <script src="<? echo $serverUrl; ?>scripts/yoxview/yoxview-init.js" type="text/javascript"></script>
<link href='http://fonts.googleapis.com/css?family=Ruda:400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
           

        <link rel="shortcut icon" href="<? echo $serverUrl; ?>webImages/favicon.ico" />
    </head>

    <body>
        <div style="position: fixed; top:10px; left:10px;" id="contador"></div>
        <script type="text/javascript">function tanca_comunicat(){document.getElementById("comunicatContent").style.display="none";}</script>
        <?php /* if (!isset($_GET['f'])) {
          echo "<div id=\"comunicatContent\" align=\"center\" style='text-align:center;width:100%;position:absolute;z-index:100;margin-top:auto; color:#fff; font-size:20px;	'>
          <div id='comunicat' style=\" width:950px; margin:auto; background-color:#242424; padding:90px; padding-top:80px;	 \">
          <div align=right onclick='tanca_comunicat();' style=\"cursor: pointer;\">X</div>
          <img src=\"newsImages/copafemenina.jpg\"></img></div></div>";
          } */
        ?>

        <div id="popup_container" align="center">
            <div id="popup">&nbsp;</div>
        </div>
        <div id="alpha">&nbsp;</div>
        <div class="loginContainer"><? ?></div>
        <div align="center" id="top"><? include "header.php"; ?>

            <div id="shadow">
                <div id="web"><? include "menu.php"; ?>

                   <div id="leftContainer" style="width:100%;">
                        <?
                        if (!isset($_GET['f'])) {
                            include "news_inicial.php";
                        } else {
                            include $_GET['f'] . ".php";
                        } ?></div>

                    <div id="rightContainer" style="display:none;">

                        <?
                        $sql = "Select hashtag from twitterFeaturedHashtag";
                        $res = mysql_query($sql) or die(mysql_error());
                        $row = mysql_fetch_array($res);
                        if (!empty($row['hashtag'])) {
                            echo "
                                         <div class=\"rightContainerShadow\">
                            <div id=\"resultsContainer\">
                                <script src=\"http://widgets.twimg.com/j/2/widget.js\"></script>
                                <script>
                                    new TWTR.Widget({
                                        version: 2,
                                        type: 'search',
                                        search: '" . $row['hashtag'] . "',
                                        interval: 6000,
                                        title: 'Futsal',
                                        subject: 'Federació Catalana de Futsal',
                                        width: 310,
                                        height: 300,
                                        theme: {
                                            shell: {
                                                background: '#8ec1da',
                                                color: '#ffffff'
                                            },
                                            tweets: {
                                                background: '#ffffff',
                                                color: '#444444',
                                                links: '#1985b5'
                                            }
                                        },
                                        features: {
                                            scrollbar: false,
                                            loop: true,
                                            live: true,
                                            hashtags: true,
                                            timestamp: true,
                                            avatars: true,
                                            toptweets: true,
                                            behavior: 'default'
                                        }
                                    }).render().start();
                                </script>  </div>
                        </div>";
                        }
                        ?>
                        <?  include "resultsWidget.php"; ?>
                        <!--<div class='rightContainerShadow'>

                          <div id="resultsContainer">
                               <h1>X European Championship - Belarus, Brest 13-20 Maig 2012</h1>

                               <div align="center">
                                   <a href="http://futsal-by.com/">
                                       <img width="290" title="X European Championship - Belarus, Brest 13-20 Maig 2012" alt="X European Championship - Belarus, Brest 13-20 Maig 2012" src="http://www.futsal.cat/newsImages/belarus.png" />
                                   </a>
                               </div>
                           </div>
                       </div>-->
                        <div class='rightContainerShadow'>

                            <div id="resultsContainer">
                                <h1>Barri-Ball Future 60 cm</h1>

                                <div align="center">
                                    <img src="http://www.futsal.cat/webImages/pilota.jpg" />
                                </div>
                            </div>
                        </div>
                        <!--<div class='rightContainerShadow'>

                            <div id="resultsContainer">
                                <h1>Playoff Copa Catalunya</h1>
                                <img src="http://www.futsal.cat/newsImages/CopaCatalunya201011.jpg" />
                            </div>
                        </div>
                        -->

                        <script type="text/javascript">
                            $(function() {
                                $("#accordion").accordion({
                                    event: "mouseover",
                                    autoHeight: false
                                });
                            });
                        </script>

                        <div class='rightContainerShadow'>
                            <div id="classificationWidget">
                                <h1>&nbsp;Classificacions</h1>
                                <div id="accordion"><?
                        $b = 1;
                        $res = mysql_query("select name,(select id from leagues where idDivision=d.id   order by idSeason desc limit 0,1) as id  from divisions d where id=4");

                        $lastSeason = lastSeason();
                        $sql = "select name,id from leagues where idSeason=" . $lastSeason[0] . " and hide=0 order by id";

                        $res = mysql_query($sql);
                        while ($row = mysql_fetch_array($res)) {
                            if ($b <= 1) {
                                $act = "Passive";
                                $d = "block";
                            } else {
                                $act = "Passive";
                                $d = "none";
                            }
                            echo "<div class=\"classificationWidget" . $act . "\" id=\"" . $row['id'] . "\" ><a href='http://www.futsal.cat/divisio/" . $row['id'] . "-" . str_replace(" ", "-", treuAccents($row['name'])) . "'>" . $row['name'] . "</a></div>";
                            echo "<div style='display:$d; padding:2px;'><table cellpadding=6 cellspacing=0 width=100%>";
                            $competition = new Competition;
                            $competition->idLeague = $row['id'];
                            $data = $competition->getClassificationByLeague();
                            $n = 1;
                            $a = 1;
                            foreach ($data as $clas) {
                                if ($a == 1) {
                                    $color = "#efefef";
                                    $a++;
                                } else {
                                    $color = "#fefefe";
                                    $a = 1;
                                }

                                echo "<tr>";
                                echo "<td style=\"background-color:$color; border-bottom:1px solid #ddd;\" align=center>$n</td>";
                                echo "<td class='equip' style=\"background-color:$color;\">" . $clas[0] . "</td>";
                                echo "<td class='punts' style=\"background-color:$color; text-align:center;\">" . $clas[1] . "</td>";

                                $n++;
                                $b++;
                            }echo "</table></div>";
                        }
                        ?></div>
                            </div>

                        </div>
                         <div class='rightContainerShadow'>
                             <div id="resultsContainer">
                                 <h1>Propera jornada</h1>
                                 <div id="nextRound">
<? include "competicioNextRound.php";  ?>
                                 </div>
                             </div>
                         </div>
                        
                        <div class='rightContainerShadow'>
                            <div id="calendarContainer">
                                <h1>Calendari</h1>
                                <div id="calendarDiv">
<? include ("calendar.php"); ?>
                                </div>
                            </div>
                        </div>

                        <!--<div class='rightContainerShadow'>
                            <div id="noticiesWidget"><?
                        //include "newsWidget.php";
?></div>
                                                                                                                                                                                                                                                                                                </div>-->
                        <div class='rightContainerShadow'>
                            <div id="sponsorsContainer">
                                <h1>Col.laboradors</h1>
                                <br />
                                <a href="http://www.amfutsal.com.py/ ">
                                    <img src="http://www.futsal.cat/webImages/sponsors/seg.png" alt="AMF" />
                                </a>&nbsp;
                                <a href="http://www.uefsfutsal.org/ ">
                                    <img src="http://www.futsal.cat/webImages/sponsors/uefs.png" alt="UEFS" /></a>&nbsp;
                                <a href="http://www.seleccions.cat/new/index.php?lang=ca">
                                    <img src="http://www.futsal.cat/webImages/sponsors/seleccions_cat.png"  alt="SELECCIONS" />
                                </a>&nbsp;&nbsp;
                                <br />
                                <br />
                                <br />
                                <a href="http://www20.gencat.cat/portal/site/sge/">
                                    <img width="310" src="http://www.fcatletisme.cat/z/logos/genesport.jpg" alt="Secretaria" />
                                </a>&nbsp;

                            </div>
                        </div>

                        <!--LOGIN-->

                        <div class='rightContainerShadow'>
                            <div id="loginContainer">
                                <h1>Login</h1>
<?
                        if (!isset($_COOKIE['userId'])) {
                            echo "<form action=\"login.php\" enctype=\"multipart/form-data\" method=\"post\"><table>";
                            echo "<tr><td>Usuari:</td><td> <input type=\"text\" name=\"login\" /></td></tr>";
                            echo "<tr><td>Clau:</td><td> <input type=\"password\" name=\"password\" /></td></tr>";
                            echo "<tr><td ><input type=\"checkbox\" name=\"remember\"> Recordar";
                            echo "<input type=\"hidden\" value=\"index.php\" name=\"referer\"></td>";
                            echo "<td align=right><input type=\"submit\" value=\"Entrar\" name=\"loginSubmit\" /></td></tr></table></form>";
                            //echo "<a href='usuari/registre'>&bull; Registra't</a>";
                        } else {
                            echo "<div style='padding:6px;'><strong><a href='usuari/edita'>" . $_COOKIE['userName'] . "</strong></a>&nbsp;<a href='usuari/edita'><img src='http://www.futsal.cat/webImages/edit.png' alt='Edita'></a>&nbsp;<a href='logout.php'><img src='http://www.futsal.cat/webImages/cancel.png'></a></div>";
                        }
?>

                            </div>
                        </div>
                        <!--<div class='rightContainerShadow'>
                            <div style="padding-left: 5px;"><script type="text/javascript"
                                src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php/ca_ES"></script><script
                                type="text/javascript">FB.init("bff82a55bf6642ae94fe006e3faa91d2");</script><fb:fan
                                    profile_id="110237404038" stream="1" connections="10" width="324"></fb:fan></div>
                            <div>&nbsp;</div>
                        </div>           -->
                        <!-- <div class='rightContainerShadow'>
                             <div id="calendarContainer">
                                 <h1>Fotos</h1>
                                 <div style="padding: 10px; text-align: center;">
<?
                        /* $api_key = "0df858f7d07620ceb376242e418a08a9"; // get yours at http://flickr.com/services/api/key.gne
                          $my_id = "42695980@N02"; // use idgetr (http://idgettr.com/) to find yours if you already changed it to a name
                          $page = rand(0, 10);
                          $method = "http://flickr.com/services/rest/?method=flickr.people.getPublicPhotos&user_id=$my_id&api_key=$api_key&per_page=3&page=$page";
                          //echo $method;
                          $xml = simplexml_load_file($method);
                          $total = count($xml->photos->photo);
                          //echo $total;
                          for ($i = 0; $i < $total; $i++) {

                          $photo = $xml->photos->photo[$i]['id'];
                          $server = $xml->photos->photo[$i]['server'];
                          $primary = $xml->photos->photo[$i]['primary'];
                          $secret = $xml->photos->photo[$i]['secret'];
                          $images = $xml->photos->photo[$i]['photos'];
                          echo "<a
                          href='" . $serverUrl . "imatge/$photo-" . treuAccents(utf8_decode($photo)) . "'><img src=\"http://static.flickr.com/" . $server . "/" . $photo . "_" . $secret . "_s.jpg\" id=\"$primary\" alt=\"$title\"  ></a> &nbsp;";
                          } */
?></div>
                                                                                                                                         </div>-->
                    </div>
                </div>
            </div>

            <div class="footer2">
                <div style="width: 50%; float: left; vertical-align: middle;">&copy;
                    Federacio Catalana de Futbol Sala 2009 C/Guipuscoa 23-25 5è D• 08018
                    Barcelona <br />
                    Tel. 93 244 44 03 • Fax 93 247 34 83 futsal@futsal.cat</div>
                <div style="width: 50%; float: left; text-align: right;">&nbsp; <a
                        href="http://www.facebook.com/futsalcat"><img
                            align="texttop"
                            src="http://www.futsal.cat/webImages/socialNetwork/facebook.png" />
                    </a>&nbsp;
                    <a href="http://twitter.com/futsalcat">
                        <img align="texttop"
                             src="http://www.futsal.cat/webImages/socialNetwork/twitter.png" />
                    </a>&nbsp;
                    <a href="http://www.flickr.com/photos/futsalcat/">
                        <img align="texttop"
                             src="http://www.futsal.cat/webImages/socialNetwork/flickr_logo.png" />
                    </a>&nbsp;
                    <a href="https://plus.google.com/u/0/101314887467051610542/posts">
                        <img align="texttop"
                             src="http://www.futsal.cat/webImages/socialNetwork/plus.png" />
                    </a>&nbsp;
                    <a href="http://www.youtube.com/user/futsalcat">
                        <img
                            src="http://www.futsal.cat/webImages/socialNetwork/youtube_logo.png" />
                    </a>&nbsp;
                    <a href="http://www.futsal.cat/rss/newsRss.php">
                        <img align="texttop" src="http://www.futsal.cat/webImages/socialNetwork/rss.png" />
                    </a>&nbsp;
                   <!-- <a href="http://www.elmundodeportivo.es"><img
                            src="http://www.futsal.cat/webImages/elMundoDeportivo.png" /></a>&nbsp;
                    <a href="http://quiosc.elpunt.cat/Quiosc.php?do=mostrarHemeroteca&edicio_id=8"><img
                            src="http://www.futsal.cat/webImages/el9.jpg" /></a>-->

                </div>
            </div>
        </div>


        <script>
            Cufon.replace('#sectionTitle,#matchInfo', { fontFamily: 'Bebas Neue', hover: true });
            Cufon.replace('.charis_sil_bold', { fontFamily: 'Charis SIL Bold', hover: true });
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                $(".yoxview").yoxview();
            });


        </script>
<? include "analytics.php"; ?>
    </body>
</html>
