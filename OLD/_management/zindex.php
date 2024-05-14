<?
if (!$_COOKIE['userName']) {
    header("Location: http://www.futsal.cat");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?
        $idClub = $_COOKIE['idClub'];
        //echo $idClub;
        ?>
        <link rel="stylesheet" href="css/css.css" />
        <link rel="stylesheet" href="scripts/jquery.wysiwyg.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Administraci�</title>
        <script type="text/javascript" src="scripts/newjavascript.js"></script>
        <script type="text/javascript" src="scripts/jquery.js"></script>
        <script type="text/javascript" src="scripts/jquery.wysiwyg.js"></script>
        <script type="text/javascript" src="scripts/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript" src="scripts/fancybox/jquery.easing-1.3.pack.js"></script>
        <link rel="stylesheet" href="scripts/fancybox/jquery.fancybox-1.3.4.css" type="text/css" />

        <script type="text/javascript" src="scripts/jqtransform/jqtransformplugin/jquery.jqtransform.js"></script>

        <link rel="stylesheet" href="scripts/jqtransform/jqtransformplugin/jqtransform.css" type="text/css" />

    </head>

    <body
    <?
        if ($_GET['f'] = "playerCardEdit") {
            echo " onLoad=\"playerCardEdit(" . $_GET['idPlayer'] . "," . $_GET['idTeam'] . ")\";";
        }
    ?>
            >
            <div id="alpha"></div>
            <div id="modal"></div>

            <div id="left">
                <div id="logo"><img src="images/logo.png" /></div>
                <div id="loginInfo">Hola, <span style="text-decoration: underline;"><? echo $_COOKIE['userName']; ?></span> | <a href="../logout.php">Sortir</a></div>

                <div id="nav">
                    <ul>


                        <li>
                            <a id="ul_competicio_a" class="nav-top-item" onClick="ulShow('ul_teams')";>Gestio d'equips</a>
                            <ul id="ul_teams">
                            <?
                            include ("../includes/test/config.php");
                            include ("../includes/funciones.php");
                            $idcnx = conectar();
                            //echo "<h1>$idClub a...".$idcnx." $dbconnect</h1>";
                            $lastSeason = lastSeason();
                            $lastSeasonId = $lastSeason[0];
                            $lastSeasonName = $lastSeason[1];
                            $temporadaActual = $lastSeasonName;
                            $res = mysql_query("select id,name,id from teams where idclub=$idClub order by name limit 0,15 ");
                            while ($row = mysql_fetch_array($res)) {

                                echo "\n\t\t\t\t<li id='teamsList_" . $row['id'] . "'> <img src='images/drafts-open.gif' style='vertical-align:text-bottom;'>";
                                echo "<span onClick=\"playersByTeamId(" . $row['id'] . ");\"> " . $row['name'] . "</span></li>";
                            }
                            ?>
                        </ul>
                    </li>
                    <li>
                        <a id="ul_ccompeticio_a" class="nav-top-item" onClick="cmptScorers(<? echo "'" . md5($idClub) . "', " . $idClub; ?>)">Golejadors</a>
                    </li>
                    <li>
                        <a id="ul_ccompeticio_a" class="nav-top-item" onClick="cmptCards(<? echo "'" . md5($idClub) . "', " . $idClub; ?>)">Control de tarjetes</a>
                    </li>
                    <li><a id="ul_ccompeticio_a" class="nav-top-item" onClick="cmptMatchDateManagement(<? echo $idClub; ?>);">Gestio de partits</a>
                        <!--<ul id="ul_ccompeticio">
                        <?
                            $res = mysql_query("select m.id as idMatch, t1.id as idLocal, t1.name as local, t2.id as idVisitor, t2.name as visitor, datetime, r.name as roundname, (select count(*) from cmptMatch_Referee where idmatch=m.id) as nomenaments from matches m
join teams t1 on t1.id=m.idlocal
join teams t2 on t2.id=m.idvisitor
join clubs c on c.id=t1.idclub
join rounds r on r.id=m.idround
where statusid=1 and t1.idclub=$idClub
order by r.name+0 ");
                            while ($row = mysql_fetch_array($res)) {

                                if ($row['nomenaments'] == 0) {//echo "\n\t\t\t\t<li> <img src='images/drafts-open.gif'> <span onClick=\"comiteeGenerateWord('" . $row['initialdate'] . "');\">" . invertdateformat($row['initialdate']) . "</span></li>";
                                    echo "\n\t\t\t\t<li><img src='images/drafts-open.gif'> <span onClick=\"cmptMatchDateChange(" . $row['idLocal'] . "," . $row['idMatch'] . ");\">" . $row['local'] . " - " . $row['visitor'] . "<br />     " . invertdateformat($row['datetime']) . "</span></li>";
                                }
                            }
                        ?>
                                                    </ul>-->
                        </li>
                        <li>
                            <!--<a id="ul_ccompeticio_a" class="nav-top-item" onClick="cmptComplexManagement(<? echo $idClub; ?>);">Gestio de pistes</a>-->
                        </li>
                        <li>
                            <a id="ul_ccompeticio_a" class="nav-top-item" onClick="cmptBills(<? echo "'" . md5($idClub) . "', " . $idClub; ?>)">Factures</a>
                        </li>


                    </ul>
                </div>

            </div>

            <div id="right" >

                <div id="rightContent">

                <?
                            $sql = "
select p.id, p.name, t.name as team, matchesPlayedWithAnotherTeam from player_team_season pts
join teams t on t.id=pts.idteam
join players p on p.id=pts.idplayer

where idseason= 6 and t.idclub=$idClub and matchesPlayedWithAnotherTeam>=1 
                -- and year(birthdate)>=year(now())-23  
                and ageAtSeasonStart>23 order by matchesPlayedWithAnotherTeam desc";
                            $res = mysql_query($sql);
                            if (mysql_num_rows($res) > 0) {
                                $out .="<div class='contentBox'>";
                                $out .="<div class='contentBoxHeader'><h2>Numero de partits jugats amb equip de categoria superior</h2></div>";
                                $out .="<div class='contentBoxContent'>";
                                $out .="<table class='playersTable' cellspacing=0>";
                                $out .="<tr><th width=12>&nbsp</th><th width=350>Jugador</th><th>Equip</th><th width=100 >Partits jugats</th></tr>";
                                while ($row = mysql_fetch_array($res)) {
                                    if ($n == 1) {
                                        $n = 2;
                                    } else {
                                        $n = 1;
                                    }
                                    if ($row['matchesPlayedWithAnotherTeam'] >= 10) {
                                        $m = "Si torna a ser alineat quedar� retingut autom�ticament al equip patrocinador";
                                    } else {
                                        $m = $row['matchesPlayedWithAnotherTeam'];
                                    }

                                    $out .="<tr><td class='zebra$n'>&nbsp;</td>";
                                    $out .="<td class='zebra$n'>" . $row['name'] . "</td>";
                                    $out .="<td class='zebra$n'>" . $row['team'] . "</td>";
                                    $out .="<td class='zebra$n' align=center>" . $m . "</td>";
                                }
                                $out .="</table></div></div>";
                                $out .="<div class='contentBoxSpacer'></div>";
                            }



                            $sql = "select mdc.id, m.id as idMatch, mdc.comment, m.datetime as matchDateTime, mdc.datetime as proposalDateTime,t1.name as local, t2.name as visitor, t2.id as idTeam from cmptMatchDateChange mdc
join matches m on m.id=mdc.idmatch
join teams t1 on t1.id=m.idlocal

join teams t2 on t2.id=m.idvisitor
where t2.idclub=$idClub and approved=0 and denied=0";
                            // echo $sql;
                            $out .="<div class='contentBox'>";
                            $out .="<div class='contentBoxHeader'><h2>Gestio de partits</h2></div>";
                            $out .="<div class='contentBoxContent'><table width=100%><tr><th>Partit</th><th>Hora original</th><th>Hora proposada</th></tr>";
                            $res = mysql_query($sql) or die(mysql_error());
                            while ($row = mysql_fetch_array($res)) {
                                $out .= "<tr><td>" . $row['local'] . "-" . $row['visitor'] . "</td><td>" . $row['matchDateTime'] . "</td><td>" . $row['proposalDateTime'] . "</td><td>&nbsp; <!--<img src='http://www.futsal.cat/management/images/accept.png' onClick='cmptMatchDateAccept(" . $row['id'] . "," . $row['idMatch'] . "," . $row['idTeam'] . ");' />&nbsp;<img src='http://www.futsal.cat/management/images/cross.png' onClick='cmptMatchDateDeny(" . $row['id'] . "," . $row['idMatch'] . "," . $row['idTeam'] . ");' />--></td></tr>";
                                $out .="<tr><td colspan=4 style='padding:15px; border:1px solid #ccc; background-color:#ededed; margin:20px;'>" . $row['comment'] . "</td></tr><tr><td colspan=4><hr></td></tr>";
                            }
                            $out .="</table></div></div>";
                            $out .="<div class='contentBoxSpacer'></div>";
                            $sql = "
                            
                SELECT
                    c.name,
                    c.description,
                    c.image,
                    c.address,
                    c.phone1,
                    c.phone2,
                    c.web,
                    c.email,
                    c.city,
                    c.facebook,
                    c.twitter,
                    c.clubcode,
                    cbi.name as billing_name,
                    cbi.nif,
                    cbi.address as billing_address,
                    cbi.city as billing_city
                FROM clubs c
                    left join club_billing_info cbi on cbi.idClub=c.id
                where id= $idClub";
// echo $sql;

                            $res = mysql_query($sql) or die(mysql_error());
                            $row = mysql_fetch_array($res);

                            $out .="<div class='contentBox'>";
                            $out .="<div class='contentBoxHeader'><h2 onClick=\"playerCardEdit(" . $_GET['idPlayer'] . "," . $_GET['idTeam'] . ")\";>" . $row['name'] . " " . $row['idCard'] . "</h2></div>";
                            $out .="<div class='contentBoxContent'>";
                            $out .="<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"220\" height=\"30\" id=\"fileUploader\" align=\"middle\">
    <param name=\"movie\" value=\"flash/fileUploader.swf\" />
    <param name=\"quality\" value=\"high\" />
    <param name=\"bgcolor\" value=\"#ffffff\" />
    <param name=\"play\" value=\"true\" />
    <param name=\"loop\" value=\"true\" />
    <param name=\"wmode\" value=\"window\" />
    <param name=\"scale\" value=\"showall\" />
    <param name=\"menu\" value=\"true\" />
    <param name=\"devicefont\" value=\"false\" />
    <param name=\"salign\" value=\"\" />
    <param name=\"allowScriptAccess\" value=\"sameDomain\" />
    <param name=FlashVars value=\"idTeam=" . $_GET['idTeam'] . "&idPlayer=" . $_GET['idPlayer'] . "&fileType=clubLogo\">

    <!--[if !IE]>-->
    <object type=\"application/x-shockwave-flash\" data=\"flash/fileUploader.swf\" width=\"220\" height=\"30\">
        <param name=\"movie\" value=\"flash/fileUploader.swf?idTeam=" . $_GET['idTeam'] . "&idPlayer=" . $_GET['idPlayer'] . "&fileType=clubLogo\" />
        <param name=\"quality\" value=\"high\" />
        <param name=\"bgcolor\" value=\"#ffffff\" />
        <param name=\"play\" value=\"true\" />
        <param name=\"loop\" value=\"true\" />
        <param name=\"wmode\" value=\"window\" />
        <param name=\"scale\" value=\"showall\" />
        <param name=\"menu\" value=\"true\" />
        <param name=\"devicefont\" value=\"false\" />
        <param name=\"salign\" value=\"\" />
        <param name=\"allowScriptAccess\" value=\"sameDomain\" />
        <param name=FlashVars value=\"idTeam=" . $_GET['idTeam'] . "&idPlayer=" . $_GET['idPlayer'] . "&fileType=clubLogo\">

<!--<![endif]-->
        <a href=\"http://www.adobe.com/go/getflash\">
            <img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Obtener Adobe Flash Player\" />
        </a>
        <!--[if !IE]>-->
    </object>
    <!--<![endif]-->
</object><label for='fileUploader'>Logo </label><hr>";
                            $out .="<input type='text' class='playerCardEditInput' id='clubAddress' value='" . $row['address'] . "'><label for='clubAddress' style='clear:both;'>Carrer <span>*</span></label><br />";
                            $out .="<input type='text' class='playerCardEditInput' id='clubCity' value='" . $row['city'] . "'><label for='clubCity' style='clear:both;'>Ciutat<span>*</span></label><br /><hr />";

                            $out .="<input type='text' class='playerCardEditInput' id='clubEmail' value='" . $row['email'] . "'><label for='playerAddress' style='clear:both;'>Email <span>*</span></label><br />";
                            $out .="<input type='text' class='playerCardEditInput' id='clubPhone1' value='" . $row['phone1'] . "'><label for='playerAddress' style='clear:both;'>Telefon 1 <span>*</span></label><br />";
                            $out .="<input type='text' class='playerCardEditInput' id='clubPhone2' value='" . $row['phone2'] . "'><label for='playerAddress' style='clear:both;'>Telefon 2 <span>*</span></label><br /><hr>";

                            $out .="<input type='text' class='playerCardEditInput' id='clubWeb' value='" . $row['web'] . "'><label for='playerAddress' style='clear:both;'>Web <span>*</span></label><br />";
                            $out .="<input type='text' class='playerCardEditInput' id='clubFacebook' value='" . $row['facebook'] . "'><label for='playerAddress' style='clear:both;'>Facebook <span>*</span></label><br />";
                            $out .="<input type='text' class='playerCardEditInput' id='clubTwitter' value='" . $row['twitter'] . "'><label for='playerAddress' style='clear:both;'>Twitter <span>*</span></label><br /><hr>";

                            $out .="<input type='text' class='playerCardEditInput' id='billingName' value='" . $row['billing_name'] . "'><label for='playerAddress' style='clear:both;'>Nom de factura <span>*</span></label><br />";
                            $out .="<input type='text' class='playerCardEditInput' id='billingNif' value='" . $row['nif'] . "'><label for='playerAddress' style='clear:both;'>NIF <span>*</span></label><br />";
                            $out .="<input type='text' class='playerCardEditInput' id='billingAddress' value='" . $row['billing_address'] . "'><label for='playerAddress' style='clear:both;'>Adre�a Fiscal <span>*</span></label><br />";
                            $out .="<input type='text' class='playerCardEditInput' id='billingCity' value='" . $row['billing_city'] . "'><label for='playerAddress' style='clear:both;'>Ciutat <span>*</span></label><br /><hr>";

                            $out .="<textarea class='playerCardEditInput' id='clubHistory' style='height:300px; width:600px;'>" . $row['description'] . "</textarea><label for='clubHistory'>Hist�ria</label><BR />";
                            $out .="<input type='button' onClick='clubInfoUpdate($idClub);' class='newPlayerNameButton' value='Desar' />&nbsp;";
                            $out .="</div>";
                            $out .="</div>";
                            echo $out;
                            mysql_close($idcnx);
                ?>

            </div>

        </div>

    </body>
    <script type="text/javascript">
        document.body.onresize = function (){
            var w=window.innerWidth-350+"px";
            document.getElementById("right").style.width=w;
        }
        var w=window.innerWidth-350+"px";

        document.getElementById("right").style.width=w;
        // Cufon.replace('.sectionTitle', { fontFamily: 'Inconsolata', hover: true });


        $(document).ready(function() {

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
