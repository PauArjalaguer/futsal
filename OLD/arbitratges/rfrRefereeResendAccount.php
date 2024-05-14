<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();




$sql1 = "select name, email,password from usersAccounts where idReferee=" . $_POST['idReferee'];
//echo $sql1;
$res1 = mysql_query($sql1) or die(mysql_error);
$row=mysql_fetch_array($res1);
$email=$row['email'];
$clubName = $row['name'];
$password=$row['password'];


$subject = "$clubName, aquí tens el teu usuari per a www.futsal.cat";
$out .="<div class=\"section\" style='font-weight:bold;'>Arbitratge</div>";
$out .="<div class=\"content\">Les teves dades per a entrar a www.futsal.cat son <br /><br />Usuari: " . $email . "<br />Password: " . $password . "</div>";


    include ("../mailSender.php");

?>
