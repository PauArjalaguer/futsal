<?php
  include "includes/config.php";
  include "includes/funciones.php";
  conectar();
 
  $sql = "select * from news_votes  where ip='" . $_SERVER['REMOTE_ADDR'] . "' and idNew=" . $_GET['idNew'];
  //echo $sql."<br><br>";
  
  $res = mysql_query($sql);
  
  if (mysql_num_rows($res) == 0) {
      $insert = "insert news_votes (ip,idNew,datetime,value) values ('" . $_SERVER['REMOTE_ADDR'] . "'," . $_GET['idNew'] . ",'" . date("Y-m-d H:i:s") . "'," . $_GET['value'] . ")";
	  
      //echo $_COOKIE['ID']." ".$_GET['idNew']." ".date("Y-m-d H:i:s")." ".$_GET['value']."<br>";
      //echo $insert;
      mysql_query($insert) or die(mysql_error());
      //$status = "<b>&bull; Has votado.</b> ";
  } else {
      //$status = "<b style='color:#f00'>&bull; Ya habias votado este archivo.</b>";
  }
  $avg = "SELECT avg( value ) as average, count(1) as number  FROM news_votes where  idNew=" . $_GET['idNew'];
  //echo $sql."<br><br>";
  //echo $_COOKIE['ID']." ".$_GET['idNew']." ".date("Y-m-d H:i:s")." ".$_GET['value']."<br>";
  $avg_res = mysql_query($avg);
  $row_a = mysql_fetch_array($avg_res);
  mysql_query("update news set Rate=".$row_a['average']." where id=".$_GET['idNew']);
  echo $status;
  global $count;
  $count = 1;
  //echo "<b>".$row_a['average']."</b>";
  //echo "&nbsp;".substr($row_a['average'],0,3) ." ";
  
  for ($i = 0; $i < floor($row_a['average']); $i++) {
      echo " <span><img align='absbottom' src=".$serverUrl."webImages/star.png></span>\n";
      $count++;
  }
  
  $rest = 5 - $row_a['average'];
  
  $rest2 = $row_a['average'] - floor($row_a['average']);
  for ($i = 0; $i < $rest2; $i++) {
      echo "<span><img align='absbottom' src=".$serverUrl."webImages/half_star.png></span>\n";
      $count++;
  }
  
  if ($rest2 > 0) {
      $rest--;
  }
  for ($i = 0; $i < $rest; $i++) {
      echo "<span><img align='absbottom' src=".$serverUrl."webImages/star2.png></span>\n";
      $count++;
  }
  echo $row_a['number']." vots.<br> Gracies pel teu vot."
?>