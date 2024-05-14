<?
	/*	**** FormMail.php **************************************************************************

	Ruta: FormMail.php
	Data creació: 01/02/2010
	Descripció: Substitut per als FormMail.pl "antics"
	
	@copyright  Copyright (c) 2009, 10denceHispard S.L
	@version    SVN: $Id$

	Control canvis:
		dd/mm/aaaa	Descripció canvi																	Responsable canvi
	
	*********************************************************************************************************/

	/*****************************
	 * Es tracta de fer un FormMail que substitueixi al Matt's script Archive FormMail.pl
	 * essent compatible amb les mateixes variables, i sent tant o més segur contra spammers, phishers, juakers, etc
	 * Agafarem com a principal font de seguretat la web de http://www.mailinjection.com/
	 *****************************/
	
	/***
	 * el FormMail.pl té els següents mètodes
	 * 
# Check Referring URL -> This function is no longer intended to stop abuse
&check_url;

# Retrieve Date	-> res important...
&get_date;

# Parse Form Contents -> fa un filtrat dels camps passats per GET o POST:
    * recipient
    * subject
    * email
    * realname
    * redirect
    * required
    * env_report
    * sort
    * print_config
    * print_blank_fields
    * title
    * return_link_url
    * return_link_title
    * missing_fields_redirect
    * background
    * bgcolor
    * text_color
    * link_color
    * vlink_color
    * alink_color 

&parse_form;

# Check Required Fields -> The following insures that there were no newlines in any fields which will be used in the header
# Fix XSS + HTTP Header Injection for v1.93
# Strip new lines
# Only allow certain handlers to avoid javascript:/data: tricks
# This block of code requires that the recipient address end with a valid domain or e-mail address as defined in @recipients.
&check_required;

# Send E-Mail -> Open The Mail Program
&send_mail;

# Return HTML Page or Redirect User -> 
# Now that we have finished using form values for any e-mail related reasons, we will convert all of the form fields and config values to remove any cross-site scripting security holes.
# If redirect option is used, print the redirectional location header.
# Otherwise, begin printing the response page.
&return_html;

	 */
	
	
	$REFERERS = array('futsal.cat');
	
	$VALID_ENV = array('REMOTE_HOST','REMOTE_ADDR','REMOTE_USER','HTTP_USER_AGENT');
	
	$CONFIG = array('recipient'=>'',		'subject'=>'',
					'email'=>'',			'realname'=>'',
					'redirect'=>'',			'bgcolor'=>'',
					'background'=>'',		'link_color'=>'',
					'vlink_color'=>'',		'text_color'=>'',
					'alink_color'=>'',		'title'=>'',
					'sort'=>'',				'print_config'=>'',
					'required'=>'',			'env_report'=>'',
					'return_link_title'=>'','return_link_url'=>'',
					'print_blank_fields'=>'','missing_fields_redirect'=>'');

	
	if($_SERVER['REQUEST_METHOD']=="POST"){
		$vars = $_POST;
	}elseif($_SERVER['REQUEST_METHOD']=="GET"){
		$vars = $_GET;
	}else{
		error("request_method");
		exit();
	}
	
	//validem el referer, sigui de la seva pròpia web (&check_url)
	$check_referer = false;
	
	$parts_url = parse_url($_SERVER['HTTP_REFERER']);
	if($parts_url['host']!=""){
		foreach($REFERERS as $refri){
			if(eregi("$refri\$",$parts_url['host'])){
				$check_referer = true;
				break;
			}
		}
	}else{
		$check_referer = true;
	}

	if(!$check_referer){
		error("bad_referer");
		exit();
	}
	
	//netejem els valors passats per formulari (&get_date)
	foreach($vars as $key=>$value){
		//netejem els valors que en hexadecimal son < 0x20 (els de control vaja)
		$valor = preg_replace('/[\x00-\x1F]/',' ',trim($value));
		$clau = preg_replace('/[\x00-\x1F]/','',trim($key));
		if($valor=="" || $clau=="") continue;
		//guardem en dos arrays separats els camps de variables dels valors a enviar per email
		if(isset($CONFIG[$clau])){
			$CONFIG[$clau] = $valor;
		}else{
			$FORM[$clau] = $valor;
		}
	}
	
	//aquests tres camps poden tenir multiples valors separats per comes
	$REQUIRED = split(",",$CONFIG['required']);
	$ENV_REPORT = split(",",$CONFIG['env_report']);
	$PRINT_CONFIG = split(",",$CONFIG['print_config']);
	
	foreach($REQUIRED as $key=>$value){
		$value = trim($value);
		$REQUIRED[$key] = $value;
	}
	//només acceptem len ENV_REPORT de VALID_ENV
	foreach($ENV_REPORT as $key=>$value){
		$value = trim($value);
		if(in_array($value,$VALID_ENV)){
			$temp_array[] = $value;
		}
	}
	$ENV_REPORT = $temp_array;
	foreach($PRINT_CONFIG as $key=>$value){
		$value = trim($value);
		$PRINT_CONFIG[$key] = $value;
	}
	
	//només el camp recipient és obligat
	if($CONFIG['recipient']==""){
		error("no_recipient");
		exit();
	}
	//ah i pot ser multiple, separat per comes (,), pero tots ells han de ser dels dominis declarats a $REFERERS
	$recipients = split(",",$CONFIG['recipient']);
	foreach($recipients as $key=>$value){
		if($value=="") continue;
		if(!eregi("^[a-z0-9_-]+[a-z0-9_.-]*@[a-z0-9_-]+[a-z0-9_.-]*\.[a-z]{2,5}\$", $value)){
			error("no_recipient");
			exit();
		}else{
			//ara contrastem el domini amb els de $REFERERS
			$parts = split("@",$value);
			$domini_email = $parts[1];
			$check_referer = false;
			foreach($REFERERS as $refri){
				if(eregi("$refri\$",$domini_email)){
					$check_referer = true;
					break;
				}
			}
			if(!$check_referer){
				error("no_recipient");
				exit();
			}
		}
	}
	
	//ara validem els camps $REQUIRED
	$errors = array();
	foreach($REQUIRED as $key=>$value){
		if($value=="") continue;
		if($value=="email"){
			if(!eregi("^[a-z0-9_-]+[a-z0-9_.-]*@[a-z0-9_-]+[a-z0-9_.-]*\.[a-z]{2,5}\$", $CONFIG['email'])){
				array_push($errors,$value);
			}
		}elseif(isset($CONFIG[$value])){
			if($CONFIG[$value]==""){
				array_push($errors,$value);
			}
		}elseif($FORM[$value]==""){
			array_push($errors,$value);
		}
	}
	if(count($errors)>0){
		error("missing_fields",$errors);
		exit();
	}


	//ara enviem l'email
	$to = $CONFIG['recipient'];
	$from = $CONFIG['email']." (".$CONFIG['realname'].")";
	if($CONFIG['subject']!=""){
		$subject = $CONFIG['subject'];
	}else{
		$subject = "WWW Form Submission";
	}
	
	$data = gmstrftime ("%A, %B %d, %Y at %T", time ());

	$msg  = "Below is the result of your feedback form.  It was submitted by\n";
	$msg .= $CONFIG['realname']." (".$CONFIG['email'].") on $data\n";
	$msg .= "---------------------------------------------------------------------------\n\n";
	
	if(count($PRINT_CONFIG)>0){
		foreach($PRINT_CONFIG as $key=>$value){
			if($value=="") continue;
			$msg .= "$value: ".$CONFIG[$value]."\n\n";
		}
	}
	//TODO: sort (ordre d'ordenació)
	
	if(count($FORM)>0){
		foreach($FORM as $key=>$value){
			if($value=="") continue;
			$msg .= "$key: $value\n\n";
		}
	}
	$msg .= "---------------------------------------------------------------------------\n\n";
	
	if(count($ENV_REPORT)>0){
		foreach($ENV_REPORT as $key=>$value){
			if($value=="") continue;
			$msg .= "$value: ".$_SERVER[$value]."\n\n";
		}
	}
	mail($to,$subject,$msg,"From: $from");


	//i ara "redirigim" si s'escau o simplement mostrem un text final per pantalla
	if($CONFIG['redirect']!=""){
		header("Location: ".$CONFIG['redirect']);
		exit();
	}else{
		echo "<html>\n<head>\n";
		if($CONFIG['title']!=""){
			echo "<title>".$CONFIG['title']."</title>\n";
		}else{
			echo "<title>Thank You</title>\n";
		}
		echo "</head\n<body";
		if($CONFIG['bgcolor']!="") echo " bgcolor=\"".$CONFIG['bgcolor']."\"";
		if($CONFIG['background']!="") echo " background=\"".$CONFIG['background']."\"";
		if($CONFIG['link_color']!="") echo " link=\"".$CONFIG['link_color']."\"";
		if($CONFIG['vlink_color']!="") echo " vlink=\"".$CONFIG['vlink_color']."\"";
		if($CONFIG['alink_color']!="") echo " alink=\"".$CONFIG['alink_color']."\"";
		if($CONFIG['text_color']!="") echo " text=\"".$CONFIG['text_color']."\"";
		echo ">\n<center>\n";
		if($CONFIG['title']!=""){
			echo "<h1>".$CONFIG['title']."</h1>\n";
		}else{
			echo "<h1>Thank You For Filling Out This Form</h1>\n";
		}
		echo "</center>\n";
		
		echo "Below is what you submitted to ".$CONFIG['recipient']." on ";
		echo "$data<p><hr size=1 width=75%><p>\n";
		//TODO: sort (ordre d'ordenació)
		foreach($FORM as $key=>$value){
			if($CONFIG['print_blank_fields']!="" || $value!=""){
				echo "<b>$key:</b> ".$value."<p>\n"; 
			}
		}
		echo "<p><hr size=1 width=75%><p>\n";
		
		if($CONFIG['return_link_url']!="" && $CONFIG['return_link_title']!=""){
			echo "<ul>\n";
			echo "<li><a href=\"".$CONFIG['return_link_url']."\">".$CONFIG['return_link_title']."</a>\n";
			echo "</ul>\n";
		}
		
		echo "<hr size=1 width=75%><p>";
		
		echo "</body>\n</html>\n";
	}



	//functions
	function error($perque,$extra=""){
		
		if($perque=="bad_referer"){
			$referer = strip_tags($_SERVER['HTTP_REFERER']);
			print <<<END
<html>
 <head>
  <title>Bad Referrer - Access Denied</title>
 </head>
 <body bgcolor=#FFFFFF text=#000000>
  <center>
   <table border=0 width=600 bgcolor=#9C9C9C>
    <tr><th><font size=+2>Bad Referrer - Access Denied</font></th></tr>
   </table>
   <table border=0 width=600 bgcolor=#CFCFCF>
    <tr><td>The form attempting to use FormMail
     resides at <tt>$referer</tt>, which is not allowed to access
     this cgi script.<p>
     If you are attempting to configure FormMail to run with this form, you need
     to add the domain to @REFERERS<p>
     <hr size=1>
    </td></tr>
   </table>
  </center>
 </body>
</html>
END;
		}elseif($perque=="request_method"){
			print <<<END
<html>
 <head>
  <title>Error: Request Method</title>
 </head>
 <body bgcolor=#FFFFFF text=#000000>
  <center>
   <table border=0 width=600 bgcolor=#9C9C9C>
    <tr><th><font size=+2>Error: Request Method</font></th></tr>
   </table>
   <table border=0 width=600 bgcolor=#CFCFCF>
    <tr><td>The Request Method of the Form you submitted did not match
     either <tt>GET</tt> or <tt>POST</tt>.  Please check the form and make sure the
     <tt>method=</tt> statement matches <tt>GET</tt> or <tt>POST</tt>.<p>
    </td></tr>
   </table>
  </center>
 </body>
</html>
END;
		}elseif($perque=="no_recipient"){
			print <<<END
<html>
 <head>
  <title>Error: Bad/No Recipient</title>
 </head>
 <body bgcolor=#FFFFFF text=#000000>
  <center>
   <table border=0 width=600 bgcolor=#9C9C9C>
    <tr><th><font size=+2>Error: Bad/No Recipient</font></th></tr>
   </table>
   <table border=0 width=600 bgcolor=#CFCFCF>
    <tr><td>There was no recipient or an invalid recipient specified in the data sent to FormMail.  Please
     make sure you have filled in the <tt>recipient</tt> form field with an e-mail
     address that has been configured in <tt>@recipients</tt>.<hr size=1>
    </td></tr>
   </table>
  </center>
 </body>
</html>
END;
		}elseif($perque=="missing_fields"){
			foreach($extra as $key=>$value){
				$missing_field_list .= $value.", ";
			}
			$missing_field_list = substr($missing_field_list,0,-2);
			print <<<END
<html>
 <head>
  <title>Error: Blank Fields</title>
 </head>
  <center>
   <table border=0 width=600 bgcolor=#9C9C9C>
    <tr><th><font size=+2>Error: Blank Fields</font></th></tr>
   </table>
   <table border=0 width=600 bgcolor=#CFCFCF>
    <tr><td>The following fields were left blank in your submission form:<p>
     <ul>
$missing_field_list
     </ul><br>
     These fields must be filled in before you can successfully submit the form.<p>
     Please use your browser's back button to return to the form and try again.<hr size=1>
    </td></tr>
   </table>
  </center>
 </body>
</html>
END;
		}
	}
?>

