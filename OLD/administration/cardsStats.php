<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

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

        <script type="text/javascript" src="scripts/jqtransform/jqtransformplugin/jquery.jqtransform.js"></script>

        <link rel="stylesheet" href="scripts/jqtransform/jqtransformplugin/jqtransform.css" type="text/css" />
        <style>
            th{text-align:left; color:#900; font-weight:bold; border-bottom: 3px solid #666;}
            td{border-bottom: 1px solid #aaa;}
        </style>
    </head>
    <body>
        <div style="width:600px; margin:auto; background-color: #999;padding:30px;">


            <?php
            include ("../includes/config.php");
            include ("../includes/funciones.php");
            conectar();
            $lastSeason = lastSeason();
            $lastSeasonId = $lastSeason[0];
            $lastSeasonName = $lastSeason[1];


            mysql_query("CREATE TEMPORARY TABLE `cardStats` (
`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`prefix` VARCHAR( 255 ) NOT NULL ,
`amount` INT NOT NULL,
`euros` INT NOT NULL,
`realEuros` INT NOT NULL,
`regalades` INT NOT NULL,
`rebaixades` INT NOT NULL,
`rate` INT NOT NULL


) ENGINE = MYISAM ;
") or die(mysql_error());


            echo "<h1>Fitxes pagades</h1>";
            echo "<table cellspacing=0 cellpadding=5 width=100%><tr><th>Tipus de fitxa</th><th>Quantitat</th><th>Preu</th><th>Euros</th><th>Real</th><th>Regal</th><th>Rebaixa</th></tr>";

            $sql = "select  distinct pts.idplayer, d.prefix, d.name,rdst.rate, adse.rate as newRate  from player_team_season pts
join teams t on t.id=pts.idteam
join teams_divisions_per_season tds on tds.idteam=t.id and tds.idseason=pts.idseason
join rate_division_season rdst on rdst.`idDivision`=tds.iddivision and rdst.idseason=pts.idseason
join divisions d on d.id=tds.iddivision
left join admrate_division_season_exceptions adse on adse.idplayer=pts.idplayer and adse.idseason=pts.idseason

where pts.idseason=$lastSeasonId  and statuspercent>70 and ispayed=1  and t.idclub not in (123,135)
order by prefix";
//echo $sql;
            $res = mysql_query($sql) or die(mysql_error());
            $numberOfCards = 0;
            $numberOfCardsXDivision = 0;
            $money = 0;
            $moneyTotal = 0;
            $regTotal = 0;
            $rebTotal = 0;

            while ($row = mysql_fetch_array($res)) {

                if ($row['prefix'] != $name) {

                    $numberOfCardsXDivision = 0;

                    mysql_query("insert into cardStats (prefix, amount,euros, realEuros, regalades, rebaixades,rate) values ('" . $row['prefix'] . "', 0,0,0,0,0," . $row['rate'] . ")") or die(mysql_error());
                    //echo $row['prefix']."<br />";
                }
                $moneyTotal = $moneyTotal + $row['rate'];
                if (isset($row['newRate'])) {
                    $r = $row['newRate'];
                    if ($r == 0) {
                        $reg = 1;
                        $reb = 0;
                    } else {
                        $reb = 1;
                        $reg = 0;
                    }
                } else {
                    $r = $row['rate'];
                    $reg = 0;
                    $reb = 0;
                }
                $moneyTotalReal = $moneyTotalReal + $r;
                $numberOfCards++;
                $numberOfCardsXDivision++;
                $regTotal = $regTotal + $reg;
                $rebTotal = $rebTotal + $reb;

                $sql3 = "update cardStats set amount=amount+1, euros=euros+" . $row['rate'] . ", realEuros=realEuros+ $r, regalades=regalades+$reg, rebaixades=rebaixades+$reb where prefix='" . $row['prefix'] . "'";
                //echo $sql3 . "<hr />";
                mysql_query($sql3) or die(mysql_error());

                $name = $row['prefix'];
            }

            $sql2 = "select * from cardStats";
            $res2 = mysql_query($sql2);
            while ($row2 = mysql_fetch_array($res2)) {
                echo "<tr><td>" . $row2['prefix'] . "</td><td>" . $row2['amount'] . "</td><td>" . $row2['rate'] . "</td><td>" . $row2['euros'] . " </td><td>" . $row2['realEuros'] . " </td><td>" . $row2['regalades'] . " </td><td>" . $row2['rebaixades'] . " </td></tr>";
            }
            echo "<tr><td style='color:#900; font-weight:bold; border-bottom: 3px solid #666;'>TOTAL</td><td style='color:#900; font-weight:bold; border-bottom: 3px solid #666;'>$numberOfCards</td><td style='color:#900; font-weight:bold; border-bottom: 3px solid #666;'>&nbsp;</td><td style='color:#900; font-weight:bold; border-bottom: 3px solid #666;'>$moneyTotal </td><td style='color:#900; font-weight:bold; border-bottom: 3px solid #666;'>$moneyTotalReal </td><td style='color:#900; font-weight:bold; border-bottom: 3px solid #666;'>$regTotal </td><td style='color:#900; font-weight:bold; border-bottom: 3px solid #666;'>$rebTotal </td></tr></table>";

            mysql_query("DROP TABLE cardStats");
            mysql_query("CREATE TEMPORARY TABLE `cardStats` (
`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`prefix` VARCHAR( 255 ) NOT NULL ,
`amount` INT NOT NULL,
`euros` INT NOT NULL,
`realEuros` INT NOT NULL,
`regalades` INT NOT NULL,
`rebaixades` INT NOT NULL,

`rate` INT NOT NULL) ENGINE = MYISAM ;
") or die(mysql_error());


            echo "<br /><br /><h1>Fitxes pendents de pagament</h1>";
            echo "<table cellspacing=0 cellpadding=5 width=100%><tr><th>Tipus de fitxa</th><th>Quantitat</th><th>Preu</th><th>Euros</th><th>Real</th><th>Regal</th><th>Rebaixa</th></tr>";


            $sql = "select distinct pts.idplayer, d.prefix, l.name,rate from players p

     join player_team_season pts on pts.idPlayer=p.id
     join teams t on pts.idteam=t.id
     join `teams_divisions` td on td.idteam=t.id and td.idseason=$lastSeasonId
      join leagues l on l.id=td.iddivision
     join rate_division_season rds on rds.`idDivision`=l.iddivision and rdst.idseason=pts.idseason
      join divisions d on d.id=l.iddivision
          where pts.idseason=$lastSeasonId and ispayed =0 and pts.idteam not in (33,38) and statuspercent>70     order by prefix  desc

";
            $sql = "select  distinct pts.idplayer, d.prefix, d.name,rdst.rate, adse.rate as newRate  from player_team_season pts
join teams t on t.id=pts.idteam
join teams_divisions_per_season tds on tds.idteam=t.id and tds.idseason=pts.idseason
join rate_division_season rdst on rdst.`idDivision`=tds.iddivision and rdst.idseason=pts.idseason
join divisions d on d.id=tds.iddivision
left join admrate_division_season_exceptions adse on adse.idplayer=pts.idplayer and adse.idseason=pts.idseason

where pts.idseason=$lastSeasonId  and statuspercent>70 and ispayed=0  and t.idclub not in (123,135)
order by prefix";
//echo $sql;
            $res = mysql_query($sql) or die(mysql_error());
            $numberOfCards = 0;
            $numberOfCardsXDivision = 0;
            $money = 0;
            $moneyTotal = 0;
            $moneyTotalReal = 0;
            $regTotal = 0;
            $rebTotal = 0;
            $reg = 0;
            $reb = 0;

            while ($row = mysql_fetch_array($res)) {

                if ($row['prefix'] != $name) {

                    $numberOfCardsXDivision = 0;

                    mysql_query("insert into cardStats (prefix, amount,euros, realEuros, regalades, rebaixades,rate) values ('" . $row['prefix'] . "', 0,0,0,0,0," . $row['rate'] . ")") or die(mysql_error());
                    //echo $row['prefix']."<br />";
                }
                if (isset($row['newRate'])) {
                    $r = $row['newRate'];
                    if ($r == 0) {
                        $reg = 1;
                        $reb = 0;
                    } else {
                        $reg = 0;
                        $reb = 1;
                    }
                } else {
                    $r = $row['rate'];
                    $reg = 0;
                    $reb = 0;
                }
                $moneyTotal = $moneyTotal + $row['rate'];
                $moneyTotalReal = $moneyTotalReal + $r;
                $numberOfCards++;
                $numberOfCardsXDivision++;
                $regTotal = $regTotal + $reg;
                $rebTotal = $rebTotal + $reb;

                $sql3 = "update cardStats set amount=amount+1, euros=euros+" . $row['rate'] . ", realEuros=realEuros+ $r, regalades=regalades+$reg, rebaixades=rebaixades+$reb where prefix='" . $row['prefix'] . "'";
//echo $sql3."<hr />";
                mysql_query($sql3) or die(mysql_error());

                $name = $row['prefix'];
            }

            $sql2 = "select * from cardStats";
            $res2 = mysql_query($sql2);
            while ($row2 = mysql_fetch_array($res2)) {
                echo "<tr><td>" . $row2['prefix'] . "</td><td>" . $row2['amount'] . "</td><td>" . $row2['rate'] . "</td><td>" . $row2['euros'] . " </td><td>" . $row2['realEuros'] . " </td><td>" . $row2['regalades'] . " </td><td>" . $row2['rebaixades'] . " </td></tr>";
            }
            echo "<tr><td style='color:#900; font-weight:bold; border-bottom: 3px solid #666;'>TOTAL</td><td style='color:#900; font-weight:bold; border-bottom: 3px solid #666;'>$numberOfCards</td><td style='color:#900; font-weight:bold; border-bottom: 3px solid #666;'>&nbsp;</td><td style='color:#900; font-weight:bold; border-bottom: 3px solid #666;'>$moneyTotal </td><td style='color:#900; font-weight:bold; border-bottom: 3px solid #666;'>$moneyTotalReal </td><td style='color:#900; font-weight:bold; border-bottom: 3px solid #666;'>$regTotal </td><td style='color:#900; font-weight:bold; border-bottom: 3px solid #666;'>$rebTotal </td></tr></table>";
            ?>
            </table>

        </div>
    </body>
