<table><?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?
//Connexi�
include ("includes/config.php");
include ("includes/funciones.php");
conectar();

$res = mysql_query("select l.name as league, r.name as round, t1.name as team1, t2.name as team2, datetime,updateddatetime from matches m
join rounds r on r.id=m.idround
join leagues l on l.id=r.idleague
join teams t1 on t1.id=m.idlocal
join teams t2 on t2.id=m.idvisitor
where updateddatetime!='0000-00-00 00:00:00' and l.idseason=8
order by updateddatetime asc
") or die(mysql_error());
while($row = mysql_fetch_array($res)){
   echo "\n\t<tr>\n\t\t<td>".$row['league']."</td>\n\t\t<td>".$row['round']."</td>\n\t\t<td>".$row['team1']." - ".$row['team2']." </td>\n\t\t<td>".$row['updateddatetime']." </td></tr>"; 
}
?>
</table>