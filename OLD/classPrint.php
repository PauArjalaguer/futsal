<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Federaci&oacute; Catalana de Futsal</title><link rel="stylesheet" type="text/css" href="css/css.css" />
</head>
<script src="scripts/swfobject.js" type="text/javascript"></script>
<script type="text/javascript">
	function imprimeix(){
		print();
		window.opener = top ;
		window.close();
	}
</script>

<body>

<div style="padding:10px; width:750px;">
<?

$out="";
include ("init.php");
include ("includes/test/db.inc");
include("Classes/Competition_class.php");
	$competition=new Competition;
						$competition->idLeague=$_GET['idLeague'];
						$competition->idRound=$_GET['idRound'];
						$data=$competition->getResultsByLeagueAndRound();
						
						
						$roundName=$competition->getNextRoundName();
echo "<div>";

$out .= "\n\n\n<table id=\"taulaclassificacio\" width=\"100%\" cellspacing=0 cellpadding=0 >\n\t<thead>\n\t\t<tr>\n\t\t\t<th colspan=3>";
if($_GET['idRound']>1){
	$prevNumber=$_GET['idRound']-1;
	
	/*$out .= "<a href='competicioPrint.php?idLeague=".$_GET['idLeague']."&idRound=".$_GET['idRound']."' target=_blank><img src='webImages/print.png' ></a>$prevaNumber<img class='button' onclick='competitionShowResultsByLeagueAndRound($prevNumber,".$_GET['idLeague'].");' src='webImages/previous.png'> ";*/
}
$nextNumber=$_GET['idRound']+1;
$out .="Resultats jornada $roundName";

/*$out .=" $nextNaumber<img class='button' onclick='competitionShowResultsByLeagueAndRound($nextNumber,".$_GET['idLeague'].");' src='webImages/next.png'> ";*/
$out ."</th>\n\t\t</tr>\n\t</thead>\n\t<tbody>";


						
						
						if(count($data)>1){
							foreach($data as $match){
								$out .= "\n\t\t<tr>\n\t\t\t<td class='equip' style='width:12px;'>\n\t\t\t\t<div style='background-color:#".$match[6]."; width:6px; height:6px; padding:3px; border:1px solid #fff;'>&nbsp;</div>\n\t\t</td>\n\t\t<td class='equip'>$match[0] - $match[1]</td>\n\t\t<td class='punts'>$match[2] - $match[3]</td>\n\t</tr>";
							}
						}else{
								$out .="<tr><td class='equip' colspan=4>Resultats encara no disponibles</td></tr>";
						}
							$status=new Competition;
						
							//$sd=$status->getAllMatchStatus();
						
							/*$out .= "\n\t<tr><td  class='td'>&nbsp;</td>\n\t\t<td colspan=7 class='td'>";
							foreach($sd as $status){
								$out .= "<div style='float:left; margin-right:15px;'>\n\t\t\t<div style='background-color:#".$status[2]."; width:6px; height:6px; padding:3px; border:1px solid #fff; float:left;'>&nbsp;</div>&nbsp;".$status[1]."</div>\n\t\t";
							}*/
						$out .= "</td>\n\t</tr>";
							
						
						
$out .= "\n\t</tbody>\n</table>";
echo $out; ?>
<table id="taulaclassificacio" cellspacing="0" cellpadding="0" width="100%">
	<thead>
    	<tr>
        	<th colspan="2">Classificació</th><th>Punts</th><th>PJ</th><th>PG</th><th>PE</th><th>PP</th><th>GF</th><th>GC</th></tr>
     </thead>
     <tbody>
<? 
	$competition=new Competition;
	$competition->idLeague=$_GET['idLeague'];
	$data=$competition->getClassificationByLeague();
	
	$n=1;
	$a=1;
	foreach($data as $clas){
	if($a==1){
		$color="#efefef"; $a++;
	}else{
		$color="#dedede"; $a=1;}
	
		echo "<tr>";
		echo "<td class='clasif'>$n</td>";
		echo "<td class='equip' style=\"background-color:$color;\">".$clas[0]."</td>";
		echo "<td class='punts' style=\"background-color:$color; text-align:center;\">".$clas[1]."</td>";
		echo "<td class='td' style=\"background-color:$color;width:15px;\">".$clas[3]."</td>";
		echo "<td class='td' style=\"background-color:$color;width:15px;\">".$clas[4]."</td>";
		echo "<td class='td' style=\"background-color:$color;width:15px;\">".$clas[5]."</td>";
		echo "<td class='td' style=\"background-color:$color;width:15px;\">".$clas[6]."</td>";
		echo "<td class='td' style=\"background-color:$color;width:15px;\">".$clas[7]."</td>";
		echo "<td class='td' style=\"background-color:$color;width:15px;\">".$clas[8]."</td></tr>";
$n++;		
		
	
	}
?></tbody></table></div><div style="clear:both; text-align:center; width:690px; margin-top:30px; border-top:1px solid; padding:30px;" >&copy; Federació Catalana de Futbol Sala 2009</div></div>
<script type="text/javascript">
	imprimeix();
	</script>
</body>
</html>
