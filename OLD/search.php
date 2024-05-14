<?

//echo $_GET['str'];
echo "<div style='padding:10px;'>";

include ("includes/config.php");
include ("includes/funciones.php");
conectar();
if ($_GET['str'] <> '') {
    $explode = explode(" ", $_GET['str']);
    $words = count($explode);
    if ($words == 1) {
        $sql = "select  n.Id, Title, InsertDate, nc.category from news n join newscategories nc on nc.id=n.categoryid where title like '%" . $_GET['str'] . "%' or content like '%" . $_GET['str'] . "%' order by id desc limit 0,50";
    } else {
        $sql = "SELECT n.Id, Title, InsertDate, nc.category ,MATCH (title,content) AGAINST ('" . $_GET['str'] . "') AS puntuacion  FROM news n  join newscategories nc on nc.id=n.categoryid  WHERE MATCH (title,content) AGAINST ('" . $_GET['str'] . "') ORDER BY puntuacion DESC LIMIT 50";
    }

    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $out .= "<h2>Notícies</h2><table cellspacing=0 width=100% class='searchTable'>";
        while ($row = mysql_fetch_array($res)) {
            if ($n == 1) {
                $n = 2;
            } else {
                $n = 1;
            }
            $out .="\n\t<tr><td class='zebra$n'><a href='" . $serverUrl . "noticia/" . $row['Id'] . "-" . str_replace(" ", "-", treuAccents($row['Title'])) . "'>" . stripslashes($row['Title']) . "</a></td><td class='zebra$n'>" . $row['category'] . "</td><td class='zebra$n'>" . dateformatCup($row['InsertDate']) . "</td></tr>";
            $num = mysql_num_rows($res);
        }
        $out .="</table>";
    }
}

$sql = "select t.id as idTeam, t.name as teamName, c.id as idClub, c.name as clubName from teams t join clubs c on c.id=t.idclub where (t.name like '%".$_GET['str']."%' or c.name like '%".$_GET['str']."%') order by t.name, c.name";
//echo $sql;
$res = mysql_query($sql);
if (mysql_num_rows($res) > 0) {
    $out .= "<h2>Equips i clubs</h2><table cellspacing=0 width=100%  class='searchTable'>";
    while ($row = mysql_fetch_array($res)) {
        if ($n == 1) {
            $n = 2;
        } else {
            $n = 1;
        }
        $out .="\n\t<tr><td class='zebra$n'><a href='" . $serverUrl . "equip/" . $row['idTeam'] . "-" . teamUrlFormat($row['teamName']) . "'> " . $row['teamName'] . "</td><td class='zebra$n'><a href=\"" . $serverUrl . "club/".$row['idClub']."-" . teamUrlFormat($row['clubName']) . "\">" . $row['clubName'] . "</td></tr>";
        $num = mysql_num_rows($res);
    }
    $out .="</table>";
}


$sql = "select  fileName, filepath,inserted, dc.id, dc.title from documents d join downloadcategories dc on dc.id=d.category where fileName like '%" . $_GET['str'] . "%' order by d.id desc";
//echo $sql;
$res = mysql_query($sql);
if (mysql_num_rows($res) > 0) {
    $out .= "<h2>Documents</h2><table cellspacing=0 width=100%  class='searchTable'>";
    while ($row = mysql_fetch_array($res)) {
        if ($n == 1) {
            $n = 2;
        } else {
            $n = 1;
        }
        $out .="\n\t<tr><td class='zebra$n'><a target=_blank href='".$serverUrl."documentacio/".$row['filepath']."'>" . $row['fileName'] . "</td><td class='zebra$n'><a href='".$serverUrl."documents/".$row['id']."-" . teamUrlFormat($row['title'])."' />"  . $row['title'] . "</a></td><td class='zebra$n'>" . dateformatCup($row['inserted']) . "</td></tr>";
        $num = mysql_num_rows($res);
    }
    $out .="</table>";
}

echo utf8_encode($out);
echo "</div>";
?>



