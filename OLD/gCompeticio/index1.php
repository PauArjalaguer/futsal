<?
			include ("../includes/config.php");
		 	include ("../includes/funciones.php");
			conectar();
			
			if(isset($_POST['submitNewMatch'])){
			
				$q="insert into matches (idLocal, idVisitor,idRound) values (".$_POST['local'].",".$_POST['visitor'].",".$_GET['r'].")";
				//echo $q;
				mysql_query($q) or die(mysql_error());
			}
			?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="../css/css.css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>

<div align="center">
	<div id="web">
    	<div id="divisions" style="float:left; width:150px;">
        	<h1>Divisio</h1>
        	<? 
			
			$res=mysql_query("select * from leagues");
			while($row=mysql_fetch_array($res)){
				echo "<a href='?d=".$row['id']."'>".$row['name']."</a><br>";
			}
			?>
		</div> 
        <div id="rounds" style="float:left; width:150px;">
        	<h1>Jornada</h1>
        	<? 
			$n=0;
			$res=mysql_query("select * from rounds where idleague=".$_GET['d']);
			while($row=mysql_fetch_array($res)){$n++;
				echo "<a href='?d=".$_GET['d']."&r=".$row['id']."'>".$n."</a><br>";
			}
			?>
		</div>
        <div id="matches" style="float:left;width:350px;"> 
        	<h1>Partits</h1>
            <? 
		
			$res=mysql_query("select m.id as id, t1.id as localId,t1.name as localTeam, t2.id as visitorId,t2.name as visitorTeam from matches m join teams t1 on m.idlocal=t1.id join teams t2 on t2.id=m.idvisitor where  idround=".$_GET['r']);
			while($row=mysql_fetch_array($res)){
				echo "<a href='result.php?m=".$row['id']."&r=".$_GET['r']."&d=".$_GET['d']."'>".$row['localTeam']." - ".$row['visitorTeam']."</a><br>";
			}
			
			?>
            <form action="<? echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>" enctype="multipart/form-data" method="post" >
            <table cellpadding="3" cellspacing="0">
            	<tr>
                	<td>Equip Local</td><td><select name="local">
            			<? //$res=mysql_query("select * from teams_divisions td join teams t on t.id=td.idTeam where  idDivision=".$_GET['d']);
						$query="select * from teams_divisions td join teams t on t.id=td.idTeam where (t.id not in (select idlocal from matches where idround=".$_GET['r'].") and t.id not in (select idvisitor from matches where idround=".$_GET['r'].")) and idDivision=".$_GET['d'];
						//echo $query;
						$res=mysql_query("select * from teams_divisions td join teams t on t.id=td.idTeam where (t.id not in (select idlocal from matches where idround=".$_GET['r'].") and t.id not in (select idvisitor from matches where idround=".$_GET['r'].")) and idDivision=".$_GET['d']) or die(mysql_error());
							while($row=mysql_fetch_array($res)){
								echo "<option value=\"".$row['idTeam']."\">".$row['name']."</option>\n";
							}
						?>
                        </select>
                     </td>
                     </tr><tr>
                     <td>Equip Visitant</td><td><select name="visitor">
            			<? $res=mysql_query("select * from teams_divisions td join teams t on t.id=td.idTeam where (t.id not in (select idlocal from matches where idround=".$_GET['r'].") and t.id not in (select idvisitor from matches where idround=".$_GET['r'].")) and idDivision=".$_GET['d']) or die(mysql_error());
							while($row=mysql_fetch_array($res)){
								echo "<option value=\"".$row['idTeam']."\">".$row['name']."</option>\n";
							}
						?>
                        </select>
                        
                     </td>
                     </tr>
                     <tr>
                     <td><input type="submit" name="submitNewMatch" value="Enviar" /></td>
                </tr>
             </table>
        	        
        	
</body>
</html>
