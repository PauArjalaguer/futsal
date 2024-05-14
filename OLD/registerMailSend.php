<?php
	//include ("includes/db.inc");
	//include ("Classes/Users_class.php");
	require("Classes/class.phpmailer.php");
	require("Classes/class.smtp.php");
	$mail = new PHPMailer();

	$users=new Users;
	
	$users->id=$lastId;
	//$users->id=9;
	//echo $lastId;
	
	$data=$users->getUserById();
	//echo "...................".$_GET['idNew'];
	
	
  $message = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
<title>:: Federaci&oacute; Catalana de Futbol Sala ::</title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"http://www.futsal.cat/css/css.css\" /></head><body><div align=center><div id='shadow'><div style='border:1px solid; width:80%; text-align:left; padding:10px;' align=left>";
	
	
	 $subject="Benvingut a la web de la Federació Catalana de Futbol Sala,$data[1].";
	$message .="<p style='width:100px; padding:10px; float:left;'><img src='http://www.futsal.cat/webImages/LOGO.png' width=100></p> ";
	$message .="<p>T'has registrat a la web <a href='http://www.futsal.cat'>www.futsal.cat.</a></p>";
	$message .="<p>El teu nom d'usuari és: <strong>".$data[1]."</strong></p>";
	$message .="<p>La teva contrassenya és: <strong>".$data[2]."</strong></p>";
	$message .="<p>Necessitaràs introduïr aquestes dades per a poder comentar notícies</p></div></div>";
	$message .="</body></html>";
	
  

 // mail($sendTo, $subject, $message);
  $mail->Mailer = "smtp";

  //Asignamos a Host el nombre de nuestro servidor smtp
  //$mail->Host = "212.36.75.250";
  $mail->Host="smtp.futsal.cat";

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
  $mail->AddAddress("$data[3]");
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
  $ext=$mail->Send();
  //echo $subject;
 
  
  
 
 
?>