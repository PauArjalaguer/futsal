<div class="newHeader">
    <h1 id="sectionTitle"> <span style='color:#600;'>> </span>
        <?
        $idMatch = $_GET['idMatch'];
        $sql = "select t1.id as idlocal, t1.name as local, t2.id as idvisitor,t2.name as visitor, localResult, visitorResult, updateddatetime, c1.image as localImage, c2.image as visitorImage, idseason, comment "
                . " from matches m "
                . "     join rounds ro on ro.id=m.idround "
                . "     join results r on r.idmatch=m.id "
                . "     join teams t1 on t1.id=m.idlocal "
                . "     join teams t2 on t2.id=m.idvisitor"
                . "     join clubs c1 on c1.id=t1.idclub"
                . "     join clubs c2 on c2.id=t2.idclub where m.id=" . $idMatch;
        //echo $sql;
        $res = mysql_query($sql);
        $row = mysql_fetch_array($res);
        echo "Acta partit $idMatch";
        $idSeason = $row['idseason'];
        $idVisitor = $row['idvisitor'];
        $comment=$row['comment'];
        ?>
    </h1>
</div>
<div>&nbsp;</div>
<div class="newContainer" style='width:960px; '>
    <?
    echo "\n\t<div style='width:150px; height:180px; float:left; margin-top:10px; border-top:0px solid; '><img src='http://www.futsal.cat/webImages/clubsImages/" . $row['localImage'] . "' height=150 /></div>";
    echo "\n\t<div style='float:left; width:240px;border-top:0px solid; text-align:right; font-size:30px; font-weight:bold; padding-right:10px; padding-top:60px; '><a href='" . $serverUrl . "equip/" . $row['idlocal'] . "-" . teamUrlFormat($row['local']) . "'>" . $row['local'] . "</a></div>";
    echo "\n\t<div style='width:160px; float:left;   font-size:50px; font-weight:bold; text-align:center; padding-top:60px; color:#900; border-top:0px solid;' > " . $row['localResult'] . "&nbsp; - &nbsp; " . $row['visitorResult'] . "</div> ";

    echo "\n\t<div style='float:left;  border-top:0px solid;width:240px; font-size:30px; font-weight:bold; padding-left:10px; padding-top:60px;'><a href='" . $serverUrl . "equip/" . $row['idvisitor'] . "-" . teamUrlFormat($row['visitor']) . "'>" . $row['visitor'] . "</a></div>";

    echo "\n\t<div style='width:150px; height:180px; float:left; text-align:right; border-top:0px solid; padding:0;'><img src='http://www.futsal.cat/webImages/clubsImages/" . $row['visitorImage'] . "' height=150/></div>";

    echo "\n<div style='clear:both; ;'></div>";
    echo "<div class='cupMatchLocal' style='width:470px;'>";
    $sql2 = "select * from player_goals_match pgm join players p on p.id=pgm.idplayer where idmatch=$idMatch and idTeam=" . $row['idlocal'] . " order by 0+minute";

    $res2 = mysql_query($sql2);
    while ($row2 = mysql_fetch_array($res2)) {
        echo $row2['name'] . " " . $row2['minute'] . "' <br />";
    }
    echo "</div>";
    echo "<div  class='cupMatchVisitor' style='width:470px;; margin-left:20px;'>";
    $sql2 = "select * from player_goals_match pgm join players p on p.id=pgm.idplayer where idmatch=$idMatch and idTeam=" . $row['idvisitor'] . " order by 0+minute";
    ;

   // echo $sql2;
    $res2 = mysql_query($sql2);
    while ($row2 = mysql_fetch_array($res2)) {
        echo $row2['name'] . " " . $row2['minute'] . "' <br />";
    }
    echo "</div>";
    echo "\n<div style='clear:both; ;'></div>"; 
    ?>

    <div style="width:340px; float:left; margin-top:15px; font-size:18px;">
        <table cellpadding='6' cellspacing='0' width=100% border=0>
            <th>&nbsp;</th>           
            <th style='text-align: center; width:12px;'>G</th>
            <th style='text-align: center; width:12px;'><div  style='background-color:#ffcc00;width:12px; '>&nbsp;</div></th>
            <th style='text-align: center; width:12px;'><div  style='background-color:#00b;width:12px;'>&nbsp;</div></th>

            <?
            $pos=""; $position="";
            $idTeam = $row['idlocal'];
            $sql = "select distinct "
                    . "p.name,"
                    . "(select count(number) from player_goals_match where idMatch=$idMatch and idPlayer=p.id and idTeam=$idTeam limit 0,1) as goals,"
                    . "(select yellowCards from player_card_match pcm where idMatch=$idMatch and idPlayer=p.id limit 0,1) as yellowCard,"
                    . " (select blueCards from player_card_match where idMatch=$idMatch and idPlayer=p.id limit 0,1) as blueCards,
                         pts.position,
                         (select idPosition from matches_players where idPlayer=p.id and idMatch=$idMatch and idTeam=$idTeam limit 0,1) as matchPosition,"
                    . "(select isCaptain from matches_players where idPlayer=p.id and idMatch=$idMatch and idTeam=$idTeam limit 0,1) as isCaptain,
                       pp.position,
                       pp2.position as teamPosition,
                       -- (select 0+number from matches_players where idPlayer=p.id and idMatch=$idMatch and idTeam=$idTeam limit 0,1) as number
                       mp.number
