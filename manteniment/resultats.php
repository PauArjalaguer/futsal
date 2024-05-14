<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css"
      href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />

<body>
    <table id="myTable">
        <thead>
            <tr>
                <th>Data</th>
                <th>Partit</th>
                <th>Lliga</th>
                <th>Jornada</th>
                <th>Resultat</th>
                <th>&nbsp;</th>

        </thead>
        <?php
        include ("config.php");
        include ("funciones.php");
        $mysqli = conectar();
        //echo "<pre>";print_r(get_defined_vars()); echo "</pre>";

        if ($_POST['submit']) {
            $sql = "Insert into results values (null," . $_POST['local'] . "," . $_POST['visitor'] . "," . $_POST['match'] . ",1,now(),null)";
            $mysqli->query($sql);
        }

        $sql = "select m.id, t.name as local, t2.name as visitor, r.name as round, l.name as league, updateddatetime, s.name as season from matches m "
                . "join rounds r on r.id=m.idround "
                . "join teams t on t.id=m.idLocal "
                . "join teams t2 on t2.id=m.idVisitor "
                . "join leagues l on l.id=r.idLeague "
                . "where ";
        if ($_GET['old'] != 1) {
           // $sql .= " datediff(now(),updateddatetime)<5 and ";
        }
        $sql .= " l.idSeason>7  and statusid  in(1,4) and updateddatetime!='0000-00-00 00:00:00' and m.id not in (select idmatch from results) order by l.id, r.id";
$sql="select  m.id, t1.name as local, t2.name as visitor, r.name as round, l.name as league, updateddatetime, s.name as season
from matches m
	left join results re on re.idMatch=m.id
    join rounds r on r.id=m.idRound
    join leagues l on l.id=r.idLeague
    join teams t1 on t1.id=m.idLocal
    join teams t2 on t2.id=m.idVisitor
    join seasons s on s.id=l.idSeason
where localResult is null and l.idSeason>7
order by l.id, r.id
";

        $res = $mysqli->query($sql);
        while ($row = mysqli_fetch_array($res)) {
            echo "\n\t<tr>";
            echo "\n\t\t<td>" . $row['updateddatetime'] . "</td>";
            echo "\n\t\t<td>" . $row['local'] . " - " . $row['visitor'] . "</td>";
            echo "\n\t\t<td>" . $row['season']." ".$row['league'] . "</td>";
            echo "\n\t\t<td>Jornada " . $row['round'] . "</td>";
            echo "\n\t\t<form action=\"resultats.php\" method=\"post\">";
            echo "\n\t\t<td><input type=\"number\" name=\"local\"> - <input type=\"number\" name=\"visitor\"><input name=\"match\" type=\"hidden\" value=\"" . $row['id'] . "\"></td>";
            echo "\n\t\t<td><input type=\"submit\" name=\"submit\" value=\"Enviar\"></form></td>";
            echo "\n\t</tr>";
        }
        ?>
    </table>
</body>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({"pageLength": 500});

    });
</script>

