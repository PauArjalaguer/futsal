<?php header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();


$sql = "
  SELECT r.name, r.birthdate, r.dni,r.city, r.province, r.isDeleted, ua.email, ua.password, bankAccount FROM rfrReferees r left join usersAccounts ua on ua.idReferee=r.id where r.id=" . $_GET['idReferee'];


$res = mysql_query($sql) or die(mysql_error());

$row = mysql_fetch_array($res);

//print_r($row);
$out .="<div class=\"contentBox\">";
$out .="<div class=\"contentBoxHeader\"><h2 onClick='rfrRefereeEdit(".$_GET['idReferee'].");'>Edició</h2></div>";
$out .="<div class='contentBoxContent'>";
$out .="<table class='playersTable' cellspacing=0><tr><th width=550>Jugador</th><th width=10%>Accio</th></tr>";
$out .="<tr><td class='zebra1'>Nom:</td><td class='zebra1'><input type='text' class='newPlayerNameInput' id='rfrRefereeName' value=\"".stripslashes($row['name'])."\"></td></tr>";
$out .="<tr><td class='zebra1'>DNI:</td><td class='zebra1'><input type='text' class='newPlayerNameInput' id='rfrRefereeDNI' value=\"".$row['dni']."\"></td></tr>";
$out .="<tr><td class='zebra1'>Password:</td><td class='zebra1'><input type='text' class='newPlayerNameInput' id='rfrRefereePassword' disabled value=\"".$row['password']."\"></td></tr>";
$out .="<tr><td class='zebra1'>Ciutat:</td><td class='zebra1'><input type='text' class='newPlayerNameInput' id='rfrRefereeCity' value=\"".$row['city']."\"></td></tr>";
$out .="<tr><td class='zebra1'>Province:</td><td class='zebra1'><input type='text' class='newPlayerNameInput' id='rfrRefereeProvince' value=\"".stripslashes($row['province'])."\"></td></tr>";
$out .="<tr><td class='zebra1'>Email:</td><td class='zebra1'><input type='text' class='newPlayerNameInput' id='rfrRefereeEmail' value=\"".$row['email']."\"></td></tr>";
$out .="<tr><td class='zebra1'>Numero de compte:</td><td class='zebra1'><input type='text' class='newPlayerNameInput' id='rfrRefereeBankAccount' value=\"".$row['bankAccount']."\"></td></tr>";
$out .="<tr><td class='zebra1'>&nbsp;</td><td class='zebra1'><input type='button' class='newPlayerNameInput'  value='Reenviar usuari' onClick='rfrRefereeResendAccount(".$_GET['idReferee'].");' style='width:130px;'> <input type='button' class='newPlayerNameInput'  value='Guardar' onClick='rfrRefereeEditSave(".$_GET['idReferee'].");' style='width:100px;'> <input type='button' class='newPlayerNameInput'  value='Eliminar' onClick='rfrRefereeEditDelete(".$_GET['idReferee'].");' style='width:100px; color:#ff0000;'></td></tr>";


$out .="</table>";
$out .="</div>";
$out .="</div>";


echo stripslashes(utf8_encode($out));
?>