from matches_players mp
join matches m on m.id=mp.idmatch
join rounds r on r.id=m.idround
join players p on p.id=mp.idplayer
join player_team_season pts on pts.idplayer=p.id and pts.idseason=r.idseason
left join `playerPositions` pp on pp.id=mp.idposition
left join `playerPositions` pp2 on pp2.id=pts.position

where idmatch=$idMatch and mp.idteam=$idTeam
    order by  pp.position asc,number
 ";
            echo "<!-- $sql -->";
            $res = mysql_query($sql) or die(mysql_error());
            while ($row = mysql_fetch_array($res)) {
                if ($row['goals'] == 0) {
                    $row['goals'] = 0;
                }
                if ($row['yellowCard'] == 0) {
                    $row['yellowCard'] = 0;
                }
                if ($row['blueCards'] == 0) {
                    $row['blueCards'] = 0;
                }
                if ($row['isCaptain'] == 1) {
                    $c = " font-weight:bold; ";
                    $ca = "(C) ";
                }
                if ($row['position']) {
                    $position = $row['position'];
                } else {
                    $position = $row['teamPosition'];
                }
                if ($pos != $position) {
                    echo "<tr><td colspan=7 style='background-color:#900; color:#fff; font-weight:bold;'>$position</td></tr>";
                }
                $n = explode(" ", $row['name']);
                $name = $n[0] . " " . $n[1];
                if ($row['number'] == 0) {
                    $row['number'] = " ";
                }
                echo "<tr>";
                echo "\n\t<td style='border-bottom:1px solid #424242;$c; font-family:'Trebuchet Ms'>" . $row['number'] . " $ca " . substr($name, 0, 55) . " </td>";
                echo "\n\t<td align=center style='border-bottom:1px solid #424242;$c'>" . $row['goals'] . "</td>";
                echo "\n\t<td align=center style='border-bottom:1px solid #424242;$c'>" . $row['yellowCard'] . "</td>";
                echo "\n\t<td align=center style='border-bottom:1px solid #424242;$c'>" . $row['blueCards'] . "</td></tr>";
                $pos = $position;
                $c = "";
                $ca = "";
            }
            ?> 
        </table>
    </div>
    <div style='width:260px; float:left; margin:0 10px; font-size:18px;margin-top:15px;'>
        <table cellpadding='6' cellspacing='0' width=100% border=0><tr><td>&nbsp;</td></tr><tr>
                <th style='background-color:#900; color:#fff; font-weight:bold;'>&Agrave;rbitres</th>           </tr>


            <?
             $pos=""; $position="";
            $idTeam = $row['idlocal'];
            $sql = "select r.name, refereeTypeName from cmptMatch_Referee mr
