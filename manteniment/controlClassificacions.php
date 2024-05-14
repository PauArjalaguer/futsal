<?php
ini_set("auto_detect_line_endings", "1");
include "config.php";
include "funciones.php";
$mysqli = conectar();
?>
<html>
    <head>
        <script>function updateClassification(idRound) {
                document.getElementById("round_" + idRound).innerHTML = "<img src='http://ajaxloadingimages.net/gif/image?imageid=dot-spinner&forecolor=000000&backcolor=ffffff'>";
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("round_" + idRound).innerHTML = "Ok";
                    }
                };
                xhttp.open("GET", "../playOff/apiClassificacions.php?debug=1&reset=1&idRound=" + idRound, true);
                xhttp.send();
            }</script>
        <style>
            td{ padding:2px; font-size:  12px;font-family: 'Roboto Condensed', sans-serif;}
        </style>        
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" type="text/css"
              href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
        <meta charset="UTF-8">
        <title>Control Partits FCFS</title>
    </head>
    <body>
        <table id="myTable" width="100%" class="table"><thead>
                <tr>

                    <th>Lliga</th>
                    <th>Jornada</th>
                    <th>Data</th>
                    <th>Última actualització</th>

                </tr></thead><tbody>
                <?php
                $sql = "SELECT distinct r.id,l.name as league, r.id,r.name,r.initialDate, c.`updatedDateTime`,datediff(now(),updatedDateTime) AS days  FROM classification_v2 c
	RIGHT JOIN rounds r ON r.id=c.idRound
	RIGHT JOIN leagues l ON l.id=c.idLeague
WHERE r.idSeason=10
ORDER BY updatedDateTime asc";
                $res = $mysqli->query($sql) or die(mysqli_error($mysqli));
                while ($row = mysqli_fetch_array($res)) {
                    echo "<tr>";

                    echo "\n\t<td> " . $row['league'] . "</td>";
                    echo "\n\t<td> Jornada " . $row['name'] . "</td>";
                    echo "<td>" . $row['initialDate'] . "</td>";
                    echo "<td>" . $row['updatedDateTime'] . "</td>";
                    echo "\n\t<td id='round_" . $row['id'] . "' onClick='updateClassification(" . $row['id'] . ")'>" . $row['days'] . " dies</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>