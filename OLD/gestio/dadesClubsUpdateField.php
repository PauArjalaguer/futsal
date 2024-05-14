<?
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$_GET['field']="_".$_GET['field'];
$pos=stripos($_GET['field'],"c.");
$_GET['value']=utf8_decode($_GET['value']);
echo $pos."<br />";
$_GET['field']=str_replace("_","",$_GET['field']);
if($pos==1){
$sql="update clubs c set ".$_GET['field']."= '".$_GET['value']."' where id=".$_GET['idClub'];
}else{
$sql ="update club_billing_info bi set ".$_GET['field']."= '".$_GET['value']."' where idClub=".$_GET['idClub'];
}
$res = mysql_query($sql) or die(mysql_error());
echo $sql;
?>	