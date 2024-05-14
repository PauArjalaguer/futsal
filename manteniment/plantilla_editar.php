<script>
    function nuevoAjax() {
        var xmlhttp = false;
        try {
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (E) {
                xmlhttp = false;
            }
        }

        if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
            xmlhttp = new XMLHttpRequest();
        }
        return xmlhttp;
    }
    function modificar(idMatch, type) {
        var value= document.getElementById(type+"_"+idMatch).value;
        //alert(idMatch+" "+type+" "+value);

        ajax = nuevoAjax();

        ajax.open("GET", "plantilla_modificar.php?idMatch=" + idMatch+"&value="+value+"&type="+type, true);

        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4) {

             

            }

        }
        ajax.send(null)

    }
</script>

<table>
    <?php
    $username = "pauweb";
    $password = "M0nts3rr@t";
    $hostname = "localhost";
//connection to the database
    $dbhandle = mysql_connect($hostname, $username, $password)
            or die("Unable to connect to MySQL");
    $selected = mysql_select_db("futsal", $dbhandle)
            or die("Could not select examples");

    $result = mysql_query("SELECT id,idRound, idLocal, idVisitor FROM league_patterns where idPattern=" . $_GET['idPattern']);
//fetch tha data from the database
    while ($row = mysql_fetch_array($result)) {
        if ($row['idRound'] != $round) {
            echo "\n<tr>\n\t<td colspan=3>Jornada " . $row['idRound'] . "</td><tr>";
        }
        echo "\n<tr>\n\t<td><input onKeyUp=\"modificar(".$row['id'].",'idLocal');\" type='number' id=\"idLocal_" . $row['id'] . "\" value= " . $row['idLocal'] . "></td>";
        echo "\n\t<td><input onKeyUp=\"modificar(".$row['id'].",'idVisitor');\"type='number' id=\"idVisitor_" . $row['id'] . "\" value=" . $row['idVisitor'] . "></td>\n\n</tr>";
        $round = $row['idRound'];
    }
    ?>
</table>