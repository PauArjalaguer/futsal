<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$_GET['idLeague']."_calendari.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table width=100% border=1><thead><th>Jornada</th><th>Local</th><th>Visitant</th><th>Resultat</th><th>Pavell&oacute;</th><th>Adre&ccedil;a</th><th>Data</th><th>Lliga</th></thead><tbody>
    <?php
    include "config.php";
    include "funciones.php";
    $mysqli = conectar();
    $sql = "SELECT 
            t1.name as local,
            t2.name as visitor,
            localResult,
            visitorResult,
            m.id as idMatch,
            m.statusId,
            0,
            t1.id as idLocal,
            t2.id as idVisitor,
            m.datetime,
            (select idnew from news_match where idmatch=m.id) as news,
            c1.image as localImage,
            c2.image as visitorImage,
            m.complexName,
            m.complexAddress,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
        r.name as roundName,
        m.updateddatetime,
        date_format(m.updateddatetime,'%j'),
        date_format(m.updateddatetime,'%j'),
		l.name as league
		
    FROM futsal.matches m
join teams t1 on t1.id=m.idLocal
join teams t2 on t2.id=m.idvisitor
join clubs c1 on c1.id=t1.idclub
join clubs c2 on c2.id=t2.idclub
left join complex cl on cl.id=m.place
join rounds r on r.id=m.idround
join leagues l on l.id=r.idleague
join divisions d on d.id=l.iddivision
left join results re on re.idMatch=m.id
 where  updateddatetime>now()  and 
 hide=0 and updateddatetime<'".$_GET['date']."' and l.idSeason=10
 order by updateddatetime asc";
    $res = $mysqli->query($sql);
    while ($row = mysqli_fetch_array($res)) {
        echo "\n<tr>\n\t<td>Jornada ";
        echo $row['roundName'];
        echo "\n\t</td>";
        echo "\n\t<td>";
        echo utf8_decode(ucwords(mb_strtolower($row['local'])));
        echo "\n\t</td>";
        echo "\n\t<td>";
        echo utf8_decode(ucwords(mb_strtolower($row['visitor'])));
        echo "\n\t</td>";
        echo "<td>".$row['localResult']." - ".$row['visitorResult']."</td>";
        echo "\n\t<td>";
        echo utf8_decode(ucwords(mb_strtolower($row['complexName'])));
        echo "\n\t</td>";
        echo "\n\t<td>";
        echo utf8_decode(ucwords(mb_strtolower($row['complexAddress'])));
        echo "\n\t</td>";
		
        echo "\n\t<td>";
        echo $row['updateddatetime'];
        echo "\n\t</td>";
		 echo "\n\t<td>";
        echo utf8_decode(ucwords(mb_strtolower($row['league'])));
        echo "\n\t</td>";
        echo "\n</tr>";
    }
    ?>
</tbody>
</table>

