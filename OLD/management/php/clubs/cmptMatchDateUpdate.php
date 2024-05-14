<?php
include("../../Classes/db.inc");
include("../../Classes/Competition_Class.php");
$competition = new Competition();
$competition->idMatch = $_GET['idMatch'];
$_GET['date']=str_replace("/","-",$_GET['date']);
$d=explode("-",$_GET['date']);
$date=$d[2]."-".$d[1]."-".$d[0];
$competition->date = $date;
$competition->time = $_GET['time'];
$competition->complex=$_GET['complex'];
$data=$competition->cmptMatchDateUpdate();
echo $dbconnect=null;
//echo $data;
$data = $competition->cmptMatchDateInfo();
print_r($data);
 $email = $data[4] . ";".$data[6]."; comite.arbitres@futsal.cat";
 $clubName = $data[5];
 $complex=  utf8_encode($data[9]);
 $subject = "Notificació de canvi d' horari " . $data[2] . " - " . $data[3];
    $out .="<div class=\"section\" style='font-weight:bold;'>Canvis d' horari </div>";
    $out .="<table width=\"100%\">";
    $out .="<tr>";
    $out .="<td width=\"45\"><img src=\"http://www.futsal.cat/webImages/clubsImages/" . $row1['image'] . "\" width=\"40\" /></td>";
    $out .="<td valign=\"top\"><span class=\"title\">" . $data[5] . "</span>,<br /> ha canviat l' horari del partit " . $data[2] . " - " . $data[3] . " de la jornada " . $data[7] . "  a <span style='color:#3b3b3b; text-decoration:underline;'>" . $_GET['date'] . " a les " . $_GET['time'] . "h. a $complex </span>.</td>";
    $arbitre = 1;
   
    //$out .="<tr><td colspan=2 align=center><a href=\"http://www.futsal.cat/management/cmptMatchDateChangeAcceptFromEmail.php?mdc=$mdc&string=" . md5($e) . "&idMatch=" . $_POST['idMatch'] . "&email=" . $e . "\"> Acceptar</a>  <a href=\"http://www.futsal.cat/management/cmptMatchDateChangeDenyFromEmail.php?mdc=$mdc&string=" . md5($e) . "&idMatch=" . $_POST['idMatch'] . "&email=" . $e . "\"> Rebutjar</a></td></tr>";
    $out .=" </tr>";
    $out .="</table>";
    echo $out;
    
   include ("../../../mailSender.php");
 
?>
