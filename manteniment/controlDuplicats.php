<table cellpadding="6" cellspacing="0"><?php
include "../manteniment/config.php";
include "../manteniment/funciones.php";
$mysqli = conectar();


    $sql = "select p.id, idTeam, dni, p.name as player, t.name as team, pts.id as idCard from player_team_season pts join players p on p.id=pts.idPlayer join teams t on t.id=pts.idTeam where idSeason=10 order by dni asc, t.id asc";

    $res = $mysqli->query($sql) or die(mysqli_error($mysqli));
    while ($row = mysqli_fetch_array($res)) {
        if ($dni == $row['dni'] and $idPlayer == $row['id'] and $idTeam == $row['idTeam']) {
            $c = " style='background-color:#c00;'";
             $sql2 = "delete from player_team_season where id=" . $row['idCard'];
            //$mysqli->query($sql2);
            echo "<tr><td colspan=7>$sql2</td></tr>";
            $n++;
        } else {
            $c = "";
           
        }
        echo "<tr><td $c>" . $row['player'] . "</td><td $c>" . $row['team'] . "</td><td $c>" . $row['dni'] . "</td></tr>";
        $dni = $row['dni'];
        $idPlayer = $row['id'];
        $idTeam = $row['idTeam'];
    }
    
    echo "S' han esborrat $n resultats";
    
    