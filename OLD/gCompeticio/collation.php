<?php

include ("../includes/config.php");
include ("../includes/funciones.php");
$idcnx = conectar();

$sql = "select id,title, message from announcements";
$res = mysql_query($sql);
while ($row = mysql_fetch_array($res)) {
   $sql2="Update announcements set title='".addslashes(utf8_decode($row['title']))."', message='".addslashes(utf8_decode($row['message']))."' where id=".$row['id'];
   echo $sql2."<br />";
   mysql_query($sql2) or die(mysql_error());
}
/*
$sql = "select id,name,  description from calendar";
$res = mysql_query($sql);
while ($row = mysql_fetch_array($res)) {
   $sql2="Update calendar set name='".utf8_decode($row['name'])."', description='".utf8_decode($row['description'])."' where id=".$row['id'];
   echo $sql2."<br />";
   mysql_query($sql2);
}

$sql = "select id,name,  address,city from clubs";
$sql = mysql_query($sql);
while ($row = mysql_fetch_array($sql)) {
   $sql2="Update clubs set name='".utf8_decode($row['name'])."', address='".utf8_decode($row['address'])."', city='".utf8_decode($row['city'])."' where id=".$row['id'];
   echo $sql2."<br />";
   mysql_query($sql2);
}

$sql = "select id,name from teams";
$res = mysql_query($sql);
while ($row = mysql_fetch_array($res)) {
   $sql2="Update teams set name='".utf8_decode($row['name'])."' where id=".$row['id'];
   //echo $sql2."<br />";
   //mysql_query($sql2);
}

$sql = "select id,name from leagues";
$res = mysql_query($sql);
while ($row = mysql_fetch_array($res)) {
   $sql2="Update leagues set name='".utf8_decode($row['name'])."' where id=".$row['id'];
   echo $sql2."<br />";
   mysql_query($sql2);
}

$sql = "select id,name from clubs";
$res = mysql_query($sql);
while ($row = mysql_fetch_array($res)) {
   $sql2="Update clubs set name='".utf8_decode($row['name'])."' where id=".$row['id'];
   echo $sql2."<br />";
   mysql_query($sql2);
}

$sql = "select id,name,text from selections";
$res = mysql_query($sql);
while ($row = mysql_fetch_array($res)) {
   $sql2="Update selections set name='".utf8_decode($row['name'])."', text='".addslashes(utf8_decode($row['text']))."' where id=".$row['id'];
   echo $sql2."<br />";
   mysql_query($sql2) or die(mysql_error());
}

$sql = "select id,title, description from videos";
$res = mysql_query($sql);
while ($row = mysql_fetch_array($res)) {
   $sql2="Update videos set title='".addslashes(utf8_decode($row['title']))."', description='".addslashes(utf8_decode($row['description']))."' where id=".$row['id'];
   echo $sql2."<br />";
   mysql_query($sql2) or die(mysql_error());
}
*/


?>
