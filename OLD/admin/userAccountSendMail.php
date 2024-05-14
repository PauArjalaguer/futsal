<?php

//include ("includes/db.inc");
//include ("Classes/Users_class.php");
require("../Classes/class.phpmailer.php");
require("../Classes/class.smtp.php");
$mail = new PHPMailer();

$res = mysql_query("Select name,login, password, email from usersAccounts where id=$lastId") or die(mysql_error());
$row = mysql_fetch_array($res);


//echo $lastId;
//echo $row['email'];

$message = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
$message .="<html xmlns=\"http://www.w3.org/1999/xhtml\">";
$message .="<head>";
$message .="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />";
$message .="<title>:: Federaci&oacute; Catalana de Futbol Sala ::</title>";
$message .="<link rel=\"stylesheet\" type=\"text/css\" href=\"http://www.futsal.cat/css/css.css\" />";
$message .="</head>";
$message .="<body>";
$message .="<div align=center>";
$message .="<div id='shado'>";
$message .="<div style='border:1px solid; width:80%; text-align:left; padding:10px;' align=left>";


$subject = "Benvingut a la web de la Federació Catalana de Futbol Sala," . $row['name'];
$message .="<p style='width:100px; padding:10px; float:left;'>";
$message .="<img src='http://www.futsal.cat/webImages/LOGO.png' width=70></p> ";
$message .="<p>Aquestes són les teves dades d'accés per a la gestió del teu club a <a href='http://www.futsal.cat'>www.futsal.cat.</a></p>";
$message .="<p>El teu nom d'usuari és: <strong>" . $row['login'] . "</strong></p>";
$message .="<p>La teva contrassenya és: <strong>" . $row['password'] . "</strong></p>";
$message .="<p>Pots trobar les instruccions a <a href='http://www.futsal.cat/managementInstruccions.php'>http://www.futsal.cat/managementInstruccions.php</a></p><p>&nbsp;</p>";
$message .="</div>";
$message .="<div style='border:1px solid #000; margin-top:2px; width:80%; text-align:left; padding:10px;background-color:#ddd; color:#fff;'>Federacio Catalana de Futbol Sala C/Guipuscoa 23-25 5è D• 08018 Tel. 93 244 44 03 </div>";
$message .="</div>";
$message .="</body></html>";



// mail($sendTo, $subject, $message);
$mail->Mailer = "smtp";

//Asignamos a Host el nombre de nuestro servidor smtp
//$mail->Host = "212.36.75.250";
$mail->Host = "smtp.futsal.cat";

//Le indicamos que el servidor smtp requiere autenticación
$mail->SMTPAuth = true;

//Le decimos cual es nuestro nombre de usuario y password
$mail->Username = "webfutsal";
$mail->Password = "M0nts3rr@t";

//Indicamos cual es nuestra dirección de correo y el nombre que
//queremos que vea el usuario que lee nuestro correo
$mail->From = "web@futsal.cat";
$mail->FromName = "Federació Catalana de Futbol Sala";
//echo "EMAIL: ".$row['email'];
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
//echo $subject;
?>