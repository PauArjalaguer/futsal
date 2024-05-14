<?
if (!$_COOKIE['userName']) {
    header("Location: http://www.futsal.cat");
}
//echo $idClub;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

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
        <div><a name="init"></a></div>
        <div id="alpha"></div>
        <div id="modal"></div>

        <div id="left">
            <div id="logo"><img src="images/logo.png" /></div>
            <div id="loginInfo">Hola, <span style="text-decoration: underline;"><? echo $_COOKIE['userName']; ?></span> | <a href="../logout.php">Sortir</a></div>

            <div id="nav">
                <ul>
                    <li><a id="ul_competicio_a" class="nav-top-item" onClick="window.location.reload( true );">Gesti� d'equips</a>
                        <input type="text" onKeyUp="clubsAndTeamsSearch()" id="clubsAndTeamsSearchInput" style="width:200px;" value="Buscar"/>
                        <ul id="ul_teams">
                            <?
                            include ("../includes/config.php");
                            include ("../includes/funciones.php");
                            conectar();

                           // mysql_query("update player_team_season set ispayed=0, paymentdate =null where idplayer in (743,567)");
                           // mysql_query("delete from admrate_division_season_exceptions  where idplayer in (743,567)");
                            $lastSeason = lastSeason();
                            $lastSeasonId = $lastSeason[0];
                            $lastSeasonName = $lastSeason[1];
                            $temporadaActual = $lastSeasonName;
                            $res = mysql_query("select
                                        distinct t.id
                                        , t.name
                                        , c.id as idClub
                                        , c.name as clubName
                                    from teams t
                                       left  join teams_divisions_per_season td on td.idteam=t.id
                                        join clubs c on c.id=t.idclub

                                    where idclub=148 or idSeason=$lastSeasonId
                                    order by c.name");

                            while ($row = mysql_fetch_array($res)) {
                                if ($row['idClub'] != $idClub) {
                                    echo "<li style='font-weight:bold;' onClick='clubCashingInfo(" . $row['idClub'] . ")'><img src='images/drafts-open.gif' style='vertical-align:text-bottom;' > " . $row['clubName'] . "</li>";
                                    echo "<li onClick='clubRefereeReceipts(" . $row['idClub'] . ")'>Rebuts</li>";
                                }
                                echo "\n\t\t\t\t<li id='teamsList_" . $row['id'] . "'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";
                                echo "- <span onClick=\"playersByTeamId(" . $row['id'] . ");\"> <a href='#init'>" . $row['name'] . "</a></span></li>";
                                $idClub = $row['idClub'];
                            }
                            ?>
                        </ul>
                    </li>
                    <!--<li><a id="ul_ccompeticio_a" class="nav-top-item" onClick="ulShow('ul_ccompeticio');">Comit� de Competici�</a>
                        <ul id="ul_ccompeticio">
                    <?
                            $res = mysql_query("select distinct initialdate from rounds r where idseason=2 order by  initialdate ");
                            while ($row = mysql_fetch_array($res)) {


                                echo "\n\t\t\t\t<li> <img src='images/drafts-open.gif'> <span onClick=\"comiteeShowInfo('" . $row['initialdate'] . "');\">" . invertdateformat($row['initialdate']) . "</span></li>";
                            }
                    ?>
                                                                </ul>
                                                            </li>
                                                            <li><a class="nav-top-item" id="ul_teams_a"  onClick="ulShow('ul_teams');">Gesti� de sancions</a>
                                                                <ul id="ul_teams">
                    <?
                            $res = mysql_query("select name,id from clubs order by name ");
                            while ($row = mysql_fetch_array($res)) {

                                echo "\n\t\t\t\t<li > <img src='images/drafts-open.gif'><span onClick=\"teamsByClubId(" . $row['id'] . ");\"> " . $row['name'] . "</span><ul id=\"teamsByClubId_" . $row['id'] . "\"></ul></li>";
                            }
                    ?>
                                                                </ul>
                                                            </li>-->

                        </ul>
                    </div>

                </div>

                <div id="right" >

                    <div id="rightContent">
                <?
                            $lastSeason = lastSeason();
                            $lastSeasonId = $lastSeason[0];
                            $lastSeasonName = $lastSeason[1];

                            $sql = "
                            select
                                p.id
                                , p.name
                                , t.id as idTeam
                                ,t.`name` as teamName
                                , updateddate
                                , statusPercent
                            from players p
                                join player_team_season pts on pts.idPlayer=p.id
                                join teams t on pts.idteam=t.id
                            where
                                idseason=$lastSeasonId
                                and statuspercent=100
                                and ispayed=1
                                and p.id not in (select idPlayer from playerInsuranceListByIdSeason where idSeason=$lastSeasonId)
                            order by statusPercent,updateddate desc";
//echo $sql;

                            $res = mysql_query($sql) or die(mysql_error());
                            $row = mysql_fetch_array($res);

                            $out .="<div class='contentBox'>";
                            $out .="<div class='contentBoxHeader'><h2>" . mysql_num_rows($res) . " jugadors amb fitxa pagada i no inclosos a relaci�.</h2></div>";
                            $out .="<div class='contentBoxContent'>";
                            $out .="<table class='playersTable' cellspacing=0><tr><th width=12>&nbsp</th><th width=12>ID</th><th width=200>Jugador</th><th width=200>Equip</th><th width=120 >% complet</th><th>&nbsp;</th></tr>";
                            $res = mysql_query($sql) or die(mysql_error());
                            //print_r($row);
                            while ($row = mysql_fetch_array($res)) {

                                $statusImage = "";
                                $statusAlt = "";

                                $counter = 0;
                                $percent = $row['statusPercent'];
                                $statusImage = "accept";
                                $statusAlt = "Fitxa correcta";

                                $countWidth = $percent ;


                                if ($n == 1) {
                                    $n = 2;
                                } else {
                                    $n = 1;
                                }
                                $out .="<tr>";
                                if ($id != $row['id']) {
                                    $out .="<td class='zebra$n'>";
                                    $out .="<a class='playerCardStatus'>";
                                    $out .="<span>$itemsCheckList</span>";
                                    $out .="<img src='images/$statusImage.png' alt='$statusAlt' title='$statusAlt' />";
                                    $out .="</a></td>";
                                } else {
                                    $out .="<td class='zebra$n'>&nbsp;</td>";
                                }
                                $out .="<td class='zebra$n' >".$row['id']."</td><td class='zebra$n' >" . $row['aid'] . " " . $row['aidTeam'] . " " . ucwords(strtolower($row['name'])) . "</td>";

                                $out .="<td class='zebra$n'>" . $row['teamName'] . "</td>";

                                if ($id != $row['id']) {
                                    $out .="<td class='zebra$n'><div style='width:100px; height:20px; background-color:#fff; border:1px solid #ddd;'><div style='width:" . $countWidth . "px; height:18px; background-color:#0bd; color:#fff; padding-top:2px;'>&nbsp;$percent %</div></div>";

                                    if ($row['statusPercent'] == 100) {
                                        $out .="<td class='zebra$n'><img src='images/pencil.png' class='pointer' onClick='playerCardEdit(" . $row['id'] . "," . $row['idTeam'] . ");' > &nbsp; ";
                                    } else {
                                        $out .="<td class='zebra$n'>&nbsp;</td>";
                                    }
                                } else {
                                    $out .="<td class='zebra$n'>&nbsp;</td><td class='zebra$n'>&nbsp;</td>";
                                }
                                $out .="</td>";
                                $out .="</tr>";
                                $id = $row['id'];
                            }
                            $out .= "</table>";
                            $out .="</div>";
                            $out .="</div>";
                                  $out .="<div class='contentBoxSpacer'></div>";
                            echo $out;
                            $out ="";
                            $sql = "select p.id, p.name, t.id as idTeam,t.`name` as teamName, updateddate, statusPercent from players p
	join player_team_season pts on pts.idPlayer=p.id
	join teams t on pts.idteam=t.id
	where idseason=$lastSeasonId and statuspercent=100 and ispayed=0
	order by statusPercent,updateddate desc";
//echo $sql;

                            $res = mysql_query($sql) or die(mysql_error());
                            $row = mysql_fetch_array($res);

                            $out .="<div class='contentBox'>";
                            $out .="<div class='contentBoxHeader'><h2>" . mysql_num_rows($res) . " jugadors per a aprovar</h2></div>";
                            $out .="<div class='contentBoxContent'>";
                            $out .="<table class='playersTable' cellspacing=0><tr><th width=12>&nbsp</th><th width=12>ID</th><th width=200>Jugador</th><th width=200>Equip</th><th width=250 >% complet</th><th>&nbsp;</th></tr>";
                            $res = mysql_query($sql) or die(mysql_error());
                            //print_r($row);
                            while ($row = mysql_fetch_array($res)) {

                                $statusImage = "";
                                $statusAlt = "";

                                $counter = 0;
                                $percent = $row['statusPercent'];
                                $statusImage = "accept";
                                $statusAlt = "Fitxa correcta";

                                $countWidth = $percent ;


                                if ($n == 1) {
                                    $n = 2;
                                } else {
                                    $n = 1;
                                }
                                $out .="<tr>";
                                if ($id != $row['id']) {
                                    $out .="<td class='zebra$n'>";
                                    $out .="<a class='playerCardStatus'>";
                                    $out .="<span>$itemsCheckList</span>";
                                    $out .="<img src='images/$statusImage.png' alt='$statusAlt' title='$statusAlt' />";
                                    $out .="</a></td>";
                                } else {
                                    $out .="<td class='zebra$n'>&nbsp;</td>";
                                }
                                $out .="<td class='zebra$n' >".$row['id']."</td><td class='zebra$n' >" . $row['aid'] . " " . $row['aidTeam'] . " " . ucwords(strtolower($row['name'])) . "</td>";

                                $out .="<td class='zebra$n'>" . $row['teamName'] . "</td>";

                                if ($id != $row['id']) {
                                    $out .="<td class='zebra$n'><div style='width:100px; height:20px; background-color:#fff; border:1px solid #ddd;'><div style='width:" . $countWidth . "px; height:18px; background-color:#0bd; color:#fff; padding-top:2px;'>&nbsp;$percent %</div></div>";

                                    if ($row['statusPercent'] == 100) {
                                        $out .="<td class='zebra$n'><img src='images/pencil.png' class='pointer' onClick='playerCardEdit(" . $row['id'] . "," . $row['idTeam'] . ");' > &nbsp; ";
                                    } else {
                                        $out .="<td class='zebra$n'>&nbsp;</td>";
                                    }
                                } else {
                                    $out .="<td class='zebra$n'>&nbsp;</td><td class='zebra$n'>&nbsp;</td>";
                                }
                                $out .="</td>";
                                $out .="</tr>";
                                $id = $row['id'];
                            }
                            $out .= "</table>";
                            $out .="</div>";
                            $out .="</div>";
                      
                            echo $out;
                            $out ="";

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
