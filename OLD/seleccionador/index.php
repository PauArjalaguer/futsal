<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <link rel="stylesheet" href="/resources/demos/style.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="X-UA-Compatible" content="IE=8"/>
        <style>.button {
                float:left;
                /*basic styles*/
                padding:0;
                width: 120px;  height: 55px;  color: white; background-color: #99CF00;
                text-align: center;  font-size: 10px;  line-height: 10px; margin:5px;


                /*gradient styles*/
                background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#99CF00), to(#6DB700));
                background: -moz-linear-gradient(19% 75% 90deg,#6DB700, #99CF00);

                /*border styles*/
                border-left: solid 1px #c3f83a;
                border-top: solid 1px #c3f83a;
                border-right: solid 1px #82a528;
                border-bottom: solid 1px #58701b;
                -moz-border-radius: 10px;
                -webkit-border-radius: 10px;
                border-radius: 10px;
                -webkit-gradient(linear, 0% 0%, 0% 100%, from(#99CF00), to(#6DB700))

            }

            .button h3 {
                font-size: 12px;
                line-height: 9px;
                font-family: helvetica, sans-serif;
            }

            .button p {
                font-size: 9px;
                line-height: 0x;
                font-family: helvetica, sans-serif;
            }

            a {
                text-decoration: none;
                color: fff;
            }

            .button:hover {
                background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#6DB700), to(#99CF00));
                background: -moz-linear-gradient(19% 75% 90deg,#99CF00, #6DB700);
            }</style>
            <?
            include ("../includes/config.php");
            include ("../includes/funciones.php");
            conectar();
            $serverUrl = "http://www.futsal.cat/";
            //$serverUrl = "http://localhost:8081/futsal/";
            include ("../webTitle.php");
            ?>
        <link rel="stylesheet" type="text/css"
              href="<? echo $serverUrl; ?>arbitres/css/css.css" />
        <link rel="stylesheet" type="text/css"
              href="<? echo $serverUrl; ?>css/css.css" />

        <base href="<? echo $serverUrl; ?>" />
        <link rel="alternate" type="application/rss+xml"
              title="Federació Catalana de Futbol Sala - Noticies"
              href="http://www.futsal.cat/rss/newsRss.php" />
        <script type="text/javascript">
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
            function seleccionadorInsertTeam() {
               
                var select=document.getElementById("team");
                var select_index = select.selectedIndex;
                var idTeam=select.options[select_index].value;
                ajax = nuevoAjax();
                ajax.open("GET", "seleccionadorInsertTeam.php?idTeam=" + idTeam, true);
                ajax.onreadystatechange = function() {
                    if (ajax.readyState == 4) {
                        //  alert(ajax.responseText);
                        document.getElementById("selectedTeams").innerHTML = ajax.responseText;
                        search();
                    }
                }
                ajax.send(null)
            }
            function seleccionadorDeleteTeam(idTeam) {


                ajax = nuevoAjax();
                ajax.open("GET", "seleccionadorDeleteTeam.php?idTeam=" + idTeam, true);
                ajax.onreadystatechange = function() {
                    if (ajax.readyState == 4) {
                        //  alert(ajax.responseText);
                        document.getElementById("selectedTeams").innerHTML = ajax.responseText;
                        search();
                    }
                }
                ajax.send(null)
            }
            function seleccionadorInsertDivision() {

                var select=document.getElementById("division");
                var select_index = select.selectedIndex;
                var idDivision=select.options[select_index].value;
                ajax = nuevoAjax();
                ajax.open("GET", "seleccionadorInsertDivision.php?idDivision=" + idDivision, true);
                ajax.onreadystatechange = function() {
                    if (ajax.readyState == 4) {
                        // alert(ajax.responseText);
                        document.getElementById("selectedDivision").innerHTML = ajax.responseText;
                        search();
                    }
                }
                ajax.send(null)
            }
            function seleccionadorDeleteDivision(idDivision) {


                ajax = nuevoAjax();
                ajax.open("GET", "seleccionadorDeleteDivision.php?idDivision=" + idDivision, true);
                ajax.onreadystatechange = function() {
                    if (ajax.readyState == 4) {
                        //  alert(ajax.responseText);
                        document.getElementById("selectedDivision").innerHTML = ajax.responseText;
                        search();
                    }
                }
                ajax.send(null)
            }

            function seleccionadorInsertCity() {

                var select=document.getElementById("city");
                var select_index = select.selectedIndex;
                var idCity=select.options[select_index].value;
                ajax = nuevoAjax();
                ajax.open("GET", "seleccionadorInsertCity.php?idCity=" + idCity, true);
                ajax.onreadystatechange = function() {
                    if (ajax.readyState == 4) {
                        // alert(ajax.responseText);
                        document.getElementById("selectedCity").innerHTML = ajax.responseText;
                        search();
                    }
                }
                ajax.send(null)
            }
            function seleccionadorDeleteCity(idCity) {//alert(idCity);


                ajax = nuevoAjax();
                ajax.open("GET", "seleccionadorDeleteCity.php?idCity=" + idCity, true);
                ajax.onreadystatechange = function() {
                    if (ajax.readyState == 4) {
                        //  alert(ajax.responseText);
                        document.getElementById("selectedCity").innerHTML = ajax.responseText;
                        search();
                    }
                }
                ajax.send(null)
            }
            function seleccionadorInsertAge() {

                var select=document.getElementById("age");
                var select_index = select.selectedIndex;
                var age=select.options[select_index].value;
                ajax = nuevoAjax();
                ajax.open("GET", "seleccionadorInsertAge.php?age=" + age, true);
                ajax.onreadystatechange = function() {
                    if (ajax.readyState == 4) {
                        // alert(ajax.responseText);
                        document.getElementById("selectedAge").innerHTML = ajax.responseText;
                        search();
                    }
                }
                ajax.send(null)
            }
            function seleccionadorDeleteAge(age) {//alert(idCity);


                ajax = nuevoAjax();
                ajax.open("GET", "seleccionadorDeleteAge.php?age=" + age, true);
                ajax.onreadystatechange = function() {
                    if (ajax.readyState == 4) {
                        //  alert(ajax.responseText);
                        document.getElementById("selectedAge").innerHTML = ajax.responseText;
                        search();
                    }
                }
                ajax.send(null)
            }


            function search(){
                var name= document.getElementById("playerName").value;
                ajax = nuevoAjax();
                ajax.open("GET", "seleccionadorSearch.php?playerName=" + name+"&startDate="+document.getElementById("datepickerInit").value+"&endDate="+document.getElementById("datepickerEnd").value, true);
                ajax.onreadystatechange = function() {
                    if (ajax.readyState == 4) {
                        //  alert(ajax.responseText);
                        document.getElementById("results").innerHTML = ajax.responseText
                    }
                }
                ajax.send(null)
            }
        </script>


        <link rel="shortcut icon" href="<? echo $serverUrl; ?>webImages/favicon.ico" />
    </head>

    <body>

        <div id="shadow">
            <div id="web">
                <div style="background-color:#eee;  border-bottom: 1px solid #ddd;">
                    <?
                    /* $res = mysql_query("
                      select id, name from divisions");
                      while ($row = mysql_fetch_array($res)) {
                      echo "<a  class='button' href='seleccionador.php?id=" . $row['id'] . "'>" . $row['name'] . "</a>";
                      } */
                    ?>
                    <div style="background-color:#ddd; margin:5px; padding:15px; vertical-align: middle; ">
                        Nom: <input type="text" id="playerName" style="width:300px;" onKeyUp="search();"></input>
                    </div>
                    <div style="background-color:#ddd; margin:5px; padding:15px;min-height:20px; ">
                        <div style="width:50%; float:left;">
                            Equip: <select id="team" onChange="seleccionadorInsertTeam()">
                                <?
                                $res = mysql_query("
                      select t.id, t.name, d.name as division from teams t
                      join teams_divisions_per_season tds on tds.idteam=t.id
                      join divisions d on d.id=tds.iddivision
                      where idSeason=6
                      order by d.name asc");
                                while ($row = mysql_fetch_array($res)) {
                                    if ($division != $row['division']) {
                                        echo "<option disabled >&bull; " . $row['division'] . "</option>";
                                    }
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    $division = $row['division'];
                                }
                                ?>

                            </select>
                        </div>
                        <div style="width:50%; float:left;">
                            <div id="selectedTeams">
                                <?
                                $sql2 = "select distinct idTeam, t.name from tmpSeleccionadorTeams tst join teams t on t.id=tst.idteam where sessionId='" . session_id() . "'";
                                $res = mysql_query($sql2);
                                while ($row = mysql_fetch_array($res)) {
                                    echo " <div class=\"button\">
	<h3>" . $row['name'] . "</h3>
	<p onClick='seleccionadorDeleteTeam(" . $row['idTeam'] . ");'>Eliminar</p>
</div>";
                                }
                                ?>

                            </div>
                        </div>
                        <div style="clear:both"></div>
                    </div>

                    <div style="background-color:#ddd; margin:5px; padding:15px;min-height:20px; ">
                        <div style="width:50%; float:left;">
                            Divisio: <select id="division"  onChange="seleccionadorInsertDivision()">
                                <?
                                $res = mysql_query("
                     SELECT distinct d.id, d.name from divisions d
 join teams_divisions_per_season
  where idseason=6");
                                while ($row = mysql_fetch_array($res)) {

                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    $division = $row['division'];
                                }
                                ?>

                            </select>
                        </div>
                        <div style="width:50%; float:left;">
                            <div id="selectedDivision">
                                <?
                                $sql2 = "select distinct idDivision, d.name from tmpSeleccionadorDivisions tst join divisions d on d.id=tst.idDivision where sessionId='" . session_id() . "'";
                                $res = mysql_query($sql2);
                                while ($row = mysql_fetch_array($res)) {
                                    echo " <div class=\"button\">
	<h3>" . $row['name'] . "</h3>
	<p onClick='seleccionadorDeleteDivision(" . $row['idDivision'] . ");'>Eliminar</p>
</div>";
                                }
                                ?>
                            </div>
                        </div>
                        <div style="clear:both"></div>
                    </div>

                    <div style="background-color:#ddd; margin:5px; padding:15px;min-height:20px; ">
                        <div style="width:50%; float:left;">
                            Ciutat: <select id="city"  onChange="seleccionadorInsertCity()">
                                <?
                                $res = mysql_query("
                     select distinct city from players p
join player_team_season pts on pts.idplayer=p.id
where idseason=6 and ispayed=1
order by city asc");
                                while ($row = mysql_fetch_array($res)) {
                                    $city = ucwords(strtolower($row['city']));
                                    echo "<option value='" . $city . "'>" . $city . "</option>";
                                }
                                ?>

                            </select>
                        </div>
                        <div style="width:50%; float:left;">
                            <div id="selectedCity">
                                <?
                                $sql2 = "select distinct cityName from tmpSeleccionadorCity tst where sessionId='" . session_id() . "'";
                                $res = mysql_query($sql2);
                                while ($row = mysql_fetch_array($res)) {
                                    echo " <div class=\"button\">
	<h3>" . $row['cityName'] . "</h3>
	<p onClick='seleccionadorDeleteCity(\"" . $row['cityName'] . "\");'>Eliminar</p>
</div>";
                                }
                                ?>
                            </div>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                    <div style="background-color:#ddd; margin:5px; padding:15px;min-height:20px; ">
                        <div style="width:50%; float:left;">
                            Any: <select id="age"  onChange="seleccionadorInsertAge()">
                                <?
                                for ($a = 1960; $a <= 2000; $a++) {
                                    echo "<option value='" . $a . "'>" . $a . "</option>";
                                }
                                ?>

                            </select>
                        </div>
                        <div style="width:50%; float:left;">
                            <div id="selectedAge">
                                <?
                                $sql2 = "select distinct age from tmpSeleccionadorAge tst where sessionId='" . session_id() . "'";
                                $res = mysql_query($sql2);
                                while ($row = mysql_fetch_array($res)) {
                                    echo " <div class=\"button\">
	<h3>" . $row['age'] . "</h3>
	<p onClick='seleccionadorDeleteAge(" . $row['age'] . ");'>Eliminar</p>
</div>";
                                }
                                ?>
                            </div>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                    <div style="background-color:#ddd; margin:5px; padding:15px;min-height:20px; ">
                        <div style="width:50%; float:left;">
                            Data de fitxa entre:
                        
                           <input type="text" id="datepickerInit" /> i <input type="text" id="datepickerEnd" /> <img src="http://png-4.findicons.com/files/icons/1389/g5_system/16/toolbar_find.png"  style="cursor:pointer;" onClick="search();"/>
                        
                        <div style="clear:both"></div>
                    </div>


                </div>
                <div style="clear:both;"></div>
                <div id="results"></div>


            </div>
        </div>

    </body>
    <script type="text/javascript">

        $(function() {
           $( "#datepickerInit" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#datepickerEnd" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#datepickerEnd" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#datepickerInit" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
        });

        search();
    </script>
</html>