<table cellspacing="0" cellpadding="2">
    <tr>
        <?
        include "../includes/config.php";
        include "../includes/funciones.php";
        conectar();
        $res = mysql_query("select * from newsimages order by id desc");
        $c = 1;
        while ($row = mysql_fetch_array($res)) {
            echo "<td><img class=\"image_button\" onclick=\"imageOptions('" . $row['ImagePath'] . "');\"  style=\"border:1px solid;\" src=\"http://www.futsal.cat/newsImages/thumbs/" . $row['ImagePath'] . "\" width=\"240\" height=\"120\" alt=\"" . $row['name'] . "\"></td>\n";
            if ($c == 3) {
                echo "</tr><tr>";
                $c = 0;
            }
            $c++;
        }
        ?>
    </tr>
</table>