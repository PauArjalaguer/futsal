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
                $arrayProvincies = array();

                $sql = "select distinct province from players p join player_team_season pts on pts.idPlayer=p.id where idSeason=10";
                $result = $mysqli->query($sql);
                while ($row = mysqli_fetch_array($result)) {
//echo $row['province'];
                    array_push($arrayProvincies,$row['province']);
                }
                

                $arraySexes = array("M", "F");
                $arrayEdats = array("<10", "in (10,11)", "in (12,13)", "in (14,15)", "in (16,17)", "in (18,19)", "in (20,21,22,23,24)", "in (25,26,27,28,29)", "in (30,31,32,33,34)", ">34");
                foreach ($arrayProvincies as $p) {
                    echo "\n\t\t<th colspan=2  class=\"text-center\">$p</th>";
                }
                //echo "\n\t\t<th colspan=2  class=\"text-center\">Total</th>";
                echo "\n\t</tr></thead><tbody >\n\t<tr class=\"table-dark\"><td>&nbsp;</td>";
                foreach ($arrayProvincies as $p) {
                    foreach ($arraySexes as $s) {
                        echo "\n\t\t<td class=\"text-center\">$s</td>";
                    }
                }

                foreach ($arrayEdats as $e) {
                    $ptotal = 0;
                    echo "\n\t</tr>\n\t<tr><td >$e</td>";
                    foreach ($arrayProvincies as $p) {
                        foreach ($arraySexes as $s) {

                            // echo "<hr />$p $s $e (";


                            $sql = "SELECT DISTINCT NAME, dni, birthdate, province,YEAR(curdate())-YEAR(`birthdate`) FROM players WHERE id IN (
SELECT idPlayer FROM player_team_season pts JOIN players p ON p.id=pts.idPlayer WHERE gender='" . $s . "' and idSeason=10 AND p.province='" . $p . "' AND (YEAR(curdate())-YEAR(`birthdate`)) $e)
ORDER BY NAME";
                            //echo $sql;
                            $result = $mysqli->query($sql);
                            $total = $total + $result->num_rows;
                            $ptotal = $ptotal + $result->num_rows;
                            echo "\n\t\t<td align=center>$result->num_rows</td>";
                        }
                    }
                    $province = $p;
                } echo "<tr><td colspan=120 class='text-right'>Total: $total</td></tr>";
                ?>
                </tbody>
    </table>
</html>