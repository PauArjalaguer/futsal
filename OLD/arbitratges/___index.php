<?
if (!$_COOKIE['userName']) {
    header("Location: http://www.futsal.cat");
}
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <? $temporadaActual = 3; ?>
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

                    <li>
                        <a id="ul_ccompeticio_a" class="nav-top-item" onClick="rfrMatchAssignationPast();">Històric de partits</a>

                    </li>
                    <li>
                        <a id="ul_competicio_a" class="nav-top-item" onClick="rfrMatchAssignation();">Assignació de partits</a>
                        <ul style="display:block;" >
                            <?
                            $lastSeason = lastSeason();
                            $lastSeasonId = $lastSeason[0];
                            $lastSeasonName = $lastSeason[1];
                            $res = mysql_query("select name,id from leagues l  where idseason=$lastSeasonId  order by l.order asc ");
                            while ($row = mysql_fetch_array($res)) {

                                echo "\n\t\t\t\t<li> <img src='images/drafts-open.gif' style='vertical-align:text-bottom;'> <span onClick=\"rfrMatchAssignation(" . $row['id'] . ");\"> " . $row['name'] . "</span> </li>";
                            }
                            ?>
                        </ul>
                    </li>
                    <li>
                        <a id="ul_ccompeticio_a" class="nav-top-item" onClick="rfrRefereeManagement();">Gestió d'arbitres</a>

                    </li>


                </ul>
            </div>

        </div>

        <div id="right" >

            <div id="rightContent">

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
