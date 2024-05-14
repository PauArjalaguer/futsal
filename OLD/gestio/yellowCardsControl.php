<table cellspacing="0"><tr><td>Jugador</td><td>Tarjetes</td><td>Cicles</td></tr><?
    include ("../includes/config.php");
    include ("../includes/funciones.php");
    $idcnx = conectar();
    $sql = "
   select idplayer, sum(yellowcards) as yellowcards, p.name from player_card_match pcm 
join matches m on m.id=pcm.idmatch
join rounds r on r.id=m.idround
join players p on p.id=pcm.idplayer
where idseason=8";
    if ($_GET['date']) {
        $sql .=" and updateddatetime<='" . $_GET['date'] . "' ";
    }
    $sql .= " group by idplayer order by yellowcards desc";
    echo $sql;
    $res = mysql_query($sql);
    while ($row = mysql_fetch_array($res)) {
        if ($row['yellowcards'] < 5) {
            if ($_GET['update']) {
                mysql_query("delete from player_card_cicles where idplayer=" . $row['idplayer']);
                mysql_query("insert into player_card_cicles values (null," . $row['idplayer'] . "," . $row['yellowcards'] . ",null)") or die;
            }
        }
        echo "\n\t<tr>\n\t\t<td style='border-bottom:1px solid;'>" . $row['idplayer'] . " " . $row['name'] . "</td><td style='border-bottom:1px solid;'>" . $row['yellowcards'] . "</td><td style='border-bottom:1px solid;'>";
        $sql2 = "select * from player_card_cicles pcc left join player_bans_round pbr on pbr.id=pcc.idban where pcc.idplayer=" . $row['idplayer'] . " order by pcc.id asc";
        //echo $sql2;
        $res2 = mysql_query($sql2);
        while ($row2 = mysql_fetch_array($res2)) {
            echo $row2['cards'] . " " . $row2['datetime'] . "<br />";
        }

        echo "</td></tr>";
    }
    ?>
