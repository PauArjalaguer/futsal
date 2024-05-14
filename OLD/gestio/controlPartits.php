<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Control partits</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>


        <table id="example" class="table table-hover table-condensed table-striped table-bordered" data-page-length='100'>
            <thead><tr>
                   <th>Arbitre</th>
<th>Data</th>
                    <th>LLiga</th>
                    <th>Jor.</th>
                    <th>Partit</th>
<th>Preu</th>
<th>KM</th>
<th>Dieta</th>
</tr>
            </thead>
            <tbody>
                <?php
//echo $_GET['idMatch'];
                include ("../includes/config.php");
                include ("../includes/funciones.php");
                conectar();
                $lastSeason = lastSeason();
                $lastSeasonId = $lastSeason[0];
                $lastSeasonName = $lastSeason[1];

                $sql = "select l.name, r.name, t1.name, t2.name, rr.name, updateddatetime,price, allowance,km from matches m
join teams t1 on t1.id=m.idlocal
join teams t2 on t2.id=m.idvisitor
join rounds r on r.id=m.idround
join leagues l on l.id=r.idleague
left join cmptMatch_Referee cmr on cmr.idmatch=m.id
left join rfrReferees rr on rr.id=cmr.idreferee
left join rfrPricePerRefereeByDivisionAndSeason rpds on rpds.`idDivision`=l.idDivision and rpds.idseason=l.idseason and rpds.`idRefereeType`=cmr.`idRefereeType`
where l.idseason=8 and updateddatetime!='0000-00-00 00:00:00'

 order by m.updateddatetime, m.id
 limit 0,15000";
                $res = mysql_query($sql) or die(mysql_error());
                if (mysql_num_rows($res) >= 1) {
                    while ($row = mysql_fetch_row($res)) {
                        echo "<tr><td>" . utf8_encode($row[4]) . "</td><td align=center>" . $row[5] . "</td><td>" . utf8_encode($row[0]) . "</td><td>" . $row[1] . "</td><td>" . utf8_encode($row[2]) . " - " . utf8_encode($row[3]) . "</td><td>" . $row[6] . " &euro; </td><td>" . $row[8] . " &euro;</td><td>" . $row[7]."</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </body></html>
<script type="text/javascript" charset="utf-8">

	$(document).ready(function() 
	{
		$('#example').dataTable();   
});

</script>	