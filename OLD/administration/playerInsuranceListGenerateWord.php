<?php

Header ( "Content-type: application/vnd.ms-word" );
Header ( "Content-Disposition: filename=" . $_GET ['idTeam'] . ".doc" );
$fp = fopen ( "insuranceLists/" . $_GET ['idTeam'] . ".doc", "w" );

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar ();
$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];
$sql = "select
distinct p.id,
p.name, p.birthdate, p.dni, p.nif, t.name as teamName, c.name as clubName, s.name as seasonName, d.name as divisionName,pp.position as positionName
from players p
join player_team_season pts on pts.idplayer=p.id
join teams t on t.id=pts.idteam
join clubs c on c.id=t.idclub
join seasons s on s.id=pts.idseason
join teams_divisions_per_season td on td.idteam=t.id
join divisions d on d.id=td.iddivision

join playerPositions pp on pp.id=pts.position
where pts.idTeam=" . $_GET ['idTeam'] . " and isPayed=1 and pts.idseason=$lastSeasonId ";

if ($_GET ['datetime']) {
	$sql .= " and p.id  in (select idplayer from playerInsuranceListByIdSeason where idSeason=$lastSeasonId and idTeam=" . $_GET ['idTeam'] . " and datetime='" . $_GET ['datetime'] . "')";
} else {
	$sql .= " and p.id not in (select idplayer from playerInsuranceListByIdSeason where idSeason=$lastSeasonId) ";
}
$sql .= " order by pts.position";

//echo $sql;
$res = mysql_query ( $sql ) or die ( mysql_error () );

$row = mysql_fetch_array ( $res );
?>

<style>
table {
	font-family: Arial;
	font-size: 16px;
	vertical-align: top;
}

h1 {
	text-decoration: underline;
	font-size: 24px;
}

h2 {
	font-size: 20px;
}

th {
	font-weight: bold;
	text-transform: uppercase;
	border-bottom: 1px solid #424242;
}

.bottom {
	border-bottom: 1px solid #424242;
}

.left {
	border-left: 1px solid #424242;
}

.right {
	border-right: 1px solid #424242;
}
</style>
<table cellpadding="6" cellspacing="0" border="0" width="100%">
	<tr>
		<td rowspan="2"><img
			src="http://www.futsal.cat/webImages/logoPetit.png" width="100" /></td>
		<td colspan="3">
		<h2>FEDERACI� CATALANA DE FUTBOL SALA</h2>
		</td>

	</tr>
	<tr>
		<td colspan="3" style="font-size: 12px;">CIF: G17102823<br />
		APROVADA I INSCRITA PER LA SECRETARIA GRAL.DE L'ESPORT<br />
		REGISTRE N�M. 4.604 - 5 MAIG 1986</td>

	</tr>
	<tr>
		<td>&nbsp</td>
	</tr>
	<tr>
		<td>&nbsp</td>
	</tr>
	<tr>
		<td colspan="4" align="center">
		<h1>PRESENTACI� DE LLIC�NCIES <br />
		MUTUALITAT</h1>
		</td>
	</tr>
	<tr>
		<td>&nbsp</td>
	</tr>

	<tr>
		<td colspan="4" align="center">&nbsp;</td>
	</tr>
	<tr>
		<td>Equip:</td>
		<td><strong style="font-size: 14px; text-transform: uppercase;"><?
		echo $row ['teamName'];
		?></strong></td>
		<td>Competici�:</td>
		<td><strong><?
		echo $row ['divisionName'];
		?></strong></td>

	</tr>
	<tr>
		<td>Data presentaci�:</td>
		<td><strong><?
		if ($_GET ['datetime']) {
			$date = explode(" ",$_GET['datetime']);
			$d=explode("-",$date[0]);
			echo $d[2]."-".$d[1]."-".$d[0];
		} else {
			echo date ( "d-m-Y" );
		
        }
        ?></strong></td>
		<td>Temporada:</td>
		<td><strong><? echo $row['seasonName']; ?></strong></td>
	</tr>
	<tr>

	</tr>

	<tr>
		<td>&nbsp;</td>
	
	
	<tr>
		<td colspan="4">
		<table cellspacing="0" cellpadding="6" width="100%" border="0">
			<tr>
				<th>N�</th>
				<th align="left">Nom</th>
				<th>DNI</th>
				<th>Data naix.</th>
			</tr>

                <?
                $n = 1;
                $a = 1;
                $res = mysql_query($sql) or die(mysql_error());
                while ($row = mysql_fetch_array($res)) {
                    if ($a == 1) {
                        $bkg = " style='background-color:#fafafa;' ";
                        $a++;
                    } else {
                        $bkg = " style='background-color:#fff;' ";
                        $a = 1;
                    }
                    $b = explode("-", $row['birthdate']);
                    $birthdate = $b[2] . "/" . $b[1] . "/" . $b[0];

                    if ($row['positionName'] == 'Jugador') {
                        $pos = $n;
                    } else {
                        $pos = substr($row['positionName'], 0, 3);
                    }
                    echo "<tr ><td $bkg class='bottom left' align=center>$pos</td><td $bkg class='bottom'>" . $row['name'] . "</td><td $bkg class='bottom' align=center>" . $row['dni'] . "-" . $row['nif'] . "</td><td $bkg class='bottom right' align=center>$birthdate</td></tr>";
                    $n++;

                    if (!$_GET['datetime']) {
                        mysql_query("insert into playerInsuranceListByIdSeason
        (idPlayer,idTeam,idSeason, datetime) values
        (" . $row['id'] . "," . $_GET['idTeam'] . ",$lastSeasonId,now())");
                    }
                }
                ?>

            </table>
		</td>
	</tr>
	<tr>
		<td colspan="6" style='font-size: 10px;'>C/Guipuscoa 23-25 5� D ? 08018
		Barcelona | Tel. 93 244 44 03 Fax. 93 247 34 83 |

		futsal@futsal.cat www.futsal.cat</td>
	</tr>

</table>


<?
                fwrite($fp, $out);
                fclose($fp);
?>
