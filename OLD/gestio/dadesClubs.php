<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
<style>input{border:0; background-color:transparent;}</style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dades clubs</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
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

    function updateField(field, idClub) {
       
        var val=document.getElementById(field+"_"+idClub).value;
        //alert(val);
        ajax = nuevoAjax();
        ajax.open("GET", "dadesClubsUpdateField.php?field="+field+"&value="+val+"&idClub="+idClub, true);
  
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4) {
                
				//alert(ajax.responseText);
                //document.getElementById('block_'+idMatch). style.backgroundColor="#090";

               
            }
        }
        ajax.send(null)
    }
	
</script>
    </head>
    <body>


        <table id="example" class="table table-hover table-condensed table-striped table-bordered" data-page-length='100'>
            <thead><tr>
                   
                    <th>Nom del club</th>
                    <th>Adreça</th>
<th>Ciutat</th>
                    <th>Telefon 1</th>
                    <th>Telefon 2</th>                   
<th>Email</th>

<th>Codi club</th>
<th>Nom factura</th>
<th>CIF</th>
<th>Adreça Factura</th>
<th>Ciutat Factura</th>


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

                $sql = "SELECT c.name, 
       c.address, 
       c.city, 
       c.phone1, 
       c.phone2, 
       c.email, 
       c.clubcode, 
       bi.name    AS fName, 
       bi.nif, 
       bi.address AS fAddress, 
       bi.city    AS fCity ,
c.id
FROM   clubs c 
       JOIN club_billing_info bi 
         ON bi.idclub = c.id 
WHERE  c.id IN (SELECT idclub 
                FROM   teams 
                WHERE  id IN (SELECT idteam 
                              FROM   teams_divisions_per_season 
                              WHERE  idseason = $lastSeasonId)) 
ORDER  BY c.name ASC  ";
                $res = mysql_query($sql) or die(mysql_error());
                if (mysql_num_rows($res) >= 1) {
                    while ($row = mysql_fetch_row($res)) {
                        echo "\n\t<tr>\n\t\t<td><input id=\"c.name_".$row[11]."\" type=\"text\" value=\"" . utf8_encode($row[0]) . "\"></td>\n\t\t";
						echo "<td><input onChange=\"updateField('c.address',".$row[11].")\" id=\"c.address_".$row[11]."\" type=\"text\" value=\"" . utf8_encode($row[1]) . "\"></td>\n\t\t";
						echo "<td><input onChange=\"updateField('c.city',".$row[11].")\" id=\"c.city_".$row[11]."\" type=\"text\" value=\"" . utf8_encode($row[2]) . "\"></td>\n\t\t";
						echo "<td><input onChange=\"updateField('c.phone1',".$row[11].")\" id=\"c.phone1_".$row[11]."\" type=\"text\" value=\"" . utf8_encode($row[3]) . "\"></td>\n\t\t";
						echo "<td><input onChange=\"updateField('c.phone2',".$row[11].")\" id=\"c.phone2_".$row[11]."\" type=\"text\" value=\"" . utf8_encode($row[4]) . "\"></td>\n\t\t";
						echo "<td><input onChange=\"updateField('c.email',".$row[11].")\" id=\"c.email_".$row[11]."\" type=\"text\" value=\"" . utf8_encode($row[5]) . "\"></td>\n\t\t";
						echo "<td><input onChange=\"updateField('c.clubcode',".$row[11].")\" id=\"c.clubcode_".$row[11]."\" type=\"text\" value=\"" . utf8_encode($row[6]) . "\"></td>\n\t\t";
						echo "<td><input onChange=\"updateField('bi.name',".$row[11].")\" id=\"bi.name_".$row[11]."\" type=\"text\" value=\"" . utf8_encode($row[7]) . "\"></td>\n\t\t";
						echo "<td><input onChange=\"updateField('bi.nif',".$row[11].")\" id=\"bi.nif_".$row[11]."\" type=\"text\" value=\"" . utf8_encode($row[8]) . "\"></td>\n\t\t";
						echo "<td><input onChange=\"updateField('bi.address',".$row[11].")\" id=\"bi.address_".$row[11]."\" type=\"text\" value=\"" . utf8_encode($row[9]) . "\"></td>\n\t\t";
						echo "<td><input onChange=\"updateField('bi.city',".$row[11].")\" id=\"bi.city_".$row[11]."\" type=\"text\" value=\"" . utf8_encode($row[10]) . "\"></td>\n\t\t</tr>";
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
				