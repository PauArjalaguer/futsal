<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="X-UA-Compatible" content="IE=8"/>
        <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

        <style>
            html, body{ margin:0; padding:0;font-family: Helvetica,Trebuchet Ms, Verdana;}
            table{padding:0; margin: 0; }
            th, .referees{background-color: #424242; color:#fff;}
            .cell{ border:1px solid #ccc; border-top:0; border-left:0;}</style>
    </head>
    <body><?php
        include ("../includes/config.php");
        include ("../includes/funciones.php");
        conectar();

        $lastSeason = lastSeason();
        $lastSeasonId = $lastSeason [0];
        $lastSeasonName = $lastSeason [1];

        if (isset($_GET['idLeague'])) {
            if(!$_GET['type']){
                $_GET['type']=1;
            }

            $arrayTeams = array();
            $sqlTeams = "select id, name from teams t 
join teams_leagues_per_season tds on t.id=tds.idteam
where idseason=$lastSeasonId and idleague=" . $_GET['idLeague'] . "
order by name";
            //echo $sqlTeams;
            $resTeams = mysql_query($sqlTeams) or die(mysql_error());
            while ($row = mysql_fetch_array($resTeams)) {
                array_push($arrayTeams, $row);
            }

            echo "\n<table cellpadding=5  cellspacing=0>\n\t<tr>\n\t\t<th>";
            echo "<select id='leagueSelector'><option>&nbsp;</option>";
            $sql = "select distinct l.id, l.name from leagues l
join divisions d on d.id=l.iddivision
where idseason=$lastSeasonId order by l.name";
            $res = mysql_query($sql) or die(mysql_error());
            while ($row = mysql_fetch_array($res)) {
                if ($_GET['idLeague'] == $row['id']) {
                    $sel = "selected";
                } else {
                    $sel = "";
                }
                echo "\n\t<option $sel value=\"?idLeague=" . $row['id'] . " \"/>" . $row['name'] . "</a> </option>";
            }
            echo "</select>";
            echo "<select style='width:100%' id='typeSelector'><option value=\"?idLeague=" . $_GET['idLeague'] . "\">&nbsp;</option>";
            if ($_GET['type'] == 1) {
                $sel1 = "selected";
                $sel2 = "";
            }
            if ($_GET['type'] == 2) {
                $sel2 = "selected";
                $sel1 = "";
            }
            echo "\n\t<option $sel1 value=\"?idLeague=" . $_GET['idLeague'] . "&type=1\"/>Arbitre</a> </option>";
            echo "\n\t<option $sel2 value=\"?idLeague=" . $_GET['idLeague'] . "&type=2\"/>Taula</a> </option>";

            echo "</select>";
            echo "</th>";

            foreach ($arrayTeams as $teams) {
                echo "\n\t\t<th nowrap>" . $teams[1] . "</th>";
            }
            echo "\n\t</tr>";
            $sqlReferee = "Select id, name, province FROM rfrReferees order by name asc";
            $sqlReferee = "Select distinct re.id, re.name, province FROM rfrReferees re
join cmptMatch_Referee cmr on cmr.idreferee=re.id
join matches m on m.id=cmr.idmatch
join rounds r on r.id=m.idround
where idleague=" . $_GET['idLeague'];
            if($_GET['type']){ $sqlReferee .=" and cmr.idRefereeType=".$_GET['type'];}
$sqlReferee .=" order by name asc";
            $resReferee = mysql_query($sqlReferee) or die(mysql_error());
            while ($row2 = mysql_fetch_array($resReferee)) {
                echo "\n\t<tr>\n\t\t<td nowrap class='referees'>" . $row2['name'] . "</td>";
                foreach ($arrayTeams as $teams) {
                    $sqlRecusations = "select idTeam from rfrRefereesRecusedByIdTeam where idReferee=" . $row2['id'] . " and idTeam=" . $teams[0];
                    
                    $resRecusations = mysql_query($sqlRecusations) or die(mysql_error());
                    $recused = mysql_num_rows($resRecusations);
                    //echo $sqlRecusations ." -- ". $recused."<br />";


                    $sqlMatches = "select count(*) as count from cmptMatch_Referee cmr
join matches m on m.id=cmr.idmatch
join rounds r on r.id=m.idround
where idRefereeType=1 and idseason=$lastSeasonId and idreferee=" . $row2['id'] . " and (idlocal=" . $teams[0] . " or idvisitor=" . $teams[0] . ")";
                    $resMatches = mysql_query($sqlMatches) or die(mysql_error());
                    $row3 = mysql_fetch_array($resMatches);

                    $sqlMatchesTable = "select count(*) as count from cmptMatch_Referee cmr
join matches m on m.id=cmr.idmatch
join rounds r on r.id=m.idround
where idRefereeType=2 and  idseason=$lastSeasonId and idreferee=" . $row2['id'] . " and (idlocal=" . $teams[0] . " or idvisitor=" . $teams[0] . ")";
                    $resMatchesTable = mysql_query($sqlMatchesTable) or die(mysql_error());
                    $row4 = mysql_fetch_array($resMatchesTable);

                    if ($_GET['type'] == 1) {
                        $msg = $row3['count'];
                        $suma = $row3['count'];
                    } else if ($_GET['type'] == 2) {
                        $msg = $row4['count'];
                        $suma = $row4['count'];
                    } else {
                        $msg = $row3['count'] . "/" . $row4['count'];
                        $suma = $row3['count'] + $row4['count'];
                    }


                    if ($suma == 3) {
                        $c = "#FF0000";
                    } else if ($suma == 4) {
                        $c = "#E50000";
                    } else if ($suma == 5) {
                        $c = "#7F0000";
                    } else if ($suma > 5) {
                        $c = "#400000";
                    } else {
                        $c = "transparent";
                    }

                    if($recused==0){
                      $fc="";
                        $rec="<img style='cursor:pointer;' src='http://www.futsal.cat/administration/images/accept.png' onClick=\"rfrRecusationStatusChange('insert'," . $row2['id'] . "," . $teams[0] . ",'" . addslashes($row2['name']) . "','" . addslashes($teams[1]) . "');\" />";
                    }else{
                         $c="#000";
                         $fc="#fff";
                        $rec="<img style='cursor:pointer;' src='http://www.futsal.cat/administration/images/cross.png' onClick=\"rfrRecusationStatusChange('delete'," . $row2['id'] . "," . $teams[0] . ",'" . addslashes($row2['name']) . "','" . addslashes($teams[1]) . "');\" />";
                 
                    }
                    echo "\n\t\t<td align=center class=cell style='background-color:$c; color:$fc;' >$msg $rec</td>";
                }


                echo "</tr>";
            }
            echo "</th>";

            echo "</table>";
        } else {
            echo "<select id='leagueSelector'><option>&nbsp;</option>";
            $sql = "select distinct l.id, l.name from leagues l
join divisions d on d.id=l.iddivision
where idseason=$lastSeasonId order by l.name";
            $res = mysql_query($sql) or die(mysql_error());
            while ($row = mysql_fetch_array($res)) {
                echo "\n\t<option value=\"?idLeague=" . $row['id'] . " \"/>" . $row['name'] . "</a> </option>";
            }
            echo "</select>";
        }
        ?>
    </body>
</html>
<script>
    $('#leagueSelector').bind('change', function () { // bind change event to select
        var url = $(this).val(); // get selected value
        if (url != '') { // require a URL
            window.location = url; // redirect
        }
        return false;
    });
    $('#typeSelector').bind('change', function () { // bind change event to select
        var url = $(this).val(); // get selected value
        if (url != '') { // require a URL
            window.location = url; // redirect
        }
        return false;
    });
    
    function rfrRecusationStatusChange(option, idReferee, idTeam, referee, team){
        var action="";
        if(option=="insert"){
            action=" afegir";
        }else{
            action ="treure";
        }
        var c=confirm("Vols "+action +" recusació a "+ referee+" per a "+ team+"?");
        if(c==true){
           window.location = "rfrRecusationStatusChange.php?idTeam="+idTeam+"&idReferee="+idReferee+"&action="+option+"&href="+window.location.href; 
        }
    }
</script>
