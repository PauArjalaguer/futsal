<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css"
      href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
<script>
    function classificationPositionUpdate (position,idleague) {
        var name=document.getElementById("name_"+position+"_"+idleague).value;
        var classN=document.getElementById("class_"+position+"_"+idleague).value;
        
      //  alert (name+" "+classN+" "+position);
        $.ajax({
            url: "classificationPositionsUpdate.php?idleague="+idleague+"&position="+position+"&name=" + name + "&class=" + classN,
            cache: false
        })
                .done(function (html) {


                });
    }
</script>
<table width="100%" id="myTable">
    <thead>
        <tr>
            <th>Posició </th>
            <th>Item</th>
            <th>Class</th>
        </tr>
    </thead>
    <tbody>
        <?
        include ("../includes/config.php");
        include ("../includes/funciones.php");
        conectar();
        $sql = "select l.id, l.name as leagueName, c.position, cp.`name`, cp.className from `classification` c
join leagues l on l.id=c.idleague
left join `classificationPosition_item_league` cp on cp.idleague=l.id and cp.position=c.position
where idseason=8
order by l.id, c.position";
        $resAccount = mysql_query($sql);
        
        $n = 1;
        while ($row = mysql_fetch_array($resAccount)) {
            echo "<tr><td>" . $row['leagueName'] . "</td><td>" . $row['position'] . "</td><td><input onKeyUp='classificationPositionUpdate(".$row['position'].",".$row['id'].")' id='name_".$row['position']."_".$row['id']."' type='text' value='" . $row['name'] . "'></td><td><input onKeyUp='classificationPositionUpdate(".$row['position'].",".$row['id'].")' id='class_".$row['position']."_".$row['id']."' type='text' value='" . $row['className'] . "'></td></tr>";
        }
        ?>

    </tbody>
</table>