join rfrReferees r on r.id=mr.idreferee
join rfrRefereeTypes t on t.id=mr.idRefereeType
where idmatch=$idMatch 
 ";
            echo "<!-- $sql -->";
            $res = mysql_query($sql) or die(mysql_error());
            while ($row = mysql_fetch_array($res)) {

                echo "<tr>";
                echo "\n\t<td style='border-bottom:1px solid #424242;$c; font-family:'Trebuchet Ms'>" . substr($row['name'], 0, 35) . " (" . $row['refereeTypeName'] . ")</td></tr>";

                $pos = $position;
                $c = "";
                $ca = "";
            }
            ?> 
        </table>
    </div>
    <div style="width:340px;float:left;font-size:18px; margin-top:15px; ">
        <table cellspacing=0 cellpadding='6' width=100%>

            <th>&nbsp;</th>           
            <th style='text-align: center; width:12px;'>G</th>
            <th style='text-align: center; width:12px;'><div  style='background-color:#ffcc00;width:12px; '>&nbsp;</div></th>
            <th style='text-align: center; width:12px;'><div  style='background-color:#00b;width:12px;'>&nbsp;</div></th>

            <?
            $idTeam = $idVisitor;
            $sql = "select distinct  "
                    . "p.name,"
                    . "(select count(number) from player_goals_match where idMatch=$idMatch and idPlayer=p.id and idTeam=$idTeam limit 0,1) as goals,"
                    . "(select yellowCards from player_card_match pcm where idMatch=$idMatch and idPlayer=p.id limit 0,1) as yellowCard,"
                    . " (select blueCards from player_card_match where idMatch=$idMatch and idPlayer=p.id  limit 0,1) as blueCards,
                         pts.position,
                         (select idPosition from matches_players where idPlayer=p.id and idMatch=$idMatch and idTeam=$idTeam limit 0,1) as matchPosition,"
                    . "(select isCaptain from matches_players where idPlayer=p.id and idMatch=$idMatch and idTeam=$idTeam limit 0,1) as isCaptain,
                       pp.position,
                       pp2.position as teamPosition,
                       -- (select 0+number from matches_players where idPlayer=p.id and idMatch=$idMatch and idTeam=$idTeam limit 0,1) as number
                       mp.number
                       

            
         from matches_players mp
join matches m on m.id=mp.idmatch
join rounds r on r.id=m.idround
join players p on p.id=mp.idplayer
join player_team_season pts on pts.idplayer=p.id and pts.idseason=r.idseason
left join `playerPositions` pp on pp.id=mp.idposition
left join `playerPositions` pp2 on pp2.id=pts.position

where idmatch=$idMatch and mp.idteam=$idTeam
    order by  pp.position asc, number
 ";
            echo "<!-- $sql -->";
            $res = mysql_query($sql) or die(mysql_error());
            while ($row = mysql_fetch_array($res)) {
                if ($row['goals'] == 0) {
                    $row['goals'] = 0;
                }
                if ($row['yellowCard'] == 0) {
                    $row['yellowCard'] = 0;
                }
                if ($row['blueCards'] == 0) {
                    $row['blueCards'] = 0;
                }
                if ($row['isCaptain'] == 1) {
                    $c = " font-weight:bold; ";
                    $ca = "(C) ";
                }
                if ($row['position']) {
                    $position = $row['position'];
                } else {
                    $position = $row['teamPosition'];
                }
                if ($pos != $position) {
                    echo "<tr><td colspan=7 style='background-color:#900; color:#fff; font-weight:bold;'>$position</td></tr>";
                }
                $n = explode(" ", $row['name']);
                $name = $n[0] . " " . $n[1];
                if ($row['number'] == 0) {
                    $row['number'] = " ";
                }
                echo "<tr>";
                echo "\n\t<td style='border-bottom:1px solid #424242;$c; font-family:'Trebuchet Ms'>" . $row['number'] . " $ca " . substr($name, 0, 55) . "</td>";
                echo "\n\t<td align=center style='border-bottom:1px solid #424242;$c'>" . $row['goals'] . "</td>";
                echo "\n\t<td align=center style='border-bottom:1px solid #424242;$c'>" . $row['yellowCard'] . "</td>";
                echo "\n\t<td align=center style='border-bottom:1px solid #424242;$c'>" . $row['blueCards'] . "</td></tr>";
                $pos = $position;
                $c = "";
                $ca = "";
            }
            ?> 
        </table>
    </div>

    

</div>
<div style='clear:both;'>&nbsp;</div>
<p><? //echo nl2br(utf8_decode($commaent)); ?></p>