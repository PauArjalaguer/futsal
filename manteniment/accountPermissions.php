<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css"
      href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
<script>
    function accountPermissionUpdate(idSection, idUser, action) {
        $.ajax({
            url: "accountPermissionUpdate.php?idSection=" + idSection + "&idUser=" + idUser + "&action=" + action,
            cache: false
        })
                .done(function (html) {


                });
    }
</script>
<table width="100%" id="myTable">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Login</th>
            <th>Rol</th>
            <?php
            include ("config.php");
            include ("funciones.php");
            conectar();
            $sqlPerm = "select id,section from cPanelSections order by section";
            $resPerm = mysql_query($sqlPerm);
            $array = array();
            while ($row = mysql_fetch_row($resPerm)) {
                array_push($array, $row);
            }
            //print_r($array);
            foreach ($array as $th) {
                echo "\n\t\t<th nowrap style='width:20px;'>" . $th[1] . "</th>";
            }
            echo "\n\t</tr></thead><tbody>\n\t";
            $sqlAccount = "select ua.id, ua.name as name, ua.login, ur.`roleName` as role, c.name as club from usersAccounts ua
	join usersRoles ur on ur.id=ua.idrole
	left join clubs c on c.id=ua.idClub
	left join rfrReferees r on r.id=ua.idReferee
order by idrole, c.name";
//echo $sqlClub . "<br />";
            $resAccount = mysql_query($sqlAccount);
            $n = 1;
            while ($row = mysql_fetch_array($resAccount)) {
                echo "\n\t<tr>\n\t\t<td  nowrap>" . $row['name'] . "</td>\n\t\t<td nowrap>" . $row['login'] . "</td>\n\t\t<td nowrap>" . $row['role'] . "</td>";
                foreach ($array as $th) {
                    $sqlPermission = "select permissionDate from cPanelSections_users where idsection=" . $th[0] . " and idUser=" . $row['id'];
                    $res = mysql_query($sqlPermission);
                    if (mysql_num_rows($res) > 0) {
                        echo "\n\t\t<td align=center><input type='checkbox' onChange=\"accountPermissionUpdate(" . $th[0] . "," . $row['id'] . ",'Disable');\" checked></td>";
                    } else {
                        echo "\n\t\t<td align=center><input type='checkbox' onChange=\"accountPermissionUpdate(" . $th[0] . "," . $row['id'] . ",'Enable');\"></td>";
                    }
                }
                echo "\n\t</tr>";
            }
            ?>   
            </tbody>
</table>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({"pageLength": 500});
    });
</script>

