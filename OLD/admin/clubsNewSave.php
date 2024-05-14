<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$pass = substr(md5(uniqid(rand())), 0, 7);

$sql = "insert into clubs (name, city,web, email) values ('" . $_POST['name'] . "','" . $_POST['city'] . "','" . $_POST['web'] . "','" . $_POST['email'] . "')";
$res = mysql_query($sql) or die(mysql_error());
echo $lastId = mysql_insert_id();
if (!empty($_POST['email'])) {
    $res = mysql_query("select name from clubs where id=" . $lastId);
    $row = mysql_fetch_array($res);
    $name = $row['name'];

    $email = $_POST['email'];
    $idRole = 1;
    $idClub = $lastId;

    mysql_query("INSERT INTO usersAccounts (name, login, password, email, idClub, idRole) values ('" . addslashes($name) . "','$email', '$pass','$email',$idClub,$idRole)") or die(mysql_error());
    $lastId = mysql_insert_id();
    include("userAccountSendMail.php");
}
 
 
?>
