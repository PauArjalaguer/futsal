<?php
include ("../includes/config.php");
include ("../includes/funciones.php");
conectar();
$lastSeason = lastSeason();
$lastSeasonId = $lastSeason [0];
$lastSeasonName = $lastSeason [1];

if($_GET['action']=="insert"){
     $sql="INSERT INTO rfrRefereesRecusedByIdTeam (`idReferee`, `idTeam`, `recusationStartTime`, `recusationEndTime`) VALUES ('".$_GET['idReferee']."', '".$_GET['idTeam']."', now(), NULL);";
    }
    else{
      $sql="delete from rfrRefereesRecusedByIdTeam where idReferee= ".$_GET['idReferee']." and idTeam= ".$_GET['idTeam'];
    
    }
     $resReferee = mysql_query($sql) or die(mysql_error());
   header ("Location: ".$_GET['href']);