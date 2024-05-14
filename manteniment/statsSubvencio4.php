<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.2/bootstrap-table.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.2/bootstrap-table.min.js"></script>

<!-- Latest compiled and minified Locales -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.2/locale/bootstrap-table-zh-CN.min.js"></script>
<html>
    <table class="table table-striped table-bordered table-hover " width="100%">
        <thead class="thead-dark">
            <tr ><th>&nbsp;</th><?php
                include ("../manteniment/config.php");
                include ("../manteniment/funciones.php");
                $mysqli = conectar();
                $arrayLeagues = array();
                $idString = "43302";
                $lTotal = 0;
                $sql = "select distinct id,name from leagues where idSeason=10 ";
                $result = $mysqli->query($sql);
                while ($row = mysqli_fetch_array($result)) {

                    array_push($arrayLeagues, $row['id'] . "_" . $row['name']);
                }


                $arraySexes = array("M", "F");
                //$arrayEdats = array("<10", "in (10,11)", "in (12,13)", "in (14,15)", "in (16,17)", "in (18,19)", "in (20,21,22,23,24)", "in (25,26,27,28,29)", "in (30,31,32,33,34)", ">34");
                foreach ($arrayLeagues as $l) {
                    //  echo "\n\t\t<th colspan=2  class=\"text-center\">$l</th>";
                }
                //echo "\n\t\t<th colspan=2  class=\"text-center\">Total</th>";
                echo "\n\t</tr></thead><tbody >\n\t<tr class=\"table-dark\"><td>&nbsp;</td>";

                foreach ($arraySexes as $s) {
                    echo "\n\t\t<td class=\"text-center\">$s</td>";
                }

                foreach ($arrayLeagues as $e) {
                    $ptotal = 0;
                    $l = explode("_" , $e);
                      $l = explode("_" , $e);
                        $leagueId = $l[0];
                        $leagueName = $l[1];
                 
                    echo "\n\t</tr>\n\t<tr><td >$leagueName</td>";

                    foreach ($arraySexes as $s) {
                        $l = explode("_" , $e);
                        $leagueId = $l[0];
                        $leagueName = $l[1];
                        $sql2 = "SELECT distinct name, id FROM players WHERE id IN(SELECT p.id FROM players p
	JOIN player_team_season pts ON pts.idPlayer=p.id 
	JOIN teams_leagues_per_season tls ON tls.idTeam=pts.idTeam AND tls.idSeason=pts.idSeason
WHERE pts.idSeason=10 AND idLeague=" . $leagueId . " AND gender='" . $s . "') and id not in ($idString)";
//echo $sql2;
                        $result2 = $mysqli->query($sql2);
                        while ($row2 = mysqli_fetch_array($result2)) {
                            $lTotal ++;
                            $idString = $idString . "," . $row2['id'];
                            // echo $idString;
                        }
                        $total = $total + $lTotal;
                        //$ptotal = $ptotal + $result2->num_rows;
                        echo "\n\t\t<td align=center>$lTotal</td>";
                        $lTotal = 0;
                    }
                    $e = $p;
                } echo "<tr><td colspan=120 class='text-right'>Total: $total</td></tr>";
                ?>
                </tbody>
    </table>
</html>