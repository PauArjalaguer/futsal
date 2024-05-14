<?php

ini_set("auto_detect_line_endings", "1");
include "config.php";
include "funciones.php";
$mysqli = conectar();

$fp = fopen($_GET['file'], "r");

while (( $data = fgetcsv($fp, 1000, ",")) !== FALSE) { // Mientras hay líneas que leer...
    $i = 1;
   
    // print_pre($data);
   /* echo "Nom: " . $data[2];
    echo "<br />Telèfon: " . $data[4];
    echo "<br />Email :" . $data[5];echo "<br />Club: " . $data[9] . "<br />"; */
    $club=$data[9];
    
     $sql = "select * from clubs where lower(name)='" . addslashes(strtolower($club)) . "' limit 0,1";
    $res = $mysqli->query($sql) or die(mysqli_error($mysqli));
  
   if($res->num_rows>0){
       //echo "<br />".$data[9]." existeix<hr />";
       $phone=str_replace(" ","",$data[4]);
       $phone=str_replace(".","",$phone);
        $phone=str_replace("-","",$phone);
       $sql2="update clubs set phone1='".intval($phone)."', email='".$data[5]."' where lower(name)='" . addslashes(strtolower($club)). "'";
   echo "Actualitzem dades de $club <hr />";
    $res2 = $mysqli->query($sql2) or die(mysqli_error($mysqli));
       
   }else{
        echo "<span style='color:#c00;'>".$data[9]." no existeix</span><hr />";
   }
}
fclose($fp);
?>
