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
            <tr ><th>Provincia</th><th>Municipi</th><th>Clubs</th></tr></thead>
        <tbody><?php
            include ("../manteniment/config.php");
            include ("../manteniment/funciones.php");
            $mysqli = conectar();
            $arrayClubs = array();

            $sql = "SELECT distinct city, province FROM clubs WHERE id IN (
SELECT idClub FROM teams_leagues_per_season tls JOIN teams t ON t.id=tls.idTeam WHERE idSeason=10) ORDER BY province desc, city asc";
            $result = $mysqli->query($sql);
            while ($row = mysqli_fetch_array($result)) {
                 $sqlF = "SELECT name FROM clubs WHERE id IN (
SELECT idClub FROM teams_leagues_per_season tls JOIN teams t ON t.id=tls.idTeam WHERE idSeason=10) and city='".addslashes($row['city'])."' ORDER BY province desc, city asc";
              
                 $resultF = $mysqli->query($sqlF);
            
                echo "<tr><td>".$row['province']."</td><td>".$row['city']."</td><td>".$resultF->num_rows."</td></tr>";
               
               
            }
           
            ?>
        </tbody>
    </table>
</html>