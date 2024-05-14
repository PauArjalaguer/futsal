a<?
include ("includes/db.inc");
include("Classes/Competition_class.php");

$out .= "\n\n\n<table id=\"taulaclassificacio\" width=\"100%\" cellspacing=0 cellpadding=3 >\n\t<thead>\n\t\t<tr>\n\t\t\t<th colspan=3>Resultats jornada $roundName</th>\n\t\t</tr>\n\t</thead>\n\t<tbody>";


						$competition=new Competition;
						$competition->idLeague=$_GET['id'];
						$data=$competition->getResultsByLeagueAndRound();
						
						foreach($data as $match){
							$out .= "\n\t\t<tr>\n\t\t\t<td class='equip' style='width:12px;'>\n\t\t\t\t<div style='background-color:#".$match[6]."; width:6px; height:6px; padding:3px; border:1px solid #fff;'>&nbsp;</div>\n\t\t</td>\n\t\t<td class='equip'>$match[0] - $match[1]</td>\n\t\t<td class='punts'>$match[2] - $match[3]</td>\n\t</tr>";
						}
						$status=new Competition;
						
						$sd=$status->getAllMatchStatus();
						
						$out .= "\n\t<tr>\n\t\t<td colspan=7 class='td'>";
						foreach($sd as $status){
							$out .= "<div style='float:left; margin-right:15px;'>\n\t\t\t<div style='background-color:#".$status[2]."; width:6px; height:6px; padding:3px; border:1px solid #fff; float:left;'>&nbsp;</div>&nbsp;".$status[1]."</div>\n\t\t";
						}
						$out .= "</td>\n\t</tr>";
							
						
						
$out .= "\n\t</tbody>\n</table>";
echo utf8_encode($out); ?>