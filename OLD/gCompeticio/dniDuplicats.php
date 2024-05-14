<?

include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx = conectar();
$sql = "
   select idplayer, sum(yellowcards) as yellowcards from player_card_match pcm 
join matches m on m.id=pcm.idmatch
join rounds r on r.id=m.idround
where idseason=8 group by idplayer
";
$res = mysql_query($sql);
while ($row = mysql_fetch_array($res)) {
    if ($row['yellowcards'] > 1) {
        if($row['yellowcards'] >=5){
            echo "Insert into player_card_cicles values (null, ".$row['idplayer'].",5,null);<br />";
            $c=$row['yellowcards']-5;
            echo "Insert into player_card_cicles values (null, ".$row['idplayer'].",$c,null);<br />";
           
        }else{
             $c=$row['yellowcards'];
            echo "Insert into player_card_cicles values (null, ".$row['idplayer'].",$c,null);<br />";
        }
        
    }
}
?>
