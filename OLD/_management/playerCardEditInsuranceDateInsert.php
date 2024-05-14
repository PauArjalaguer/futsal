<?

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();

$sql1 ="select id,scan from player_insurance where idPlayer=" . $_GET['idPlayer'] . " and (expirationDate<now() or expirationDate is null) and scan is not null  order by id desc limit 0,1";
  $res1 = mysql_query($sql1);
    $row1 = mysql_fetch_array($res1);
    //echo $row1['id'];

$out .="<h2>Data de caducitat del certificat</h2><br />";
$out .="<input type='text' style='width:45px; margin-right:11px;' class='playerCardEditInput' id='insuranceExpirationDD' value='dd'>";
$out .="<input type='text' style='width:45px; margin-right:11px;' class='playerCardEditInput' id='insuranceExpirationMM' value='mm'>";
$out .="<input type='text' style='width:45px;'  class='playerCardEditInput' id='insuranceExpirationYY' value='yyyy'><div style='clear:both'></div>";
$out .="<input type='button' onClick='playerCardEditInsuranceDateSave(" . $row1['id'] . ",".$_GET['idPlayer'].",".$_GET['idTeam'].");' class='newPlayerNameButton' value='Acceptar' />";

echo utf8_encode($out);
mysql_close();

?>
