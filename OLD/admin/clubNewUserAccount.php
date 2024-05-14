<?php
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$pass=substr(md5(uniqid(rand())),0,7);

$res=mysql_query("select name from clubs where id=".$_GET['idClub']);
$row=mysql_fetch_array($res);
$name=$row['name'];

$email=$_GET['email'];
$idRole=$_GET['idRole'];
$idClub=$_GET['idClub'];

mysql_query("INSERT INTO usersAccounts (name, login, password, email, idClub, idRole) values ('".addslashes($name)."','$email', '$pass','$email',$idClub,$idRole)") or die(mysql_error());
$lastId=  mysql_insert_id();
include("userAccountSendMail.php");
?>
