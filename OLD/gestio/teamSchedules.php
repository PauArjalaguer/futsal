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

    function updateDateTimeAndPlace(idTeam) {
        var selectDay=document.getElementById("playingDaySelectForTeam_"+idTeam);
		var select_index = selectDay.selectedIndex;
		var day_select_value=selectDay.options[select_index].value;
		
        
        var time=document.getElementById("playingHourInputForTeam_"+idTeam).value;
        var select=document.getElementById("playingComplexSelectForTeam_"+idTeam);
       
        var select_index = select.selectedIndex;
        var select_value=select.options[select_index].value;
        // alert(date+" "+time+" "+select_value)

        
        ajax = nuevoAjax();
        ajax.open("GET", "teamSchedulesUpdate.php?day="+day_select_value+"&time="+time+"&complex="+select_value+"&idTeam="+idTeam, true);
  
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4) {
                
				//alert(ajax.responseText);
                //document.getElementById('block_'+idMatch). style.backgroundColor="#090";

               
            }
        }
        ajax.send(null)
    }
	
function complexFilter(idTeam){

	document.getElementById("playingComplexSelectForTeam_"+idTeam).options.length=0;
  
	var word=document.getElementById("complexSelectFilter_"+idTeam).value;
	var ajax19 = nuevoAjax();
	ajax19.open("GET", "teamSchedulesComplexSelectFilter.php?word="+word, true);
	ajax19.onreadystatechange=function() {
        if (ajax19.readyState==4) {
            var statusXML=ajax19.responseXML;
            var l=statusXML.getElementsByTagName("pavello").length;
            for(i=0;i<=l;i++){
                var id=statusXML.getElementsByTagName("id")[i].childNodes[0].nodeValue;
                var name=statusXML.getElementsByTagName("name")[i].childNodes[0].nodeValue;
               document.getElementById("playingComplexSelectForTeam_"+idTeam).options[i]=new Option(name, id, true, false);
            }
        }
    }
	//
    ajax19.send(null)
}
</script>
<table cellpadding=0 cellspacing=0 border=0 style='font-family:"Helvetica","Trebuchet MS", Arial;'><?php

include "../includes/config.php";
include "../includes/funciones.php";
$idcnx = conectar();

$lastSeason = lastSeason ();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];

  $query = "select id, complexName from complex order by complexname";
                            $result = mysql_query($query) or die(mysql_error());
                            $data_array = array();
                            while ($query_data = mysql_fetch_row($result)) {
                                array_push($data_array, $query_data);
								
                            }

$sql = "select t.id as teamId, t.name as teamName, playingDay, playingHour, playingComplex, idLeague, l.name as leagueName from teams t 
join teams_leagues_per_season tds on tds.idteam=t.id
join leagues l on l.id=tds.idleague
 where tds.idseason=$lastSeasonId 
order by l.order, l.id, t.name";
$res = mysql_query($sql);
while($row = mysql_fetch_array($res)){
if($row['leagueName']!=$leagueName){
	echo "\n\n<tr><td>&nbsp;</td></tr><tr colspan=6>\n\t<td><b>".$row['leagueName']."</b></td>\n</tr>";
	}
echo "\n<tr>\n\t<td>".$row['teamName']."</td>";
echo "\n\t<td>\n\t\t<select id=\"playingDaySelectForTeam_".$row['teamId']."\" onChange=\"updateDateTimeAndPlace(".$row['teamId'].")\" >";
$sat="";
$sun="";
if($row['playingDay']==7){
	$sat="selected";
}else if($row['playingDay']==1){
	$sun="selected";
}
echo "\n\t\t\t<option ></option>";
echo "\n\t\t\t<option value=\"7\" $sat>Dissabte</option>";
echo "\n\t\t\t<option value=\"1\" $sun>Diumenge</option>";
echo "\n\t\t</select></td>";

echo "\n\t<td><input style=\"width:50px; text-align:center;\" type='text' id=\"playingHourInputForTeam_".$row['teamId']."\" value=\"".$row['playingHour']."\" onBlur=\"updateDateTimeAndPlace(".$row['teamId'].")\"></td>";

echo "\n\t<td>\n\t\t<select style='width:300px;' id=\"playingComplexSelectForTeam_".$row['teamId']."\" onChange=\"updateDateTimeAndPlace(".$row['teamId'].")\">";
$sat="";
$sun="";
echo "\n\t\t\t<option ></option>";
 foreach ($data_array as $complex) {
	if ($row['playingComplex'] == $complex[0]) {
		$selected = "selected";
    } else {
		$selected = "";
                                        }
                                        echo "\n\t\t<option $selected value='" . $complex[0] . "'>" . $complex[1] . "</option>";
                                    }
echo "\n\t\t</select><input type=\"text\" id=\"complexSelectFilter_".$row['teamId']."\" onKeyUp=\"complexFilter(".$row['teamId'].")\"></td>";

echo "\n</tr>";
$leagueName=$row['leagueName'];
}




?>
</table>
