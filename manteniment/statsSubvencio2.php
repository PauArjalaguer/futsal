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
            <tr ><th>Club</th><th>Municipi</th><th>Homes</th><th>Dones</th></tr></thead>
        <tbody><?php
            include ("../manteniment/config.php");
            include ("../manteniment/funciones.php");
            $mysqli = conectar();
            $arrayClubs = array();

            $sql = "SELECT id,name, city FROM clubs WHERE id IN (
SELECT idClub FROM teams_leagues_per_season tls JOIN teams t ON t.id=tls.idTeam WHERE idSeason=10) ORDER BY name";
            $result = $mysqli->query($sql);
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td>" . $row['name'] . "</td>";
                echo "<td>" . $row['city'] . "</td>";

                $sqlH = "SELECT DISTINCT NAME, dni, birthdate, city,province,YEAR(curdate())-YEAR(`birthdate`) FROM players WHERE id IN (
SELECT idPlayer FROM player_team_season pts WHERE gender='M' and idSeason=10 AND idTeam IN (SELECT id FROM teams WHERE idClub=".$row['id']."))
ORDER BY NAME";
                $resultH = $mysqli->query($sqlH);
                $total = $total + $resultH->num_rows;
                echo "\n\t\t<td align=center>$resultH->num_rows</td>";
                
                
                
                $sqlF = "SELECT DISTINCT NAME, dni, birthdate, city,province,YEAR(curdate())-YEAR(`birthdate`) FROM players WHERE id IN (
SELECT idPlayer FROM player_team_season pts WHERE gender='F' and idSeason=10 AND idTeam IN (SELECT id FROM teams WHERE idClub=".$row['id']."))
ORDER BY NAME";
                $resultF = $mysqli->query($sqlF);
                $total = $total + $resultF->num_rows;
                echo "\n\t\t<td align=center>$resultF->num_rows</td>";
                echo "</tr>";
            }
            echo "<tr><td colspan=120 class='text-right'>Total: $total</td></tr>";
            ?>
        </tbody>
    </table>
</html>