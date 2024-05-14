<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
print_r($_POST);
$subject = utf8_decode($_POST['name']) . ", aquí tens el teu usuari per a www.futsal.cat";
$out .="<div class=\"section\" style='font-weight:bold;'>Arbitratge</div>";
$out .="<div class=\"content\">Les teves dades per a entrar a www.futsal.cat son <br /><br />Usuari: " . $_POST['email'] . "<br />Password: " . $_POST['password'] . "</div>";
$email = $_POST['email'];
$clubName = utf8_decode($_POST['name']);

$sql = "update rfrReferees set name='" . utf8_decode($_POST['name']) . "',dni='" . $_POST['dni'] . "',city='" . addslashes($_POST['city']) . "', province='" . addslashes(utf8_decode($_POST['province'])) . "',bankAccount='" . addslashes(utf8_decode($_POST['bankAccount'])) . "' where id=" . $_POST['idReferee'];

echo $sql;
$res = mysql_query($sql) or die(mysql_error());

$sql1 = "select email from usersAccounts where idReferee=" . $_POST['idReferee'];
//echo $sql1;
$res1 = mysql_query($sql1) or die(mysql_error);
if (mysql_num_rows($res1) == 0) {
    $sql2 = "INSERT INTO usersAccounts (
            name
            , login
            , password
            , email
            , idRole
            , idReferee) values (
            '" . utf8_decode($_POST['name']) . "'
            ,'" . utf8_decode($_POST['email']) . "'
            ,'" . RandomString() . "'
            ,'" . utf8_decode($_POST['email']). "'
            ,8
            ," . $_POST['idReferee'] . ")";

    echo $sql2;
    mysql_query($sql2) or die(mysql_error());
    include ("../mailSender.php");
} else {
    $row = mysql_fetch_array($res1);
    mysql_query("UPDATE usersAccounts set name='" . utf8_decode($_POST['name']) . "',email='" . utf8_decode($_POST['email']) . "', login='" . $_POST['email'] . "' where idReferee=" . $_POST['idReferee']);
    if ($row['email'] != $_POST['email']) {
        include ("../mailSender.php");
    }
}
?>
