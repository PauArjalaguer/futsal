<?php

include ("../includes/config.php");
include ("../includes/funciones.php");


conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason[0];
$lastSeasonName = $lastSeason[1];

$sql = "select distinct an.id,
    an.notificationText,
    an.notificationDate,
    an.notificationType,
    p.name as playerName,
    t.name as teamName,
    c.name as clubName,
    ua.email as userMail

from admNotifications an
    left join players p on p.id=an.idplayer
    left join teams t on t.id=an.idteam
    left join clubs c on c.id=t.idclub
    left join usersAccounts ua on (ua.idClub=c.id or ua.idclub=an.idclub)
   
    order by ua.id, notificationDate desc";
$res = mysql_query($sql) or die(mysql_error());
$subject = "Actualització fitxes futsal";

$messageH = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
$messageH .="<html xmlns=\"http://www.w3.org/1999/xhtml\">";
$messageH .="<head>";
$messageH .="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />";
$messageH .="<title>:: Federaci&oacute; Catalana de Futbol Sala ::</title>";
$messageH .="<link rel=\"stylesheet\" type=\"text/css\" href=\"http://www.futsal.cat/css/css.css\" />";
$messageH .="</head>";
$messageH .="<body>";
$messageH .="<div align=center>";
$messageH .="<div id='shado'>";
$messageH .="<div style='border:1px solid; width:80%; text-align:left; padding:10px;' align=left>";
$messageH .= "<table>";
$messageB .="</div>";
$messageB .="<div style='border:1px solid #000; margin-top:2px; width:80%; text-align:left; padding:10px;background-color:#ddd; color:#fff;'>Federacio Catalana de Futbol Sala C/ Rogent, 54, entlo. 2 ? 08026 Barcelona Tel. 93 244 44 03 </div>";
$messageB .="</div>";
$messageB .="</body></html>";
$out="";
while ($row = mysql_fetch_array($res)) {
    
    $out .="<tr>";
    $out .="<td>" . $row['notificationDate'] . " ".$row['userMail']."</td>";
    $out .="<td>";
    if ($row['notificationType'] == 'accepted') {
        $out .="La fitxa de " . ucwords(strtolower($row['playerName'])) . " ha estat acceptada";
    } else if ($row['notificationType'] == 'rejected') {
        $out .="La fitxa de " . ucwords(strtolower($row['playerName'])) . " ha estat rebutjada per \"<i>" . $row['notificationText'] . "\"";
    } else if ($row['notificationType'] == 'payment') {
        $out .="La Federació ha rebut l'ingrés de " . $row['notificationText'] . ".";
    }
    $out .="</td>";
    $out .="</tr>";

    if($row['userMail']!=$email){
        $message=$messageH.$out.$messageB;
       // echo $message;
    }
    $email=$row['userMail'];
}







/*
  // mail($sendTo, $subject, $message);
  $mail->Mailer = "smtp";

  //Asignamos a Host el nombre de nuestro servidor smtp
  //$mail->Host = "212.36.75.250";
  $mail->Host = "smtp.futsal.cat";

  //Le indicamos que el servidor smtp requiere autenticación
  $mail->SMTPAuth = true;

  //Le decimos cual es nuestro nombre de usuario y password
  $mail->Username = "webfutsal";
  $mail->Password = "futsal2014";

  //Indicamos cual es nuestra dirección de correo y el nombre que
  //queremos que vea el usuario que lee nuestro correo
  $mail->From = "web@futsal.cat";
  $mail->FromName = "Federació Catalana de Futbol Sala";

  //el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar
  //una cuenta gratuita, por tanto lo pongo a 30
  //$mail->Timeout=30;
  //Indicamos cual es la dirección de destino del correo
  $mail->AddAddress($row['email']);
  $mail->AddBCC('web@futsal.cat');
  //$mail->AddAddress("pau@arjalaguer.cat");
  //Asignamos asunto y cuerpo del mensaje
  //El cuerpo del mensaje lo ponemos en formato html, haciendo
  //que se vea en negrita
  $mail->Subject = $subject;
  $mail->Body = $message;

  //Definimos AltBody por si el destinatario del correo no admite email con formato html
  $mail->AltBody = $message;

  //se envia el mensaje, si no ha habido problemas
  //la variable $exito tendra el valor true
  $ext = $mail->Send();
  //echo $subject; */

echo $message;
?>
